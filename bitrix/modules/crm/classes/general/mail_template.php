<?php
/*
 * CRM Mail template
 */

class CAllCrmMailTemplate
{
	// FIELDS -->
	const CACHE_NAME = 'CRM_MAIL_TEMPLATE_CACHE';
	const TABLE_ALIAS = 'T';
	private static $FIELDS = null;
	private static $ERRORS = array();
	// <-- FIELDS
	protected  static function GetFields()
	{
		if(!isset(self::$FIELDS))
		{
			$ownerJoin = 'LEFT JOIN b_user U1 ON T.OWNER_ID = U1.ID';
			self::$FIELDS = array(
				'ID' => array('FIELD' => 'T.ID', 'TYPE' => 'int'),
				'OWNER_ID' => array('FIELD' => 'T.OWNER_ID', 'TYPE' => 'int'),
				'OWNER_LOGIN' => array('FIELD' => 'U1.LOGIN', 'TYPE' => 'string', 'FROM' => $ownerJoin),
				'OWNER_NAME' => array('FIELD' => 'U1.NAME', 'TYPE' => 'string', 'FROM' => $ownerJoin),
				'OWNER_LAST_NAME' => array('FIELD' => 'U1.LAST_NAME', 'TYPE' => 'string', 'FROM' => $ownerJoin),
				'OWNER_SECOND_NAME' => array('FIELD' => 'U1.SECOND_NAME', 'TYPE' => 'string', 'FROM' => $ownerJoin),
				'ENTITY_TYPE_ID' => array('FIELD' => 'T.ENTITY_TYPE_ID', 'TYPE' => 'int'),
				'SCOPE' => array('FIELD' => 'T.SCOPE', 'TYPE' => 'int'),
				'IS_ACTIVE' => array('FIELD' => 'T.IS_ACTIVE', 'TYPE' => 'char'),
				'TITLE' => array('FIELD' => 'T.TITLE', 'TYPE' => 'string'),
				'EMAIL_FROM' => array('FIELD' => 'T.EMAIL_FROM', 'TYPE' => 'string'),
				'SUBJECT' => array('FIELD' => 'T.SUBJECT', 'TYPE' => 'string'),
				'BODY_TYPE' => array('FIELD' => 'T.BODY_TYPE', 'TYPE' => 'int'),
				'BODY' => array('FIELD' => 'T.BODY', 'TYPE' => 'string'),
				'SING_REQUIRED' => array('FIELD' => 'T.SING_REQUIRED', 'TYPE' => 'char'),
				'SORT' => array('FIELD' => 'T.SORT', 'TYPE' => 'int'),
				'CREATED' => array('FIELD' => 'T.CREATED', 'TYPE' => 'datetime'),
				'LAST_UPDATED' => array('FIELD' => 'T.LAST_UPDATED', 'TYPE' => 'datetime'),
				'AUTHOR_ID' => array('FIELD' => 'T.AUTHOR_ID', 'TYPE' => 'int'),
				'EDITOR_ID' => array('FIELD' => 'T.EDITOR_ID', 'TYPE' => 'int')
			);
		}

		return self::$FIELDS;
	}
	// CRUD -->
	public static function Add(&$arFields, $options = null)
	{
		global $DB;

		self::ClearErrors();

		if(!is_array($options))
		{
			$options = array();
		}

		if (!self::CheckFields('ADD', $arFields, 0))
		{
			return false;
		}

		if(isset($arFields['ID']))
		{
			unset($arFields['ID']);
		}

		if(!isset($arFields['SORT']))
		{
			$arFields['SORT'] = 100;
		}

		if(!isset($arFields['SCOPE']) || !CCrmMailTemplateScope::IsDefined($arFields['SCOPE']))
		{
			$arFields['SCOPE'] = CCrmMailTemplateScope::Personal;
		}

		if(!isset($arFields['IS_ACTIVE']))
		{
			$arFields['IS_ACTIVE'] = 'N';
		}

		if(!isset($arFields['TITLE']))
		{
			$arFields['TITLE'] = '';
		}

		if(!isset($arFields['EMAIL_FROM']))
		{
			$arFields['EMAIL_FROM'] = '';
		}

		if(!isset($arFields['SUBJECT']))
		{
			$arFields['SUBJECT'] = '';
		}

		if (!isset($arFields['ENTITY_TYPE_ID']))
			$arFields['ENTITY_TYPE_ID'] = 0;

		if (!isset($arFields['BODY_TYPE']))
			$arFields['BODY_TYPE'] = \CCrmContentType::BBCode;

		if(!isset($arFields['BODY']))
		{
			$arFields['BODY'] = '';
		}

		if(!isset($arFields['SING_REQUIRED']))
		{
			$arFields['SING_REQUIRED'] = 'N';
		}

		if (isset($arFields['CREATED']))
		{
			unset($arFields['CREATED']);
		}

		if (isset($arFields['LAST_UPDATED']))
		{
			unset($arFields['LAST_UPDATED']);
		}

		$arFields['~CREATED'] = $arFields['~LAST_UPDATED'] = $DB->CurrentTimeFunction();

		$currentUserID =  isset($options['CURRENT_USER_ID']) ? intval($options['CURRENT_USER_ID']) : CCrmPerms::GetCurrentUserID();

		if(!isset($arFields['AUTHOR_ID']))
		{
			$arFields['AUTHOR_ID'] = $currentUserID;
		}

		$arFields['EDITOR_ID'] = $arFields['AUTHOR_ID'];

		$ID = $DB->Add(CCrmMailTemplate::TABLE_NAME, $arFields, array('BODY'));
		if($ID === false)
		{
			self::RegisterError(array('text' => 'DB connection was lost.'));
			return false;
		}

		if($arFields['ACCESS'])
		{
			\Bitrix\Crm\MailTemplate\MailTemplateAccess::setLimitedAccessToTemplate($ID, $arFields['ACCESS']);
		}

		$arFields['ID'] = $ID = intval($ID);

		self::updateUserFields($ID, $arFields);

		$rsEvents = GetModuleEvents('crm', 'OnMailTemplateAdd');
		while ($arEvent = $rsEvents->Fetch())
		{
			ExecuteModuleEventEx($arEvent, array($ID, &$arFields));
		}

		return $ID;
	}

