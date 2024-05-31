{"version":3,"sources":["extension.js"],"names":["jn","define","require","exports","module","VerticalSeparator","Checkbox","PinButton","Tag","TimelineItemUserAvatar","TimelineButtonVisibilityFilter","TimelineButtonSorter","Moment","dayMonth","longDate","shortTime","FriendlyDate","TimeAgo","Haptics","ChangeStreamButtonTypes","PIN","UNPIN","COMPLETE","TimelineItemHeader","LayoutComponent","constructor","props","super","hasIcon","Boolean","this","render","View","style","flexDirection","justifyContent","flexGrow","opacity","BX","prop","getNumber","paddingTop","paddingLeft","flex","renderTitle","renderTags","renderTime","flexShrink","renderUser","renderChangeStreamButton","title","flexWrap","marginBottom","onClick","onAction","titleAction","Text","text","fontSize","fontWeight","color","marginRight","tags","Object","values","filter","isReadonly","sort","map","date","moment","createFromTimestamp","dateFormat","inThisYear","useFriendlyDate","defaultFormat","showTime","useTimeAgo","futureAllowed","user","changeStreamButton","type","action","impactMedium","ChangeStreamButton","pinned","marginLeft"],"mappings":"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","file":"extension.map.js"}