{"version":3,"file":"extension.map.js","names":["jn","define","require","exports","module","Loc","NotifyManager","WizardStep","ProgressBarNumber","DescriptionStepView","DescriptionStep","constructor","props","super","this","templateId","name","formattedTime","description","hasParameters","isConstantsTuned","updateProps","undefined","renderNumberBlock","isCompleted","number","stepNumber","getProgressBarSettings","isEnabled","title","text","getMessage","count","totalSteps","getTitle","getNextStepButtonText","isNextStepEnabled","isPrevStepEnabled","async","stepId","showError","Promise","resolve","finish","next","showLoadingIndicator","BX","ajax","runAction","data","signedDocument","then","hideLoadingIndicator","setTimeout","catch","response","console","error","errors","Array","isArray","showErrors","createLayout"],"sources":["extension.js"],"mappings":"AAGAA,GAAGC,OAAO,6CAA6C,CAACC,EAASC,EAASC,KACzE,MAAMC,IAAEA,GAAQH,EAAQ,OACxB,MAAMI,cAAEA,GAAkBJ,EAAQ,kBAClC,MAAMK,WAAEA,GAAeL,EAAQ,yBAC/B,MAAMM,kBAAEA,GAAsBN,EAAQ,sCACtC,MAAMO,oBAAEA,GAAwBP,EAAQ,kDAExC,MAAMQ,UAAwBH,EAE7BI,YAAYC,GAEXC,MAAMD,GAENE,KAAKC,WAAaH,EAAMG,YAAc,KACtCD,KAAKE,KAAOJ,EAAMI,MAAQ,KAC1BF,KAAKG,cAAgBL,EAAMK,eAAiB,KAC5CH,KAAKI,YAAcN,EAAMM,aAAe,KACxCJ,KAAKK,cAAgBP,EAAMO,eAAiB,KAC5CL,KAAKM,iBAAmBR,EAAMQ,kBAAoB,IACnD,CAEAC,YAAYT,GAEXE,KAAKC,WAAaH,EAAMG,aAAeO,UAAYR,KAAKC,WAAaH,EAAMG,WAC3ED,KAAKE,KAAOJ,EAAMI,OAASM,UAAYR,KAAKE,KAAOJ,EAAMI,KACzDF,KAAKI,YAAcN,EAAMM,cAAgBI,UAAYR,KAAKI,YAAcN,EAAMM,YAC9EJ,KAAKK,cAAgBP,EAAMO,gBAAkBG,UAAYR,KAAKK,cAAgBP,EAAMO,cACpFL,KAAKM,iBAAmBR,EAAMQ,mBAAqBE,UAAYR,KAAKM,iBAAmBR,EAAMQ,iBAC7FN,KAAKG,cAAgBL,EAAMK,gBAAkBK,UAAYR,KAAKG,cAAgBL,EAAMK,aACrF,CAEAM,oBAEC,OAAO,IAAIf,EAAkB,CAC5BgB,YAAa,KACbC,OAAQX,KAAKF,MAAMc,YAErB,CAEAC,yBAEC,MAAO,IACHd,MAAMc,yBACTC,UAAW,KACXC,MAAO,CAAEC,KAAMzB,EAAI0B,WAAW,iDAC9BN,OAAQX,KAAKF,MAAMc,WACnBM,MAAOlB,KAAKK,cAAgBL,KAAKF,MAAMqB,WAAanB,KAAKF,MAAMqB,WAAa,EAE9E,CAEAC,WAEC,OAAOpB,KAAKF,MAAMiB,OAAS,EAC5B,CAEAM,wBAEC,OACCrB,KAAKK,cACFd,EAAI0B,WAAW,gEACf1B,EAAI0B,WAAW,sEAEpB,CAEAK,oBAEC,OAAO,IACR,CAEAC,oBAEC,OAAO,IACR,CAEAC,uBAAuBC,GAEtB,IAAKzB,KAAKM,iBACV,CACCd,EAAckC,UAAUnC,EAAI0B,WAAW,qEAEvC,OAAOU,QAAQC,QAAQ,CAAEC,OAAQ,MAAOC,KAAM,OAC/C,CAEA,GAAI9B,KAAKK,cACT,CACC,OAAOsB,QAAQC,QAAQ,CAAEC,OAAQ,MAAOC,KAAM,MAC/C,OAEMtC,EAAcuC,uBAEpB,OAAO,IAAIJ,SAASC,IACnBI,GAAGC,KAAKC,UACP,+BACA,CACCC,KAAM,CACLC,eAAgBpC,KAAKF,MAAMsC,eAC3BnC,WAAYD,KAAKC,cAIlBoC,MAAK,KACL7C,EAAc8C,qBACb,KACA/C,EAAI0B,WAAW,0DACf,MAEDsB,YAAW,IAAMX,EAAQ,CAAEC,OAAQ,KAAMC,KAAM,SAAU,KAAK,IAE9DU,OAAOC,IACPC,QAAQC,MAAMF,EAASG,QACvBpD,EAAc8C,qBAAqB,OACnC,GAAIO,MAAMC,QAAQL,EAASG,QAC3B,CACCpD,EAAcuD,WAAWN,EAASG,OACnC,CAEAhB,EAAQ,CAAEC,OAAQ,MAAOC,KAAM,OAAQ,GAEzC,GAEF,CAEAkB,aAAalD,GAEZ,OAAO,IAAIH,EAAoB,CAC9BO,KAAMF,KAAKE,KACXE,YAAaJ,KAAKI,YAClBD,cAAeH,KAAKG,eAEtB,EAGDb,EAAOD,QAAU,CAAEO,kBAAiB"}