	/**
	 * @throws Exception
	 */
	public static function Update($ID, &$arFields, $options = null)
	{
		global $DB;

		self::ClearErrors();

		if(!is_array($options))
		{
			$options = array();
		}
		$ID = (int)$ID;

		self::prepareAttachmentsForOldTemplate($ID);

		if (!self::CheckFields('UPDATE', $arFields, $ID))
		{
			return false;
		}

		if(isset($arFields['SCOPE']) && !CCrmMailTemplateScope::IsDefined($arFields['SCOPE']))
		{
			$arFields['SCOPE'] = CCrmMailTemplateScope::Personal;
		}

		if (isset($arFields['CREATED']))
		{
			unset($arFields['CREATED']);
		}

		if (isset($arFields['LAST_UPDATED']))
		{
			unset($arFields['LAST_UPDATED']);
		}

		$arFields['~LAST_UPDATED'] = $DB->CurrentTimeFunction();

		if(isset($arFields['AUTHOR_ID']))
		{
			unset($arFields['AUTHOR_ID']);
		}

		$currentUserID =  isset($options['CURRENT_USER_ID']) ? intval($options['CURRENT_USER_ID']) : CCrmPerms::GetCurrentUserID();

		if(!isset($arFields['EDITOR_ID']))
		{
			$arFields['EDITOR_ID'] = $currentUserID;
		}

		$arRecordBindings = array();
		if(isset($arFields['BODY']))
		{
			$arRecordBindings['BODY'] = $arFields['BODY'];
		}

		$tableName = CCrmMailTemplate::TABLE_NAME;
		$sql = 'UPDATE '.$tableName.' SET '.$DB->PrepareUpdate($tableName, $arFields).' WHERE ID = '.$ID;
		if(!empty($arRecordBindings))
		{
			$DB->QueryBind($sql, $arRecordBindings, false);
		}
		else
		{
			$DB->Query($sql, false, 'File: '.__FILE__.'<br>Line: '.__LINE__);
		}

		self::updateUserFields($ID, $arFields);

		$curAccessRelation = \Bitrix\Crm\MailTemplate\MailTemplateAccess::getAccessDataByTemplateID($ID);

		if($arFields['ACCESS'])
		{
			\Bitrix\Crm\MailTemplate\MailTemplateAccess::setLimitedAccessToTemplate($ID, $arFields['ACCESS'], $curAccessRelation);
		}

		$rsEvents = GetModuleEvents('crm', 'OnMailTemplateUpdate');
		while ($arEvent = $rsEvents->Fetch())
		{
			ExecuteModuleEventEx($arEvent, array($ID, &$arFields));
		}

		return true;
	}

