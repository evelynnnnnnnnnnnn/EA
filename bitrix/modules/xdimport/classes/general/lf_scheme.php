<?php

use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);

class CAllXDILFScheme
{
	public $LAST_ERROR = '';

	public function CheckFields($action, &$arFields): bool
	{
		global $DB;
		$this->LAST_ERROR = "";
		$aMsg = array();

		if (
			(
				(
					$action === "update"
					&& array_key_exists("TYPE", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["TYPE"] === ''
		)
		{
			$aMsg[] = [
				"id" => "TYPE",
				"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_TYPE"),
			];
		}

		if (
			(
				(
					$action === "update"
					&& array_key_exists("ENTITY_TYPE", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["ENTITY_TYPE"] === ''
		)
		{
			$aMsg[] = [
				"id" => "ENTITY_TYPE",
				"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_ENTITY_TYPE"),
			];
		}

		if (
			(
				(
					$action === "update"
					&& array_key_exists("EVENT_ID", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["EVENT_ID"] === ''
		)
		{
			$aMsg[] = [
				"id" => "EVENT_ID",
				"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_EVENT_ID"),
			];
		}

		if (
			(
				(
					$action === "update"
					&& array_key_exists("NAME", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["NAME"] === ''
		)
		{
			$aMsg[] = [
				"id" => "NAME",
				"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_NAME"),
			];
		}

		if ((string) ($arFields["LID"] ?? '') !== '')
		{
			$r = CLang::GetByID($arFields["LID"]);
			if (!$r->Fetch())
			{
				$aMsg[] = [
					"id" => "LID",
					"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_SITE"),
				];
			}
		}
		elseif (
			(
				$action === "update"
				&& array_key_exists("LID", $arFields)
			) || $action === "add"
		)
		{
			$aMsg[] = [
				"id" => "LID",
				"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_SITE2")
			];
		}

		if (
			(
				$action === "add"
				&& $arFields["TYPE"] === "POST"
				&& (
					!array_key_exists("HASH", $arFields)
					|| (string)$arFields["HASH"] === ''
				)
			)
			|| (
				$action === "update"
				&& ($arFields["TYPE"] ?? null) === "POST"
				&& array_key_exists("HASH", $arFields)
				&& (string) $arFields["HASH"] === ''
			)
		)
		{
			$arFields["HASH"] = md5(\Bitrix\Main\Security\Random::getString(20));
		}

		if (
			(
				$action === "add"
				&& (
					!array_key_exists("ENABLE_COMMENTS", $arFields)
					|| !in_array($arFields["ENABLE_COMMENTS"], [ "Y", "N"])
				)
			)
			|| (
				$action === "update"
				&& array_key_exists("ENABLE_COMMENTS", $arFields)
				&& !in_array($arFields["ENABLE_COMMENTS"], [ "Y", "N" ])
			)
		)
		{
			$arFields["ENABLE_COMMENTS"] = "Y";
		}

		if (
			(
				(
					$action === "update"
					&& array_key_exists("DAYS_OF_MONTH", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["DAYS_OF_MONTH"] !== ''
		)
		{
			$arDoM = explode(",", $arFields["DAYS_OF_MONTH"]);
			$arFound = array();
			foreach ($arDoM as $strDoM)
			{
				if (preg_match("/^(\d{1,2})$/", trim($strDoM), $arFound))
				{
					if (
						(int)$arFound[1] < 1
						|| (int)$arFound[1] > 31
					)
					{
						$aMsg[] = array("id"=>"DAYS_OF_MONTH", "text"=>GetMessage("LFP_CLASS_SCHEME_ERR_DOM"));
						break;
					}
				}
				elseif (preg_match("/^(\d{1,2})-(\d{1,2})$/", trim($strDoM), $arFound))
				{
					if (
						(int)$arFound[1] < 1
						|| (int)$arFound[1] > 31
						|| (int)$arFound[2] < 1
						|| (int)$arFound[2] > 31
						|| (int)$arFound[1] >= (int)$arFound[2])
					{
						$aMsg[] = [
							"id" => "DAYS_OF_MONTH",
							"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_DOM"),
						];
						break;
					}
				}
				else
				{
					$aMsg[] = [
						"id" => "DAYS_OF_MONTH",
						"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_DOM2"),
					];
					break;
				}
			}
		}

		if (
			(
				(
					$action === "update"
					&& array_key_exists("DAYS_OF_WEEK", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["DAYS_OF_WEEK"] !== ''
		)
		{
			$arDoW = explode(",", $arFields["DAYS_OF_WEEK"]);
			$arFound = array();
			foreach ($arDoW as $strDoW)
			{
				if (preg_match("/^(\d)$/", trim($strDoW), $arFound))
				{
					if (
						(int)$arFound[1] < 1
						|| (int)$arFound[1] > 7
					)
					{
						$aMsg[] = [
							"id" => "DAYS_OF_WEEK",
							"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_DOW"),
						];
						break;
					}
				}
				else
				{
					$aMsg[] = [
						"id" => "DAYS_OF_WEEK",
						"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_DOW2"),
					];
					break;
				}
			}
		}
		if (
			(
				(
					$action === "update"
					&& array_key_exists("TIMES_OF_DAY", $arFields)
				)
				|| $action === "add"
			)
			&& (string)$arFields["TIMES_OF_DAY"] !== ''
		)
		{
			$arToD = explode(",", $arFields["TIMES_OF_DAY"]);
			$arFound = array();
			foreach ($arToD as $strToD)
			{
				if (preg_match("/^(\d{1,2}):(\d{1,2})$/", trim($strToD), $arFound))
				{
					if (
						(int)$arFound[1] > 23
						|| (int)$arFound[2] > 59
					)
					{
						$aMsg[] = [
							"id" => "TIMES_OF_DAY",
							"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_TOD"),
						];
						break;
					}
				}
				else
				{
					$aMsg[] = array("id"=>"TIMES_OF_DAY", "text"=>GetMessage("LFP_CLASS_SCHEME_ERR_TOD2"));
					break;
				}
			}
		}

		if (!array_key_exists("AUTO", $arFields))
		{
			if (array_key_exists("TYPE",  $arFields))
			{
				$arFields["AUTO"] = (
					in_array($arFields["TYPE"], [ "XML", "RSS" ])
						? "Y"
						: "N"
				);
			}
		}
		elseif (!in_array($arFields["AUTO"], [ "Y", "N" ]))
		{
			$arFields["AUTO"] = "N";
		}

		if (
			array_key_exists("IS_HTML", $arFields)
			&& !in_array($arFields["IS_HTML"], [ "Y", "N" ])
		)
		{
			$arFields["IS_HTML"] = "N";
		}

		if (array_key_exists("URI", $arFields))
		{
			$arURI = parse_url($arFields["URI"]);
			if (
				array_key_exists("TYPE", $arFields) 
				&& in_array($arFields["TYPE"], array("XML", "RSS"))
			)
			{
				if ((string)$arURI["host"] === '')
				{
					$aMsg[] = [
						"id" => "URI", 
						"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_URI_HOST"),
					];
				}
				else
				{
					$arFields["HOST"] = $arURI["host"];
				}

				if ((string) ($arURI["port"] ?? null) !== '')
				{
					$arFields["PORT"] = $arURI["port"];
				}

				if ((string) ($arURI["path"] ?? null) !== '')
				{
					$arFields["PAGE"] = $arURI["path"];
				}
			}
			
			if (
				array_key_exists("TYPE", $arFields) 
				&& $arFields["TYPE"] === "RSS"
				&& (string) ($arURI["query"] ?? null) !== ''
			)
			{
				$arFields["PARAMS"] = $arURI["query"];
			}
			
			if ($arFields["TYPE"] !== "RSS")
			{
				unset($arFields["URI"]);
			}
		}
		elseif (array_key_exists("HOST", $arFields))
		{
			if (
				array_key_exists("TYPE", $arFields)
				&& $arFields["TYPE"] === "XML"
			)
			{
				if (mb_strpos($arFields["HOST"], "://") === false)
				{
					$arFields["HOST"] = "http://" . $arFields["HOST"];
				}

				$arURI = parse_url($arFields["HOST"]);

				if ((string)$arURI["host"] === '')
				{
					$aMsg[] = [
						"id" => "HOST",
						"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_URI_HOST"),
					];
				}
				else
				{
					$arFields["HOST"] = $arURI["host"];
				}

				if ((string)$arURI["port"] !== '')
				{
					$arFields["PORT"] = $arURI["port"];
				}
			}
		}

		if (($arFields["AUTO"] ?? null) === "Y")
		{
			if (mb_strlen($arFields["DAYS_OF_MONTH"]) + mb_strlen($arFields["DAYS_OF_WEEK"]) <= 0)
			{
				$aMsg[] = [
					"id" => "DAYS_OF_MONTH",
					"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_DAYS_MISSING"),
				];
			}

			if ((string)$arFields["TIMES_OF_DAY"] === '')
			{
				$aMsg[] = [
					"id" => "TIMES_OF_DAY",
					"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_TIMES_MISSING"),
				];
			}

			if ((string)$arFields["LAST_EXECUTED"] === '')
			{
				$aMsg[] = [
					"id" => "LAST_EXECUTED",
					"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_LE_MISSING"),
				];
			}
			elseif (
				is_set($arFields, "LAST_EXECUTED")
				&& $arFields["LAST_EXECUTED"] !== false
				&& $DB->IsDate($arFields["LAST_EXECUTED"], false, false, "FULL") !== true
			)
			{
				$aMsg[] = [
					"id" => "LAST_EXECUTED",
					"text" => Loc::getMessage("LFP_CLASS_SCHEME_ERR_LE_WRONG"),
				];
			}
		}

		if (!empty($aMsg))
		{
			$e = new CAdminException($aMsg);
			$GLOBALS["APPLICATION"]->ThrowException($e);
			$this->LAST_ERROR = $e->GetString();
			return false;
		}

		return true;
	}

	public static function Delete($ID): bool
	{
		global $DB, $APPLICATION, $CACHE_MANAGER;

		$res = $DB->Query('DELETE FROM b_xdi_lf_scheme WHERE ID = ' . (int)$ID);
		if (is_object($res))
		{
			CXDILFSchemeRights::DeleteBySchemeID($ID);

			if (defined("BX_COMP_MANAGED_CACHE"))
			{
				$CACHE_MANAGER->ClearByTag("XDI_SCHEME_".$ID);
			}

			return true;
		}

		$e = $APPLICATION->GetException();
		$strError = GetMessage("LFP_CLASS_SCHEME_DELETE_ERROR", array("#error_msg#" => is_object($e)? $e->GetString(): ''));

		$APPLICATION->ResetException();
		$e = new CApplicationException($strError);
		$APPLICATION->ThrowException($e);
		return false;
	}

	//Get by ID
	public static function GetByID($ID)
	{
		global $DB;
		$ID = (int)$ID;

		$strSql = "
			SELECT
				S.*
				,".$DB->DateToCharFunction("S.LAST_EXECUTED")." AS LAST_EXECUTED
			FROM b_xdi_lf_scheme S
			WHERE S.ID = " . $ID."
		";

		return $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
	}

	public static function CheckRequest(): string
	{
		global $DB;

		if (!CModule::IncludeModule("socialnetwork"))
		{
			return "";
		}

		$current_time = time();
		$time_of_exec = false;

		$rsScheme = CXDILFScheme::GetList(array(), array("ACTIVE"=>"Y", "AUTO"=>"Y"));
		while (
			($arScheme = $rsScheme->Fetch()) 
			&& $time_of_exec === false
		)
		{
			if ((string)$arScheme["LAST_EXECUTED"] === '')
			{
				continue;
			}

			$last_executed = MakeTimeStamp(ConvertDateTime($arScheme["LAST_EXECUTED"], "DD.MM.YYYY HH:MI:SS"), "DD.MM.YYYY HH:MI:SS");

			if ($last_executed <= 0)
			{
				continue;
			}

			$arEventTmp = CSocNetLogTools::FindLogEventByID($arScheme["EVENT_ID"]);
			if (
				array_key_exists("REAL_EVENT_ID", $arEventTmp) 
				&& (string)$arEventTmp["REAL_EVENT_ID"] !== ''
			)
			{
				$arScheme["EVENT_ID"] = $arEventTmp["REAL_EVENT_ID"];
			}

			//parse schedule
			$arDoM = CXDImport::ParseDaysOfMonth($arScheme["DAYS_OF_MONTH"]);
			$arDoW = CXDImport::ParseDaysOfWeek($arScheme["DAYS_OF_WEEK"]);
			$arToD = CXDImport::ParseTimesOfDay($arScheme["TIMES_OF_DAY"]);
			if ($arToD)
			{
				sort($arToD, SORT_NUMERIC);
			}

			$arSDate = localtime($last_executed);
			//sdate = truncate(last_execute)
			$sdate = mktime(0, 0, 0, $arSDate[4]+1, $arSDate[3], $arSDate[5]+1900);
			while (
				$sdate < $current_time 
				&& $time_of_exec === false
			)
			{
				$arSDate = localtime($sdate);
				if ($arSDate[6] == 0)
				{
					$arSDate[6] = 7;
				}
				//determine if date is good for execution
				if ($arDoM)
				{
					$flag = array_search($arSDate[3], $arDoM);
					if ($arDoW)
					{
						$flag = array_search($arSDate[6], $arDoW);
					}
				}
				elseif ($arDoW)
				{
					$flag = array_search($arSDate[6], $arDoW);
				}
				else
				{
					$flag = false;
				}


				if (
					$flag !== false
					&& $arToD
				)
				{
					foreach ($arToD as $intToD)
					{
						if (
							$sdate + $intToD > $last_executed
							&& $sdate + $intToD <= $current_time)
						{
							$time_of_exec = $sdate+$intToD;
							break;
						}
					}
				}

				$sdate = mktime(0, 0, 0, date("m",$sdate), date("d",$sdate)+1, date("Y",$sdate));//next day
			}

			$arResponse = false;

			if ($time_of_exec !== false)
			{
				if ($arScheme["TYPE"] === "XML")
				{
					$arParams = array();
					if ((string)$arScheme["PARAMS"] !== '')
					{
						$arTmp = explode("&", $arScheme["PARAMS"]);
						if (is_array($arTmp) && count($arTmp) > 0)
						{
							foreach ($arTmp as $pair)
							{
								[ $key, $value ] = explode("=", $pair);
								$arParams[$key] = $value;
							}
						}
					}

					$arResponse = CXDILFSchemeXML::Request(
						$arScheme["HOST"],
						$arScheme["PAGE"],
						$arScheme["PORT"],
						$arScheme["METHOD"],
						"http://".$arScheme["HOST"],
						$arScheme["LOGIN"],
						$arScheme["PASSWORD"],
						$arParams
					);

					if (
						$arResponse 
						&& is_array($arResponse)
					)
					{
						if (XDI_DEBUG)
						{
							CXDImport::WriteToLog("Successful webservice response, scheme ID: ".$arScheme["ID"], "RXML");
						}

						$entityName = $arScheme["NAME"];

						if ($arScheme["EVENT_ID"] === "news")
						{
							$rsIBlock = CIBlock::GetList(
								array("ID" => "ASC"),
								array("ACTIVE" => "Y", "TYPE" => "news", "ID" => $arScheme["ENTITY_ID"])
							);
							if ($arIBlock = $rsIBlock->Fetch())
							{
								$entityName = $arIBlock["NAME"];
							}
						}

						$arLogParams = array(
							"ENTITY_NAME" => $entityName,
							"ENTITY_URL" => $arResponse["URL"]
						);

						$arSonetFields = array(
							"SITE_ID" => $arScheme["LID"],
							"ENTITY_TYPE" => $arScheme["ENTITY_TYPE"],
							"ENTITY_ID" => $arScheme["ENTITY_ID"],
							"EVENT_ID" => $arScheme["EVENT_ID"],
							"ENABLE_COMMENTS" => $arScheme["ENABLE_COMMENTS"],
							"=LOG_DATE" => $GLOBALS["DB"]->CurrentTimeFunction(),
							"TITLE_TEMPLATE" => $arResponse["TITLE"],
							"TITLE" => $arResponse["TITLE"],
							"MESSAGE" => $arResponse["MESSAGE"],
							"TEXT_MESSAGE" => $arResponse["TEXT_MESSAGE"],
							"URL" => $arResponse["URL"],
							"PARAMS" => serialize($arLogParams),
							"MODULE_ID" => false,
							"CALLBACK_FUNC" => false
						);

						$logID = CSocNetLog::Add($arSonetFields, false);
						if ((int)$logID > 0)
						{
							$arUpdateFields = array(
								"TMP_ID" => $logID,
								"RATING_TYPE_ID" => "LOG_ENTRY",
								"RATING_ENTITY_ID" => $logID
							);
							CSocNetLog::Update($logID, $arUpdateFields);
							CXDILFScheme::SetSonetLogRights($logID, $arScheme["ENTITY_TYPE"], $arScheme["ENTITY_ID"], $arScheme["EVENT_ID"]);
							CSocNetLog::CounterIncrement($logID);

							if (
								$arScheme["ENTITY_TYPE"] === SONET_SUBSCRIBE_ENTITY_GROUP
								&& (int)$arScheme["ENTITY_ID"] > 0
							)
							{
								$notify_title_tmp = str_replace(Array("\r\n", "\n"), " ", $arScheme["NAME"]);
								$notify_title = TruncateText($notify_title_tmp, 100);
								$notify_title_out = TruncateText($notify_title_tmp, 255);

								$arNotifyParams = [
									"LOG_ID" => $logID,
									"GROUP_ID" => (int)$arScheme["ENTITY_ID"],
									"NOTIFY_MESSAGE" => "",
									"URL" => "",
									"MESSAGE" => Loc::getMessage("LFP_CLASS_SCHEME_IM_ADD", [
										"#title#" => $notify_title,
									]),
									"MESSAGE_OUT" => GetMessage("LFP_CLASS_SCHEME_IM_ADD", [
										"#title#" => $notify_title_out
									]),
									"EXCLUDE_USERS" => [],
								];

								CSocNetSubscription::NotifyGroup($arNotifyParams);
							}
						}
					}
					elseif (XDI_XML_ERROR_DEBUG)
					{
						CXDImport::WriteToLog("ERROR: Incorrect webservice response. Scheme ID: ".$arScheme["ID"].", server: ".$arScheme["HOST"].", port: ".$arScheme["PORT"].", page: ".$arScheme["PAGE"].", method: ".$arScheme["METHOD"].", params: ".$arScheme["PARAMS"], "RXML");
					}
				}
				elseif ($arScheme["TYPE"] === "RSS")
				{
					$arResponse = CXDILFSchemeRSS::Request(
						$arScheme["HOST"],
						$arScheme["PAGE"],
						$arScheme["PORT"],
						$arScheme["PARAMS"],
						$arScheme["URI"]
					);

					if (
						$arResponse 
						&& is_array($arResponse)
						&& array_key_exists("item", $arResponse)
						&& is_array($arResponse["item"])
						&& count($arResponse["item"]) > 0
					)
					{
						if (XDI_DEBUG)
						{
							CXDImport::WriteToLog("Successful RSS response. Scheme ID: ".$arScheme["ID"], "RRSS");
						}

						$sanitizer = false;
						if ($arScheme["IS_HTML"] === "Y")
						{
							$sanitizer = new CBXSanitizer();
							$sanitizer->SetLevel(CBXSanitizer::SECURE_LEVEL_LOW);
						}

						foreach ($arResponse["item"] as $arItem)
						{
							$checksum = md5(serialize($arItem));
							$rsLogEvents = CSocNetLog::GetList(
								array(), 
								array(
									"SITE_ID" => $arScheme["LID"], 
									"ENTITY_TYPE" => $arScheme["ENTITY_TYPE"],
									"ENTITY_ID" => $arScheme["ENTITY_ID"],
									"EVENT_ID" => $arScheme["EVENT_ID"],
									"EXTERNAL_ID" => $checksum
								), 
								false, 
								array("nTopCount" => 1),
								array('ID')
							);
							$arLogEvent = $rsLogEvents->Fetch();
							if (!$arLogEvent)
							{
								$entityName = $arScheme["NAME"];

								if ($arScheme["EVENT_ID"] === "news")
								{
									$rsIBlock = CIBlock::GetList(
										array("ID" => "ASC"),
										array("ACTIVE" => "Y", "TYPE" => "news", "ID" => $arScheme["ENTITY_ID"])
									);
									if ($arIBlock = $rsIBlock->Fetch())
									{
										$entityName = $arIBlock["NAME"];
									}
								}

								$arLogParams = array(
									"SCHEME_ID" => $arScheme["ID"],
									"ENTITY_NAME" => $entityName,
									"ENTITY_URL" => $arResponse["link"]
								);

								if ((string)$arItem["pubDate"] !== '')
								{
									$arLogParams["SOURCE_TIMESTAMP"] = strtotime($arItem["pubDate"]);
								}

								$description = preg_replace("#^(.*?)([\s]*<br[\s]*/>)+[\s]*[\n]*[\s]*$#is", "\\1", $arItem["description"]);
								$description = \Bitrix\Main\Text\UtfSafeString::rtrimInvalidUtf(substr($description, 0, 4194304));

								if (
									$arScheme["IS_HTML"] === "Y"
									&& $sanitizer
								)
								{
									$sanitizer->ApplyDoubleEncode(false);
									$description = $sanitizer->SanitizeHtml($description);
								}

								$arSonetFields = array(
									"SITE_ID" => $arScheme["LID"],
									"ENTITY_TYPE" => $arScheme["ENTITY_TYPE"],
									"ENTITY_ID" => $arScheme["ENTITY_ID"],
									"EVENT_ID" => $arScheme["EVENT_ID"],
									"ENABLE_COMMENTS" => $arScheme["ENABLE_COMMENTS"],
									"TITLE_TEMPLATE" => $arItem["title"],
									"TITLE" => $arItem["title"],
									"MESSAGE" => $description,
									"TEXT_MESSAGE" => "",
									"URL" => (self::IsSecureUrl($arItem["link"]) ? $arItem["link"] : ''),
									"PARAMS" => serialize($arLogParams),
									"MODULE_ID" => false,
									"CALLBACK_FUNC" => false,
									"EXTERNAL_ID" => $checksum,
									"=LOG_DATE" => $GLOBALS["DB"]->CurrentTimeFunction()
								);

								$logID = CSocNetLog::Add($arSonetFields, false);
								if ((int)$logID > 0)
								{
									$arUpdateFields = array(
										"TMP_ID" => $logID,
										"RATING_TYPE_ID" => "LOG_ENTRY",
										"RATING_ENTITY_ID" => $logID
									);
									CSocNetLog::Update($logID, $arUpdateFields);
									CXDILFScheme::SetSonetLogRights($logID, $arScheme["ENTITY_TYPE"], $arScheme["ENTITY_ID"], $arScheme["EVENT_ID"]);
									CSocNetLog::CounterIncrement($logID);

									if (
										$arScheme["ENTITY_TYPE"] === SONET_SUBSCRIBE_ENTITY_GROUP
										&& (int)$arScheme["ENTITY_ID"] > 0
									)
									{
										$notify_title_tmp = str_replace(Array("\r\n", "\n"), " ", $arScheme["NAME"]);
										$notify_title = TruncateText($notify_title_tmp, 100);
										$notify_title_out = TruncateText($notify_title_tmp, 255);

										$arNotifyParams = array(
											"LOG_ID" => $logID,
											"GROUP_ID" => (int)$arScheme["ENTITY_ID"],
											"NOTIFY_MESSAGE" => "",
											"URL" => "",
											"MESSAGE" => GetMessage("LFP_CLASS_SCHEME_IM_ADD", Array(
												"#title#" => $notify_title,
											)),
											"MESSAGE_OUT" => GetMessage("LFP_CLASS_SCHEME_IM_ADD", Array(
												"#title#" => $notify_title_out
											)),
											"EXCLUDE_USERS" => array()
										);

										CSocNetSubscription::NotifyGroup($arNotifyParams);
									}
								}
							}
							elseif (XDI_DEBUG)
							{
								CXDImport::WriteToLog("RSS item is already in log. Scheme ID: ".$arScheme["ID"].", log ID: ".$arLogEvent["ID"], "RRSS");
							}
						}
					}
					elseif (XDI_XML_ERROR_DEBUG)
					{
						CXDImport::WriteToLog("ERROR: Incorrect RSS response. Scheme ID: ".$arScheme["ID"].", server: ".$arScheme["HOST"].", port: ".$arScheme["PORT"].", page: ".$arScheme["PAGE"].", params: ".$arScheme["PARAMS"], "RRSS");
					}
				}

				if (
					$arResponse
					&& is_array($arResponse)
				)
				{
					$strSql = "UPDATE b_xdi_lf_scheme SET LAST_EXECUTED=" . $DB->GetNowFunction()." WHERE ID=" . (int)$arScheme["ID"];
					$DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
				}
				else
				{
					$time_of_exec = false;
				}
			}
		}

		return "CXDILFScheme::CheckRequest();";

	}
	
	function GetProviderByID($ID)
	{
		$ID = (int)$ID;

		$rsProvider = CXDILFScheme::GetByID($ID);
		if ($arProvider = $rsProvider->GetNext())
		{
			$arProvider["NAME_FORMATTED"] = $arProvider["NAME"];
			return $arProvider;
		}

		return false;
	}

	public static function SetSonetLogRights($logID, $entity_type, $entity_id, $event_id): void
	{
		if (!CModule::IncludeModule("socialnetwork"))
		{
			return;
		}

		if (in_array($entity_type, [ SONET_SUBSCRIBE_ENTITY_USER, SONET_SUBSCRIBE_ENTITY_GROUP ], true))
		{
			if (in_array($event_id, [ "blog_post", "forum", "photo", "blog_post_micro", "files", "wiki" ]))
			{
				$arLogEventTmp = CSocNetLogTools::FindLogEventByID($event_id);
				CSocNetLogRights::SetForSonet($logID, $entity_type, $entity_id, CSocNetLogTools::FindFeatureByEventID($event_id), $arLogEventTmp["OPERATION"]);
			}
			elseif (
				$entity_type === SONET_SUBSCRIBE_ENTITY_GROUP
				&& in_array($event_id, [ "data", "system" ])

			)
			{
				CSocNetLogRights::Add(
					$logID, [
						"SA",
						"S" . SONET_SUBSCRIBE_ENTITY_GROUP . $entity_id,
						"S" . SONET_SUBSCRIBE_ENTITY_GROUP . $entity_id . "_" . SONET_ROLES_OWNER,
						"S" . SONET_SUBSCRIBE_ENTITY_GROUP . $entity_id . "_" . SONET_ROLES_MODERATOR,
						"S" . SONET_SUBSCRIBE_ENTITY_GROUP . $entity_id . "_" . SONET_ROLES_USER
					]);
			}
			elseif (
				$entity_type === SONET_SUBSCRIBE_ENTITY_USER
				&& in_array($event_id, [ "data", "system" ], true)
			)
			{
				$perm = CSocNetUserPerms::GetOperationPerms($entity_id, "viewprofile");
				if (in_array($perm, [ SONET_RELATIONS_TYPE_FRIENDS2, SONET_RELATIONS_TYPE_FRIENDS ], true))
				{
					CSocNetLogRights::Add($logID, [
						"SA",
						"U" . $entity_id,
						"S" . SONET_SUBSCRIBE_ENTITY_USER . $entity_id . "_" . $perm
					]);
				}
				elseif ($perm === SONET_RELATIONS_TYPE_AUTHORIZED)
				{
					CSocNetLogRights::Add($logID, [ "SA", "AU" ]);
				}
				elseif ($perm === SONET_RELATIONS_TYPE_ALL)
				{
					CSocNetLogRights::Add($logID, [ "SA", "G2" ]);
				}
			}
		}
		elseif ($entity_type === SONET_SUBSCRIBE_ENTITY_PROVIDER)
		{
			$arRights = [ "SA" ];
			$rsSchemeRights = CXDILFSchemeRights::GetList(array(), array("SCHEME_ID" => $entity_id));
			while ($arSchemeRights = $rsSchemeRights->Fetch())
			{
				if (mb_strpos($arSchemeRights["GROUP_CODE"], "U") === 0)
				{
					if (mb_substr($arSchemeRights["GROUP_CODE"], 1) === "A")
					{
						$arRights[] = "AU";
						break;
					}

					if (mb_substr($arSchemeRights["GROUP_CODE"], 1) === "N")
					{
						$arRights[] = "G2";
						break;
					}

					if ((int)mb_substr($arSchemeRights["GROUP_CODE"], 1) > 0)
					{
						$arRights[] = "U" . mb_substr($arSchemeRights["GROUP_CODE"], 1);
					}
				}
			}
			if (count($arRights) > 0)
			{
				CSocNetLogRights::Add($logID, $arRights);
			}
		}
		elseif (
			defined("SONET_SUBSCRIBE_ENTITY_NEWS")
			&& $entity_type === SONET_SUBSCRIBE_ENTITY_NEWS
		)
		{
			CSocNetLogRights::Add($logID, array("SA", "G2"));
		}
	}

	public static function IsSecureUrl($url): bool
	{
		$url = trim((string)$url);
		$colonOffset = mb_strpos($url, ':');
		if ($colonOffset === false)
		{
			$colonOffset = -1;
		}

		$slashOffset = mb_strpos($url, '/');
		if ($slashOffset === false)
		{
			$slashOffset = -1;
		}

		$scheme = (
		$colonOffset > 0
		&& ($slashOffset < 0 || $colonOffset < $slashOffset)
			? mb_strtolower(mb_substr($url, 0, $colonOffset))
			: ''
		);

		return $scheme === '' || preg_match('/^(?:(?:ht|f)tp(?:s)?){1}/i', $scheme) === 1;
	}
}
