<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Catalog\Access\AccessController;
use Bitrix\Catalog\Access\ActionDictionary;
use Bitrix\Catalog\CatalogIblockTable;
use Bitrix\Catalog\Component\BaseForm;
use Bitrix\Catalog\Config\State;
use Bitrix\Catalog\Product\Store\CostPriceCalculator;
use Bitrix\Catalog\v2\IoC\ServiceContainer;
use Bitrix\Catalog\VatTable;
use Bitrix\Crm\Integration\Sale\Reservation;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Catalog\Component\UseStore;
use Bitrix\Catalog\Config\Feature;
use Bitrix\Catalog\Config\Options\CheckRightsOnDecreaseStoreAmount;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Engine\ActionFilter\ContentType;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Error;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

class CCrmConfigCatalogSettings extends \CBitrixComponent implements Controllerable
{
	private const OPTION_DEFAULT_QUANTITY_TRACE = 'default_quantity_trace';
	private const OPTION_DEFAULT_CAN_BUY_ZERO = 'default_can_buy_zero';
	private const OPTION_DEFAULT_SUBSCRIBE = 'default_subscribe';
	private const OPTION_PRODUCT_CARD_SLIDER_ENABLED = 'product_card_slider_enabled';
	private const OPTION_DEFAULT_PRODUCT_VAT_INCLUDED = 'default_product_vat_included';

	private const PRODUCT_SLIDER_HELP_LINK_EU = 'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=178&LESSON_ID=25692';
	private const PRODUCT_SLIDER_HELP_LINK_RU = 'https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=48&LESSON_ID=25488';

	/**
	 * @inheritDoc
	 */
	public function executeComponent()
	{
		if (!(
			$this->checkModules()
			&& $this->hasPermissions())
		)
		{
			$this->includeComponentTemplate('denied');
			return;
		}

		$this->arResult = $this->getResult();
		$this->includeComponentTemplate();
	}

	/**
	 * @inheritDoc
	 */
	public function configureActions()
	{
		return [
			'initialize' => [
				'+prefilters' => [
					new ContentType([ContentType::JSON]),
				],
			],
			'save' => [
				'+prefilters' => [
					new ContentType([ContentType::JSON]),
				],
			],
		];
	}

	/**
	 * @return AjaxJson
	 */
	public function initializeAction(): AjaxJson
	{
		$errorResponse = $this->checkActionError();
		if (!is_null($errorResponse))
		{
			return $errorResponse;
		}

		return $this->respondSuccess($this->getResult());
	}

	/**
	 * @param array $values
	 * @return AjaxJson
	 * @throws \Bitrix\Main\ArgumentOutOfRangeException
	 * @throws \Bitrix\Main\Access\Exception\UnknownActionException
	 */
	public function saveAction(array $values): AjaxJson
	{
		$errorResponse = $this->checkActionError();
		if (!is_null($errorResponse))
		{
			return $errorResponse;
		}

		if (
			isset($values['defaultProductVatId'])
			&& !$this->updateDefaultVat((int)$values['defaultProductVatId'])
		)
		{
			return $this->respondError('Error saving VAT');
		}

		if (is_array($values['reservationSettings']))
		{
			foreach ($values['reservationSettings'] as $entityCode => $reservationSettingsValue)
			{
				Reservation\Config\EntityFactory::make($entityCode)
					->setValues($reservationSettingsValue)
					->save();
			}
		}

		if (isset($values['checkRightsOnDecreaseStoreAmount']))
		{
			if ($values['checkRightsOnDecreaseStoreAmount'] === true)
			{
				CheckRightsOnDecreaseStoreAmount::set(
					CheckRightsOnDecreaseStoreAmount::ENABLED_VALUE
				);
			}
			else
			{
				CheckRightsOnDecreaseStoreAmount::set(
					CheckRightsOnDecreaseStoreAmount::DISABLED_VALUE
				);
			}
		}

		if (
			!empty($values['costPriceCalculationMethod'])
			&& Feature::isStoreBatchEnabled()
			&& !State::isProductBatchMethodSelected()
		)
		{
			CostPriceCalculator::setMethod($values['costPriceCalculationMethod']);
			if (!\Bitrix\Catalog\StoreBatchTable::getRow(['select' => ['ID']]))
			{
				\Bitrix\Main\Update\Stepper::bindClass(
					'\Bitrix\Catalog\Update\ProductBatchConverter',
					'catalog',
					0
				);
			}
		}

		$catalogOptionSettings = [
			'defaultQuantityTrace' => self::OPTION_DEFAULT_QUANTITY_TRACE,
			'defaultCanBuyZero' => self::OPTION_DEFAULT_CAN_BUY_ZERO,
			'defaultSubscribe' => self::OPTION_DEFAULT_SUBSCRIBE,
			'defaultProductVatIncluded' => self::OPTION_DEFAULT_PRODUCT_VAT_INCLUDED,
		];

		if ($this->isCanEnableProductCardSlider())
		{
			$catalogOptionSettings['productCardSliderEnabled'] = self::OPTION_PRODUCT_CARD_SLIDER_ENABLED;
		}

		foreach ($catalogOptionSettings as $key => $optionName)
		{
			if (!isset($values[$key]))
			{
				continue;
			}

			Option::set('catalog', $optionName, ($values[$key] ? 'Y' : 'N'));
		}

		return $this->respondSuccess();
	}

