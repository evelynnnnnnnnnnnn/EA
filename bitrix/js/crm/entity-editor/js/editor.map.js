{"version":3,"file":"editor.map.js","names":["BX","namespace","Crm","EntityEditor","superclass","constructor","apply","this","_entityTypeId","_dupControlManager","_bizprocManager","_attributeManager","_afterFormSubmitHandler","delegate","onAfterFormSubmit","_cancelFormSubmitHandler","onCancelFormSubmit","_haslayout","_enableCommunicationControls","_enableExternalLayoutResolvers","_showEmptyFields","_modeChangeNotifier","_controlChangeNotifier","_entityCreateHandler","onCreateHandler","_entityUpdateHandler","onEntityUpdate","_toolbarMenuBuildHandler","onInterfaceToolbarMenuBuild","_configurationManagerInitializeHandler","onConfigurationManagerInitialize","_helpWrapper","eventsNamespace","pageTitleInputClassName","extend","UI","prototype","initialize","id","settings","CrmNotifier","create","_settings","prop","getInteger","_entityTypeName","CrmEntityType","resolveName","_createSectionButton","get","_configMenuButton","getBoolean","notify","type","isElementNode","_container","initializeManagers","addCustomEvent","duplicateControlConfig","getObject","hasOwnProperty","_ajaxForm","EntityEditorDupManager","_id","toLowerCase","_editor","_restPlacementTabManager","attachToEvents","window","deattachFromEvents","removeCustomEvent","editor","eventArgs","configurationFieldManager","EntityConfigurationManager","initializeControlsEditMode","i","length","control","_controls","priority","getEditPriority","EntityEditorPriority","high","setMode","EntityEditorMode","edit","getActiveControlCount","release","_dragContainerController","removeDragFinishListener","_dropHandler","_controllers","clone","params","wrapper","getString","util","getRandomString","container","props","className","appendChild","eventParams","sender","EntityEvent","fireCreate","_entityId","_externalContextId","makeLocalStorageSafeObject","fireUpdate","_isReleased","data","_model","setData","enableNotification","adjustTitle","adjustSize","refreshLayout","reset","object","localStorageSafeObject","Object","entries","forEach","key","value","isClassInstance","Type","isObject","isPlainObject","getEntityTypeForAction","resolveAbbreviation","initializeAjaxForm","getAjaxFormConfigData","ACTION_ENTITY_TYPE","ACTION_ENTITY_ID","releaseAjaxForm","getEntityTypeId","getModel","isPersistent","getIntegerField","isNeedToDisplayEmptyFields","areCommunicationControlsEnabled","getEntityCreateUrl","entityTypeName","names","contact","company","getEntityEditUrl","entityId","url","replace","getEntityRequisiteSelectUrl","getRequisiteEditUrl","getBizprocManager","getAttributeManager","getAttributeManagerSettings","EntityFieldAttributeManager","entityTypeId","entityScope","isPermitted","isPhaseDependent","isAttrConfigButtonHidden","lockScript","captions","entityPhases","getArray","registerActiveControl","index","getActiveControlIndex","mode","_mode","unregisterActiveControl","view","_activeControls","createControl","controlId","_serviceUrl","_formElement","EntityEditorControlFactory","releaseActiveControls","options","processControlChange","_enableCloseConfirmation","processControlRemove","EntityEditorField","EntityEditorSubsection","addAvailableSchemeElement","getSchemeElement","EntityEditorSection","children","getChildren","createController","EntityEditorControllerFactory","config","model","processControllerChange","controller","tapController","controllerId","callback","isNotEmptyString","isFunction","call","hasLayout","layout","cancel","onCustomEvent","prepareContextDataLayout","_context","_toolPanel","isSectionCreationEnabled","bind","onCreateSectionButtonClick","style","display","onConfigMenuButtonClick","enableInlineEditSpotlight","userFieldLoaders","EntityUserFieldLayoutLoader","enableBatchMode","owner","getMode","layoutOptions","userFieldLoader","getName","enableFocusGain","_isEmbedded","isReadOnly","text","getMessage","ufLoadeerPromises","push","runBatch","Promise","all","then","showToolPanel","isCaptionEditable","_pageTitle","onPageTileClick","_editPageTitleButton","isEnabled","isSingleMode","search","_enableBottomPanel","_buttonContainer","adjustButtons","_enablePageTitleControls","document","title","getCaption","trim","getClass","SidePanel","Instance","updateBrowserTitle","parentNode","addClass","_config","isScopeToggleEnabled","lastSection","sectionControls","lastSectionControl","ensureButtonPanelWrapperCreated","getScope","EntityConfigScope","common","events","click","addModeChangeListener","listener","addListener","removeModeChangeListener","removeListener","addControlChangeListener","removeControlChangeListener","validate","result","validator","EntityAsyncValidator","addResult","_userFieldManager","getActionEventArguments","eventArguments","closeSearchSummary","dupControlManager","getDuplicateManager","_controller","_closeSearchSummary","innerCancel","_isNew","processSchemeChange","onSaveSuccess","prepareEventParams","entityInfo","_isRequestRunning","setLocked","isDuplicateControlEnabled","onDrop","dragContainer","draggedItem","x","y","processDraggedItemDrop","canCreateContact","canCreateCompany","addHelpLink","append","link","href","helpUrl","target","e","top","Helper","show","preventDefault","name","message","m","messages","getGlobalEventName","eventName","aliases","onEntityCreateError","onEntityUpdateError","onEntityCreate","beforeEntityRedirect","defaultInstance","items","setDefault","instance","getDefault","self","getId","EntityEditorScopeConfig","EntityEditorModeQueue","EntityEditorModeSwitch","EntityEditorVisibilityPolicy"],"sources":["editor.js"],"mappings":"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"}