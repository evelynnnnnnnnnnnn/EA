export const ChatActionType = Object.freeze({
	avatar: 'avatar',
	call: 'call',
	extend: 'extend',
	leave: 'leave',
	leaveOwner: 'leaveOwner',
	kick: 'kick',
	mute: 'mute',
	rename: 'rename',
	send: 'send',
	deleteOthersMessage: 'deleteOthersMessage',
	userList: 'userList',
	changeOwner: 'changeOwner',
	changeManagers: 'changeManagers',

	readMessage: 'readMessage',
	openComments: 'openComments',
	followComments: 'followComments',
	openSidebar: 'openSidebar',
	pinMessage: 'pinMessage',
	setReaction: 'setReaction',
	createMeeting: 'createMeeting',
	createTask: 'createTask',
	openAvatarMenu: 'openAvatarMenu',
	openMessageMenu: 'openMessageMenu',
	openSidebarMenu: 'openSidebarMenu',
});

export const ChatActionGroup = Object.freeze({
	manageSettings: 'manageSettings',
	manageUi: 'manageUi',
	manageUsersAdd: 'manageUsersAdd',
	manageUsersDelete: 'manageUsersDelete',
	manageMessages: 'manageMessages',
});
