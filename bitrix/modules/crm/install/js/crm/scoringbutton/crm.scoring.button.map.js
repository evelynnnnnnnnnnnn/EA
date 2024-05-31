{"version":3,"sources":["crm.scoring.button.js"],"names":["MLDETAILS_URL","instances","BX","CrmScoringButton","params","this","entityType","toString","toLowerCase","entityId","isEntityFinal","isFinal","mlInstalled","scoringEnabled","scoringParameters","prop","getObject","spotlightEnabled","currentPrediction","isModelReady","spotlightId","spotlightTimeout","spotlight","elements","scoring","title","init","push","getInstances","prototype","addCustomEvent","window","onEntityEditorLayout","bind","onPullEvent","setTimeout","getFirstPrediction","command","onPredictionUpdate","ajax","runAction","data","catch","response","errors","forEach","console","error","getTitle","message","score","percent","Math","floor","editorSection","e","getEditor","isEmbedded","sectionSerialNumber","serialNumber","create","props","className","events","click","onScoringButtonClick","children","text","customNodes","showSpotlight","predictionRecord","adjust","clearTimeout","SpotLight","id","targetElement","targetVertex","content","autoSave","show","url","replace","SidePanel","Instance","open","cacheable","width"],"mappings":"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","file":"crm.scoring.button.map.js"}