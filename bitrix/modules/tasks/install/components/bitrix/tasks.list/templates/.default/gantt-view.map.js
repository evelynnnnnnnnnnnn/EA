{"version":3,"file":"gantt-view.map.js","names":["tasksListNS","approveTask","taskId","ganttChart","updateTask","status","dateCompleted","Date","SetServerStatus","bGannt","disapproveTask","SetServerCloseStatus","params","columnsIds","data","mode","sessid","BX","message","path_to_task","id","getColumnsOrder","i","ajax","method","dataType","url","tasksListAjaxUrl","processData","onsuccess","reply","UI","Notification","Center","notify","content","taskInfo","parseJSON","tasksRenderJSON","quickInfoData","menuItems","realStatus","tasksMenuPopup","getTaskById","setMenuItems","__FilterMenuByStatus","ganttTask","TasksTimerManager","reLoadInitTimerDataFromServer","window","TasksIFrameInst","onTaskChanged","html","__InvalidateMenus","CloseTask","analyticsSection","analyticsData","tool","category","event","type","c_section","c_element","c_sub_section","Analytics","sendData","Runtime","loadExtension","then","StartTask","AcceptTask","PauseTask","RenewTask","DeferTask","AddToFavorite","parameters","add","datum","DeleteFavorite","rowDelete","TASKS_table_view_onDeleteClick_onSuccess","DeleteTask","toString","trim","length","removeTask","onCustomEvent","onPopupTaskChanged","task","__RenewMenuItems","parentTaskId","parentTask","hasChildren","expand","projectId","getProjectById","project","addProjectFromJSON","name","projectName","opened","canCreateTasks","projectCanCreateTasks","canEditTasks","projectCanEditTasks","onPopupTaskAdded","addTaskFromJSON","onPopupTaskDeleted","lastScroll","onBeforeShow","browser","IsOpera","layout","timeline","scrollLeft","onAfterShow","onBeforeHide","onAfterHide","clone"],"sources":["gantt-view.js"],"mappings":"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"}