	public static function updateUserFields($id, &$fields)
	{
		global $USER_FIELD_MANAGER;

		$USER_FIELD_MANAGER->update('CRM_MAIL_TEMPLATE', $id, $fields);

		if (!empty($fields['UF_ATTACHMENT']) && \CModule::includeModule('disk'))
		{
			$files = $USER_FIELD_MANAGER->getUserFieldValue('CRM_MAIL_TEMPLATE', 'UF_ATTACHMENT', $id);
			$files = !empty($files) && is_array($files) ? $files : array();

			$diskUfManager = \Bitrix\Disk\Driver::getInstance()->getUserFieldManager();
			$diskUfManager->loadBatchAttachedObject($files);
			foreach ($files as $attachedId)
			{
				if ($attachedObject = $diskUfManager->getAttachedObjectById($attachedId))
				{
					$fields['BODY'] = preg_replace(
						sprintf('/bxacid:n%u/', $attachedObject->getObjectId()),
						sprintf('bxacid:%u', $attachedId),
						$fields['BODY'], -1, $count
					);
					if ($count > 0)
						$bodyUpdated = true;
				}
			}

			if (!empty($bodyUpdated))
			{
				$bodyFields = array('BODY' => $fields['BODY']);
				\CCrmMailTemplate::update($id, $bodyFields);
			}
		}
	}

