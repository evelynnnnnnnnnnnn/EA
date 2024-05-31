{"version":3,"file":"registry.bundle.map.js","names":["this","BX","Messenger","v2","exports","ui_dialogs_messagebox","im_v2_const","im_v2_lib_call","im_v2_provider_service","im_v2_lib_utils","im_v2_lib_permission","im_v2_lib_confirm","im_public","main_popup","main_core_events","ui_vue3_vuex","rest_client","im_v2_application_core","main_core","EVENT_NAMESPACE","_prepareMenuItems","babelHelpers","classPrivateFieldLooseKey","_filterExcessDelimiters","_filterDuplicateDelimiters","_filterFinishingDelimiter","_isDelimiter","BaseMenu","EventEmitter","constructor","super","Object","defineProperty","value","_isDelimiter2","_filterFinishingDelimiter2","_filterDuplicateDelimiters2","_filterExcessDelimiters2","_prepareMenuItems2","id","setEventNamespace","store","Core","getStore","restClient","getRestClient","onClosePopupHandler","onClosePopup","bind","openMenu","context","target","menuInstance","close","getMenuInstance","show","MenuManager","create","getMenuOptions","bindOptions","forceBindPosition","position","targetContainer","document","body","bindElement","cacheable","className","getMenuClassName","items","classPrivateFieldLooseBase","events","onClose","emit","onCloseMenu","getMenuItems","destroy","getCurrentUserId","getUserId","menuItems","menuItemsWithoutDuplicates","previousElement","filter","element","reverse","Type","isObjectLike","delimiter","resendAction","cancelAction","InviteManager","resendInvite","userId","data","params","ajax","runAction","then","showNotification","Loc","getMessage","error","handleActionError","cancelInvite","text","autoHideDelay","UI","Notification","Center","notify","content","status","errors","length","errorContent","map","message","join","RecentMenu","chatService","ChatService","callManager","CallManager","getInstance","permissionManager","PermissionManager","angle","offsetLeft","compactMode","invitation","isActive","getInviteItems","getOpenItem","getUnreadMessageItem","getPinMessageItem","getMuteItem","getCallItem","getOpenProfileItem","getChatsWithUserItem","getHideItem","getLeaveItem","getSendMessageItem","onclick","openChat","dialogId","isChannel","dialog","getters","showReadOption","unread","counter","readDialog","unreadDialog","isPinned","pinned","unpinChat","pinChat","canMute","canPerformAction","ChatActionType","mute","isMuted","muteList","includes","unmuteChat","muteChat","chatCanBeCalled","chatIsAllowedToCall","call","startCall","isUser","isBot","profileUri","Utils","user","getProfileLink","href","_this$context$invitat","_this$context$options","options","default_user_record","RecentService","hideChat","canLeaveChat","leave","async","userChoice","showLeaveFromChatConfirm","leaveChat","isAnyChatOpened","entityId","EventType","sidebar","open","panel","SidebarDetailBlock","chatsWithUser","standalone","canInvite","isUndefined","MessengerProxy","console","canManageInvite","originator","push","getDelimiter","canResend","getResendInviteItem","getCancelInviteItem","MessageBox","modal","buttons","MessageBoxButtons","OK_CANCEL","onOk","messageBox","onCancel","bot","type","ChatType","channel","openChannel","isCommentsChat","comment","Lib","Dialogs","Const","Provider","Service","Main","Event","Vue3","Vuex","Application"],"sources":["registry.bundle.js"],"mappings":"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"}