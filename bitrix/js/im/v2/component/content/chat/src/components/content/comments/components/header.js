import {EventEmitter} from 'main.core.events';

import {ChatActionType, EventType} from 'im.v2.const';
import {Avatar, AvatarSize} from 'im.v2.component.elements';
import {PermissionManager} from 'im.v2.lib.permission';

import {ChatHeader} from '../../base/components/chat-header/chat-header';
import {FollowToggle} from './follow-toggle';

import '../css/header.css';
import type { ImModelChat } from 'im.v2.model';

// @vue/component
export const CommentsHeader = {
	name: 'CommentsHeader',
	components: { ChatHeader, Avatar, FollowToggle },
	props:
	{
		dialogId: {
			type: String,
			default: '',
		},
		channelId: {
			type: String,
			required: true,
		},
		currentSidebarPanel: {
			type: String,
			default: '',
		},
	},
	computed:
	{
		AvatarSize: () => AvatarSize,
		channel(): ImModelChat
		{
			return this.$store.getters['chats/get'](this.channelId, true);
		},
		showFollowToggle(): boolean
		{
			return PermissionManager.getInstance().canPerformAction(ChatActionType.followComments, this.dialogId);
		},
	},
	methods:
	{
		onBackClick()
		{
			EventEmitter.emit(EventType.dialog.closeComments);
		},
		loc(phraseCode: string): string
		{
			return this.$Bitrix.Loc.getMessage(phraseCode);
		},
	},
	template: `
		<ChatHeader
			:dialogId="dialogId"
			:currentSidebarPanel="currentSidebarPanel"
			class="bx-im-comment-header__container"
		>
			<template #left>
				<div @click="onBackClick" class="bx-im-comment-header__back"></div>
				<div class="bx-im-comment-header__info">
					<div class="bx-im-comment-header__title">{{ loc('IM_CONTENT_COMMENTS_HEADER_TITLE') }}</div>
					<div class="bx-im-comment-header__subtitle">
						<div class="bx-im-comment-header__subtitle_avatar">
							<Avatar :dialogId="channelId" :size="AvatarSize.XS" />
						</div>
						<div class="bx-im-comment-header__subtitle_text">{{ channel.name }}</div>
					</div>
				</div>
			</template>
			<template v-if="showFollowToggle" #before-actions>
				<FollowToggle :dialogId="dialogId" />
			</template>
		</ChatHeader>
	`,
};
