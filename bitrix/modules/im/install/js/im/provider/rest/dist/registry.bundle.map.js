{"version":3,"file":"registry.bundle.map.js","names":["this","BX","Messenger","Provider","exports","ui_vue_vuex","im_const","im_lib_logger","main_core_events","BaseRestHandler","babelHelpers","createClass","key","value","create","params","arguments","length","undefined","classCallCheck","controller","store","execute","command","result","extra","split","map","element","charAt","toUpperCase","slice","join","error","data","ownKeys","object","enumerableOnly","keys","Object","getOwnPropertySymbols","symbols","filter","sym","getOwnPropertyDescriptor","enumerable","push","apply","_objectSpread","target","i","source","forEach","defineProperty","getOwnPropertyDescriptors","defineProperties","CoreRestHandler","_BaseRestHandler","inherits","possibleConstructorReturn","getPrototypeOf","handleImUserListGetSuccess","dispatch","VuexBuilderModel","convertToArray","handleImUserGetSuccess","handleImChatGetSuccess","handleImDialogMessagesGetSuccess","users","application","prepareFilesBeforeSave","files","handleImDialogMessagesGetInitSuccess","messages","chat_id","Logger","warn","setTimeout","EventEmitter","emit","EventType","dialog","messagesSet","chatId","reverse","handleImDialogMessagesGetUnreadSuccess","handleImDiskFolderGetSuccess","commit","diskFolderId","ID","handleImMessageAddSuccess","messageId","message","_this","id","fields","sending","then","handleImMessageAddError","handleImDiskFileCommitSuccess","_this2","handleImDiskFileCommitError","file","status","FileStatus","progress","retry","handleImRecentListSuccess","dialogues","recent","items","item","userId","user","chat","assign","dialogId","avatar","url","color","DialogRestHandler","call","dialog_id","disk_folder_id","handleImCallGetCallLimitsSuccess","serverEnabled","callServerEnabled","maxParticipants","handleImChatGetError","ex","console","Rest","Const","Lib","Event"],"sources":["registry.bundle.js"],"mappings":"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"}