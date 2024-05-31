<?
namespace Webprostor\Core;

use Bitrix\Main\Config\Option,
	Bitrix\Main\Localization\Loc;

class Iblock
{
	const MODULE_ID = 'webprostor.core';
	
	public static function OnBeforeIBlockDeleteHandler($ID)
	{
		$IBLOCK_DENY_DELETION_IBLOCKS = Option::get(self::MODULE_ID, 'IBLOCK_DENY_DELETION_IBLOCKS');
		$iblockDenied = unserialize($IBLOCK_DENY_DELETION_IBLOCKS);
		if($iblockDenied !== false && in_array($ID, $iblockDenied))
		{
			global $APPLICATION;
			$APPLICATION->throwException(Loc::getMessage('WEBPROSTOR_CORE_IBLOCK_DENY_DELETION_IBLOCKS'));
			return false;
		}
	}
	
	public static function OnBeforeIBlockPropertyDeleteHandler($ID)
	{
		$IBLOCK_DENY_DELETION_PROPERTIES = Option::get(self::MODULE_ID, 'IBLOCK_DENY_DELETION_PROPERTIES');
		$iblockDenied = unserialize($IBLOCK_DENY_DELETION_PROPERTIES);
		if($iblockDenied !== false)
		{
			$propertyInfo = \CIBlockProperty::GetByID($ID)->Fetch();
			if(in_array($propertyInfo['IBLOCK_ID'], $iblockDenied))
			{
				global $APPLICATION;
				$APPLICATION->throwException(Loc::getMessage('WEBPROSTOR_CORE_IBLOCK_DENY_DELETION_PROPERTIES'));
				return false;
			}
		}
	}
	
	public static function OnBeforeIBlockSectionDeleteHandler($ID)
	{
		$IBLOCK_DENY_DELETION_SECTIONS = Option::get(self::MODULE_ID, 'IBLOCK_DENY_DELETION_SECTIONS');
		$iblockDenied = unserialize($IBLOCK_DENY_DELETION_SECTIONS);
		if($iblockDenied !== false)
		{
			$sectionInfo = \CIBlockSection::GetByID($ID)->Fetch();
			if(in_array($sectionInfo['IBLOCK_ID'], $iblockDenied))
			{
				global $APPLICATION;
				$APPLICATION->throwException(Loc::getMessage('WEBPROSTOR_CORE_IBLOCK_DENY_DELETION_SECTIONS'));
				return false;
			}
		}
	}
	
	public static function OnBeforeIBlockElementDeleteHandler($ID)
	{
		$IBLOCK_DENY_DELETION_ELEMENTS = Option::get(self::MODULE_ID, 'IBLOCK_DENY_DELETION_ELEMENTS');
		$iblockDenied = unserialize($IBLOCK_DENY_DELETION_ELEMENTS);
		if($iblockDenied !== false)
		{
			$IBLOCK_ID = \CIBlockElement::GetIBlockByID($ID);
			if(in_array($IBLOCK_ID, $iblockDenied))
			{
				global $APPLICATION;
				$APPLICATION->throwException(Loc::getMessage('WEBPROSTOR_CORE_IBLOCK_DENY_DELETION_ELEMENTS'));
				return false;
			}
		}
	}
}