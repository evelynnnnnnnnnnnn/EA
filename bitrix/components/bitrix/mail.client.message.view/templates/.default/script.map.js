{"version":3,"file":"script.map.js","names":["window","BXMailView","options","__views","messageId","this","id","progressPercent","progressInterval","init","getView","prototype","isAjaxBody","messageBodyElementId","ajaxLoadMessageBody","ajaxLoadAttachments","addPageSwapper","startProgress","bindErrorClose","BX","ajax","runComponentAction","mode","data","then","response","handleSuccessResponse","handleFailedResponse","stopProgress","type","isNotEmptyObject","isString","messageHtml","insertBodyText","quote","insertQuoteText","safeHide","warningWaitElementId","showControls","formId","quoteFieldName","isObject","BXMainMailForm","getForm","isArray","fields","i","hasOwnProperty","name","value","html","messageBodyElement","document","getElementById","innerHTML","bxMailMessage","onCustomEvent","ajaxAttachmentElementId","ajaxAttachmentElement","ajaxAttachmentLoader","Loader","target","size","color","show","mail_uf_message_token","mailUfMessageToken","attachmentsHtml","hide","parentElement","showError","safeShow","warningFailElementId","bodyLoaderElementId","bodyLoaderMaxTime","progressContainer","myProgress","UI","ProgressBar","maxValue","renderTo","stepTime","setInterval","setValue","update","clearInterval","messageControlElementId","fastReplyElementId","errorContainer","closeElement","querySelector","bind","slider","SidePanel","Instance","getTopSlider","container","iframe","contentDocument","firstChild","pagesHref","getData","get","PageSwapper","remove","pageSwapper","pageType","openSliders","getOpenSliders","count","length","prevSliderWindow","getFrameWindow","enableNextPage","hasPagesBeforeEnd","click","elementId","element","style","display"],"sources":["script.js"],"mappings":"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"}