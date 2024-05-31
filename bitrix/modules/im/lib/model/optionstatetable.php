<?php

namespace Bitrix\Im\Model;

use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\SystemException;


/**
 * Class OptionStateTable
 *
 * Fields:
 * <ul>
 * <li> GROUP_ID int mandatory
 * <li> NAME string(64) mandatory
 * <li> VALUE string(255) optional
 * </ul>
 *
 * @package Bitrix\Im
 **/

class OptionStateTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName(): string
	{
		return 'b_im_option_state';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 * @throws SystemException
	 */
	public static function getMap(): array
	{
		return [
			'GROUP_ID' => (new IntegerField('GROUP_ID', [
				'primary' => true,
			])),
			'NAME' => (new StringField('NAME', [
				'primary' => true,
				'validation' => [__CLASS__, 'validateName'],
			])),
			'VALUE' => (new StringField('VALUE', [
				'validation' => [__CLASS__, 'validateValue']
			])),
		];
	}

	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 * @throws ArgumentTypeException
	 */
	public static function validateName(): array
	{
		return [
			new LengthValidator(null, 64),
		];
	}

	/**
	 * Returns validators for VALUE field.
	 *
	 * @return array
	 * @throws ArgumentTypeException
	 */
	public static function validateValue(): array
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}
