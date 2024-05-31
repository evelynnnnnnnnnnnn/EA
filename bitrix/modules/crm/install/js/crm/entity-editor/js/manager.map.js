{"version":3,"file":"manager.map.js","names":["BX","namespace","Crm","EntityEditorDupManager","this","_id","_settings","_groupInfos","_isEnabled","_serviceUrl","_entityTypeName","_form","_controller","prototype","initialize","id","settings","type","isNotEmptyString","util","getRandomString","prop","getBoolean","getObject","getString","get","_ignoredItems","getArray","CrmDupController","create","serviceUrl","entityTypeName","isSingleMode","form","clientSearchBox","enableEntitySelect","searcSummaryPosition","ignoredItems","isEnabled","search","initialSearch","getGroupInfo","groupId","hasOwnProperty","getGroup","ensureGroupRegistered","group","registerGroup","registerField","config","field","unregisterField","self","EntityBizprocManager","_moduleId","_entity","_documentType","_autoExecuteType","_containerId","_fieldName","_validParameters","_formInput","_editor","_starter","_hasParameters","getInteger","_contentNode","Bizproc","Starter","moduleId","entity","documentType","onBeforeSave","result","promise","Promise","deferredWaiter","window","setTimeout","delegate","fulfill","getStatus","showAutoStartParametersPopup","contentNode","callback","onFillParameters","bind","e","console","log","onAfterSave","data","parameters","getFormElement","props","name","appendChild","value","messages","items","EntityRestPlacementManager","getSetting","bottomButton","proxy","openMarketplace","defer","initializeInterface","rest","Marketplace","open","PLACEMENT","AppLayout","PlacementInterface","initializePlacement","entityTypeId","_entityTypeId","entityId","_entityId","resizeWindow","params","cb","f","layoutName","height","parseInt","style","p","pos","width","reloadData","EntityEvent","fireUpdate"],"sources":["manager.js"],"mappings":"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"}