	public static function Delete($ID, $options = null)
	{
		global $DB;

		self::ClearErrors();

		$ID = intval($ID);
		/* $options: RFU
		 * if(!is_array($options))
		{
			$options = array();
		}
		*/

		$events = GetModuleEvents('crm', 'OnBeforeMailTemplateDelete');
		while ($event = $events->Fetch())
		{
			if (ExecuteModuleEventEx($event, array($ID)) === false)
			{
				return false;
			}
		}

		if(!self::Exists($ID))
		{
			self::RegisterError(new CCrmMailTemplateError(CCrmMailTemplateError::NotExists, array('ID' => $ID)));
			return false; //is not found
		}

		CCrmEntityHelper::RemoveCached(self::CACHE_NAME, $ID);
		$result = $DB->Query('DELETE FROM '.CCrmMailTemplate::TABLE_NAME.' WHERE ID = '.$ID, true) !== false;

		if($result)
		{
			$rsEvents = GetModuleEvents('crm', 'OnMailTemplateDelete');
			while ($arEvent = $rsEvents->Fetch())
			{
				ExecuteModuleEventEx($arEvent, array($ID));
			}
			\Bitrix\Crm\MailTemplate\MailTemplateAccess::deleteAccessRelationsByTemplateID((int)$ID);
		}

		return $result;
	}
	// <-- CRUD
	// Service -->
	protected static function RegisterError($error)
	{
		self::$ERRORS[] = $error;
	}
	protected static function ClearErrors()
	{
		if(!empty(self::$ERRORS))
		{
			self::$ERRORS = array();
		}
	}
	public static function CheckFields($action, &$arFields, $ID)
	{
		global $USER_FIELD_MANAGER;

		self::ClearErrors();

		//global $DB;
		if(!(is_array($arFields) && count($arFields) > 0))
		{
			self::RegisterError(array('text' => 'Fields is not specified.'));
			return false;
		}

		if (!$USER_FIELD_MANAGER->checkFields('CRM_MAIL_TEMPLATE', $ID, $arFields))
		{
			return false;
		}

		if($action == 'ADD')
		{
			if(!(isset($arFields['OWNER_ID']) && $arFields['OWNER_ID'] > 0))
			{
				self::RegisterError(
					new CCrmMailTemplateError(
						CCrmMailTemplateError::FieldNotSpecified, array('FIEILD_ID' => 'OWNER_ID')
					)
				);
			}

			if (!isset($arFields['TITLE']) || trim($arFields['TITLE']) === '')
			{
				self::RegisterError(
					new CCrmMailTemplateError(
						CCrmMailTemplateError::FieldNotSpecified, array('FIEILD_ID' => 'TITLE')
					)
				);
			}
		}
		else//if($action == 'UPDATE')
		{
			if(!self::Exists($ID))
			{
				self::RegisterError(
					new CCrmMailTemplateError(
						CCrmMailTemplateError::NotExists, array('ID' => $ID)
					)
				);
			}

			if (isset($arFields['TITLE']) && trim($arFields['TITLE']) === '')
			{
				self::RegisterError(
					new CCrmMailTemplateError(
						CCrmMailTemplateError::FieldNotSpecified, array('FIEILD_ID' => 'TITLE')
					)
				);
			}
		}
		return self::GetErrorCount() == 0;
	}
	public static function GetErrorCount()
	{
		return count(self::$ERRORS);
	}
	public static function GetErrors()
	{
		return self::$ERRORS;
	}
	public static function GetErrorMessages()
	{
		$result = array();
		foreach(self::$ERRORS as &$error)
		{
			$result[] = $error->GetText();
		}
		unset($error);
		return $result;
	}
	// <-- Service
	// Contract -->
	public static function GetList($arOrder = array(), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array())
	{
		$lb = new CCrmEntityListBuilder(
			CCrmMailTemplate::DB_TYPE,
			CCrmMailTemplate::TABLE_NAME,
			self::TABLE_ALIAS,
			self::GetFields()
		);

		return $lb->Prepare($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields);
	}
	public static function GetByID($ID)
	{
		$ID = intval($ID);

		if($ID <= 0)
		{
			return null;
		}

		$res = CCrmEntityHelper::GetCached(self::CACHE_NAME, $ID);
		if (is_array($res))
		{
			return $res;
		}

		$dbRes = self::GetList(array(), array('ID' => $ID));

		if(is_array($res = $dbRes->Fetch()))
		{
			CCrmEntityHelper::SetCached(self::CACHE_NAME, $ID, $res);
		}

		return $res;
	}
	public static function Exists($ID)
	{
		$ID = intval($ID);
		if($ID <= 0)
		{
			return false;
		}

		$dbRes = self::GetList(array(), array('ID'=> $ID), false, false, array('ID'));
		return is_array($dbRes->Fetch());
	}

