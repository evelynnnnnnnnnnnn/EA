{"version":3,"file":"itemsetpicker.min.js","sources":["itemsetpicker.js"],"names":["BX","namespace","Tasks","UI","UserItemSet","ItemSet","extend","sys","code","options","nameTemplate","useSearch","useAdd","methods","construct","this","vars","intendOpen","initialized","changed","instances","selector","Integration","Socialnetwork","NetworkSelector","scope","id","mode","getNSMode","query","getQuery","option","parent","bindEvent","delegate","onClose","onSelectorInitialized","onSelectorItemSelected","onSelectorItemDeselected","showLoader","Util","delay","bindEvents","callMethod","filterFocusBlur","control","onSearchBlurred","setCSSFlag","hideLoader","cancel","dropCSSFlag","openAddForm","searchPopupOpen","data","value","extractItemValue","hasItem","checkCanAddItems","itemLast","getItemLast","replaceItem","addItem","close","resetInput","deleteItem","arguments","itemInst","deselectItem","checkIsOpened","toggleSearchOff","initializeSelector","search","focus","initialize","type","isElementNode","open","extractItemDisplay","DISPLAY","nameFormatted","util","htmlspecialcharsback","formatted","formatName","LOGIN","login","ID","email","hashCode","prepareData","WORK_POSITION","description","AVATAR","avatar","NAME","name","LAST_NAME","lastName","EMAIL","IS_EMAIL_USER","IS_EXTRANET_USER","extranet","USER_TYPE","GroupItemSet","PopupItemSet","formShownBefore","blockSelectorEvent","temporalItems","window","PopupWindowManager","create","getFullBxId","getPopupAttachTo","autoHide","closeByEsc","content","buttons","getPopupButtons","show","bindFormEvents","btnDesc","getPopupButtonsDescription","k","btnClass","PopupWindowButton","PopupWindowButtonLink","push","text","className","events","click","action","message","applySelectionChange","discardSelectionChange","itemsChanged","list","getSelectionDelta","added","deleted","items","delta","redraw"],"mappings":"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"}