	/**
	 * @return AjaxJson|null
	 */
	private function checkActionError(): ?AjaxJson
	{
		if (!$this->checkModules())
		{
			return $this->respondError('Required modules have not been found');
		}

		if (!$this->hasPermissions())
		{
			return $this->respondError('Access denied');
		}

		return null;
	}

	/**
	 * @inheritDoc
	 */
	protected function listKeysSignedParameters()
	{
		return [];
	}

	protected function getInventoryManagementFeatureCode(): ?string
	{
		return Feature::getInventoryManagementHelpLink()['FEATURE_CODE'] ?? null;
	}

	/**
	 * @return array
	 */
	private function getResult(): array
	{
		$accessController = AccessController::getCurrent();
		$defaultProductVatId = $this->getDefaultProductVatId() ?? BaseForm::NOT_SELECTED_VAT_ID_VALUE;

		return [
			'isStoreControlUsed' => \Bitrix\Catalog\Config\State::isEnabledInventoryManagement(),
			'isStoreBatchUsed' => Feature::isStoreBatchEnabled(),
			'isBitrix24' => static::isBitrix24(),
			'productsCnt' => $this->getProductsCnt(),
			'reservationEntities' => $this->getReservationEntities(),
			'defaultQuantityTrace' => Option::get('catalog', self::OPTION_DEFAULT_QUANTITY_TRACE) === 'Y',
			'defaultCanBuyZero' => Option::get('catalog', self::OPTION_DEFAULT_CAN_BUY_ZERO) === 'Y',
			'defaultSubscribe' => Option::get('catalog', self::OPTION_DEFAULT_SUBSCRIBE) === 'Y',
			'productCardSliderEnabled' => Option::get('catalog', self::OPTION_PRODUCT_CARD_SLIDER_ENABLED) === 'Y', // TODO: delete if not need
			'isCanEnableProductCardSlider' => $this->isCanEnableProductCardSlider(),
			'busProductCardHelpLink' => static::getBusProductCardHelpLink(),
			'defaultProductVatIncluded' => Option::get('catalog', self::OPTION_DEFAULT_PRODUCT_VAT_INCLUDED) === 'Y',
			'configCatalogSource' => \Bitrix\Main\Context::getCurrent()->getRequest()->get('configCatalogSource'),
			'checkRightsOnDecreaseStoreAmount' => CheckRightsOnDecreaseStoreAmount::isEnabled(),
			'vats' => $this->getVats(),
			'defaultProductVatId' => $defaultProductVatId,
			'hasAccessToCatalogSettings' => $accessController->check(ActionDictionary::ACTION_CATALOG_SETTINGS_ACCESS),
			'hasAccessToReservationSettings' => $accessController->check(ActionDictionary::ACTION_RESERVED_SETTINGS_ACCESS),
			'hasAccessToInventoryManagmentSettings' => $accessController->check(ActionDictionary::ACTION_RESERVED_SETTINGS_ACCESS),
			'costPriceCalculationMethod' => CostPriceCalculator::getMethod(),
		];
	}

	private function isCanEnableProductCardSlider(): bool
	{
		if (static::isBitrix24())
		{
			return Option::get('catalog', self::OPTION_PRODUCT_CARD_SLIDER_ENABLED) !== 'Y';
		}

		return true;
	}

	/**
	 * @return int
	 */
	private function getProductsCnt(): int
	{
		$result = 0;

		$catalogList = \CCatalogProductSettings::getCatalogList();
		foreach ($catalogList as $catalog)
		{
			$result += $catalog['COUNT'];

		}

		return $result;
	}

	/**
	 * @return array
	 */
	private function getReservationEntities(): array
	{
		$result = [];

		$reservationEntities = Reservation\Config\EntityFactory::makeAllKnown();
		foreach ($reservationEntities as $reservationEntity)
		{
			$result[] = [
				'code' => $reservationEntity::getCode(),
				'name' => $reservationEntity::getName(),
				'settings' => [
					'scheme' => $reservationEntity::getScheme(),
					'values' => $reservationEntity->getValues(),
				],
			];
		}

		return $result;
	}