	public static function getUserAvailableTemplatesList(int $ownerTypeId, int $userId = 0)
	{
		if($userId <= 0)
		{
			$userId = \Bitrix\Crm\Service\Container::getInstance()->getContext()->getUserId();
		}

		$typeIds = [$ownerTypeId, 0];
		return \CCrmMailTemplate::getList(
			[
				'SORT' => 'ASC',
				'ID'=> 'DESC',
			],
			[
				'IS_ACTIVE' => 'Y',
				'@ENTITY_TYPE_ID' => $typeIds,
				'__INNER_FILTER_SCOPE' => [
					'LOGIC' => 'OR',
					'__INNER_FILTER_PERSONAL' => ['OWNER_ID' => $userId],
					'__INNER_FILTER_COMMON' => ['SCOPE' => \CCrmMailTemplateScope::Common],
					'__INNER_FILTER_LIMITED' => ['@ID' => \Bitrix\Crm\MailTemplate\MailTemplateAccess::getAllAvailableSharedTemplatesId($userId)],
				],
			],
			false,
			false,
			[
				'TITLE',
				'SCOPE',
				'ENTITY_TYPE_ID',
				'BODY_TYPE',
			]
		);
	}
	public static function GetLastUsedTemplateID($entityTypeID, $userID = 0)
	{
		$entityTypeID = intval($entityTypeID);
		if(!CCrmOwnerType::IsDefined($entityTypeID))
		{
			return 0;
		}

		$entityTypeName = mb_strtolower(CCrmOwnerType::ResolveName($entityTypeID));
		$userID = intval($userID);
		if($userID <= 0)
		{
			$userID = CCrmSecurityHelper::GetCurrentUserID();
		}
		return intval(CUserOptions::GetOption('crm', "last_used_email_template_{$entityTypeName}", 0, $userID));
	}
	public static function SetLastUsedTemplateID($templateID, $entityTypeID, $userID = 0)
	{
		$templateID = intval($templateID);
		$entityTypeID = intval($entityTypeID);
		$entityTypeName = mb_strtolower(CCrmOwnerType::ResolveName($entityTypeID));
		$userID = intval($userID);
		if ($userID <= 0)
		{
			$userID = CCrmSecurityHelper::GetCurrentUserID();
		}

		$key = "last_used_email_template_{$entityTypeName}";
		if ($templateID <= 0)
		{
			CUserOptions::DeleteOption('crm', $key, false, $userID);
		}

		if ($templateID !== intval(CUserOptions::GetOption('crm', $key, $entityTypeID, $userID)))
		{
			CUserOptions::SetOption('crm', $key, $templateID, false, $userID);
		}
	}
	// <-- Contract

	public static function ConvertHtmlToBbCode($html)
	{
		$eventID = AddEventHandler('main', 'TextParserBeforeTags', Array('CAllCrmMailTemplate', '__ConvertHtmlToBbCode'));

		$parser = new CTextParser();
		$parser->allow = array(
			'HTML' => 'N', 'ANCHOR' => 'Y', 'BIU' => 'Y',
			'IMG' => 'Y', 'QUOTE' => 'Y', 'CODE' => 'Y',
			'FONT' => 'Y', 'LIST' => 'Y', 'SMILES' => 'Y',
			'NL2BR' => 'Y', 'VIDEO' => 'Y', 'TABLE' => 'Y',
			'CUT_ANCHOR' => 'Y', 'ALIGN' => 'Y'
		);

		$html = $parser->convertText($html);
		$html = htmlspecialcharsback($html);
		$html = preg_replace("/\<br\s*\/*\>/i".BX_UTF_PCRE_MODIFIER, "\n", $html);
		$html = preg_replace("/&nbsp;/i".BX_UTF_PCRE_MODIFIER, ' ', $html);
		$html = preg_replace("/\<[^>]+>/".BX_UTF_PCRE_MODIFIER, '', $html);
		$html = htmlspecialcharsbx($html);

		RemoveEventHandler('main', 'TextParserBeforeTags', $eventID);
		return $html;
	}

	public static function __ConvertHtmlToBbCode(&$text, &$parser)
	{
		$text = preg_replace(array("/\</".BX_UTF_PCRE_MODIFIER, "/\>/".BX_UTF_PCRE_MODIFIER), array('<', '>'), $text);
		$text = preg_replace("/\<br\s*\/*\>/i".BX_UTF_PCRE_MODIFIER, "", $text);
		$text = preg_replace("/\<(\w+)[^>]*\>(.+?)\<\/\\1[^>]*\>/is".BX_UTF_PCRE_MODIFIER, "\\2", $text);
		$text = preg_replace("/\<*\/li\>/i".BX_UTF_PCRE_MODIFIER, "", $text);
		$text = str_replace(array("<", ">"),array("<", ">"), $text);
		$parser->allow = array();
		return true;
	}

