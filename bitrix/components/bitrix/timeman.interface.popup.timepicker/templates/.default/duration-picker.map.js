{"version":3,"sources":["duration-picker.js"],"names":["BX","namespace","Timeman","Component","Popup","DurationPicker","options","BaseComponent","apply","this","arguments","durationPopupToggle","selectOneByRole","durationPopupToggleSelector","durationInput","durationInputSelector","addEventHandlers","prototype","__proto__","constructor","bind","delegate","onDurationPopupToggleClick","event","durationPopup","buildBreakTimePopup","breakTimeContent","create","props","className","children","buildDurationPopupInput","message","setContent","show","text","type","initValue","search","value","match","attrs","dataset","events","input","proxy","onDurationUpdate","change","e","maxValue","currentTarget","parseInt","length","slice","padStart","newVal","replace","textContent","Event","dispatchEvent","PopupWindow","Math","random","titleBar","autoHide","bindElement","closeByEsc","angle","contentColor","contentNoPaddings","buttons","PopupWindowButton","click","close"],"mappings":"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","file":"duration-picker.map.js"}