	/**
	 * @return bool
	 */
	private function checkModules(): bool
	{
		return (
			Loader::includeModule('crm')
			&& Loader::includeModule('catalog')
			&& Loader::includeModule('sale')
		);
	}

	/**
	 * @return bool
	 */
	private function hasPermissions(): bool
	{
		$accessController = \Bitrix\Catalog\Access\AccessController::getCurrent();

		return
			(
				$accessController->check(ActionDictionary::ACTION_CATALOG_READ)
				&& $accessController->check(ActionDictionary::ACTION_CATALOG_SETTINGS_ACCESS)
			)
			||
			$accessController->check(ActionDictionary::ACTION_RESERVED_SETTINGS_ACCESS)
		;
	}

	/**
	 * @param string $message
	 * @param string $code
	 * @return AjaxJson
	 */
	private function respondError(string $message, $code = ''): AjaxJson
	{
		return AjaxJson::createError(
			new ErrorCollection([new Error($message, $code)])
		);
	}

	/**
	 * @param null $data
	 * @return AjaxJson
	 */
	private function respondSuccess($data = null): AjaxJson
	{
		return AjaxJson::createSuccess($data);
	}

	private static function isBitrix24(): bool
	{
		static $isBitrix24Included;

		if (!isset($isBitrix24Included))
		{
			$isBitrix24Included = Loader::includeModule('bitrix24');
		}

		return $isBitrix24Included;
	}

	private static function getBusProductCardHelpLink(): string
	{
		if (static::isBitrix24())
		{
			return '';
		}

		if (in_array(self::getZone(), ['ru', 'by', 'kz'], true))
		{
			return self::PRODUCT_SLIDER_HELP_LINK_RU;
		}

		return self::PRODUCT_SLIDER_HELP_LINK_EU;
	}

	private static function getZone(): string
	{
		if (self::isBitrix24())
		{
			$zone = \CBitrix24::getPortalZone();
		}
		else
		{
			$row = Bitrix\Main\Localization\LanguageTable::getList([
				'select' => ['ID'],
				'filter' => [
					'=DEF' => 'Y',
					'=ACTIVE' => 'Y'
				]
			])->fetch();

			if ($row)
			{
				return $row['ID'];
			}
		}

		return 'en';
	}

	/**
	 * Returns the default VAT ID from the default product catalog.
	 *
	 * @return int|null
	 */
	private function getDefaultProductVatId(): ?int {
		$defaultProductCatalogId = \Bitrix\Crm\Product\Catalog::getDefaultId();

		if (!$defaultProductCatalogId)
		{
			return null;
		}

		$defaultProductCatalogInfo = ServiceContainer::getIblockInfo($defaultProductCatalogId);

		return $defaultProductCatalogInfo?->getVatId();
	}

	/**
	 * Returns a list of active VAT rates [ID, NAME].
	 *
	 * @return array
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 * @throws \Bitrix\Main\SystemException
	 */
	private function getVats(): array {
		$vatList = [];
		$vatList[] = [
			'ID' => BaseForm::NOT_SELECTED_VAT_ID_VALUE,
			'NAME' => Loc::getMessage("CRM_CONFIG_CATALOG_SETTINGS_VAT_NOT_SELECTED"),
		];

		$iterator = VatTable::getList([
			'select' => [
				'ID',
				'NAME',
			],
			'filter' => [
				'=ACTIVE' => 'Y',
			],
			'order' => [
				'SORT' => 'ASC',
				'NAME' => 'ASC',
			]
		]);

		while ($row = $iterator->fetch())
		{
			$vatList[] = [
				'ID' => $row['ID'],
				'NAME' => htmlspecialcharsbx($row['NAME']),
			];
		}

		unset($row, $iterator);

		return $vatList;
	}

	/**
	 * Update the default VAT in the database.
	 *
	 * @param int $defaultProductVatId
	 * @return bool
	 * @throws \Bitrix\Main\Access\Exception\UnknownActionException
	 */
	private function updateDefaultVat(int $defaultProductVatId): bool
	{
		try {
			$defaultProductCatalogId = \Bitrix\Crm\Product\Catalog::getDefaultId();
			$updateResult = CatalogIblockTable::update(
				$defaultProductCatalogId,
				[
					'VAT_ID' => $defaultProductVatId,
				]
			);
		} catch (Exception) {
			return false;
		}

		if (!$updateResult->isSuccess()) {
			return false;
		}

		return true;
	}
}