	private static function prepareAttachmentsForOldTemplate(int $id)
	{
		global $USER_FIELD_MANAGER;
		global $DB;

		$files = $USER_FIELD_MANAGER->getUserFieldValue('CRM_MAIL_TEMPLATE', 'UF_ATTACHMENT', $id);
		$files = !empty($files) && is_array($files) ? $files : [];

		foreach ($files as $file)
		{
			$DB->Query("UPDATE b_disk_attached_object SET MODULE_ID = 'crm', ENTITY_TYPE = 'Bitrix\\\\Crm\\\\Integration\\\\Disk\\\\MailTemplateConnector' WHERE ID = " . (int)$file);
		}
	}
}
class CCrmMailTemplateError
{
	// CODES -->
	const None = 0;
	const NotExists = 1;
	const FieldNotSpecified = 2;
	// <-- CODES
	private $code = self::None;
	private $params = array();

	function __construct($code, $params = null)
	{
		$this->code = intval($code);
		if(is_array($params))
		{
			$this->params = $params;
		}
	}
	public function GetCode()
	{
		return $this->code;
	}
	private function GetParam($name, $default)
	{
		return isset($this->params[$name]) ? $this->params[$name] : $default;
	}
	public function GetText()
	{
		IncludeModuleLangFile(__FILE__);
		switch($this->code)
		{
			case self::NotExists:
				return GetMessage('CRM_MAIL_TEMPLATE_ERROR_NOT_EXISTS', array('#ID#' => $this->GetParam('ID', 0)));
			case self::FieldNotSpecified:
				return GetMessage('CRM_MAIL_TEMPLATE_ERROR_FIELD_NOT_SPECIFIED', array('#FIELD#' => GetMessage('CRM_MAIL_TEMPLATE_FIELD_'.$this->GetParam('FIEILD_ID', ''))));
			default:
				return '';
		}
	}
}
class CCrmMailTemplateScope
{
	public const Undefined = 0;
	public const Personal = 1;
	public const Common = 2;
	public const Limited = 3;

	private static $ALL_DESCRIPTIONS = array();

	public static function IsDefined($scope)
	{
		$scope = (int)$scope;
		return $scope >= self::Undefined && $scope <= self::Limited;
	}

	public static function GetAllDescriptions()
	{
		if(!self::$ALL_DESCRIPTIONS[LANGUAGE_ID])
		{
			IncludeModuleLangFile(__FILE__);
			self::$ALL_DESCRIPTIONS[LANGUAGE_ID] = array(
				//self::Undefined => '',
				self::Personal => GetMessage('CRM_MAIL_TEMPLATE_SCOPE_PERSONAL_MSGVER_1'),
				self::Common => GetMessage('CRM_MAIL_TEMPLATE_SCOPE_COMMON_MSGVER_1'),
				self::Limited => GetMessage('CRM_MAIL_TEMPLATE_SCOPE_LIMITED_MSGVER_1'),
			);
		}

		return self::$ALL_DESCRIPTIONS[LANGUAGE_ID];
	}

	public static function GetDescription($scope)
	{
		$scope = intval($scope);
		$all = self::GetAllDescriptions();
		return isset($all[$scope]) ? $all[$scope] : '';
	}

	public static function setTemplateScope(array $accessEntities): int
	{
		if(!empty($accessEntities))
		{
			if (in_array(\Bitrix\Crm\MailTemplate\MailTemplateAccess::ALL_USERS_ENTITY, $accessEntities, true))
			{
				return self::Common;
			}
			else
			{
				return self::Limited;
			}
		}
		else
		{
			return self::Personal;
		}
	}
}
