import {ChatDialog} from 'im.v2.component.dialog.chat';
import {Layout, UserRole} from 'im.v2.const';

import {CommentsButton} from './comments-button';

import {ChannelMessageList} from './message-list';
import type { JsonObject } from 'main.core';
import type { ImModelChat, ImModelLayout } from 'im.v2.model';

type CommentCounterItem = { [commentChatId: string]: number };

// @vue/component
export const ChannelDialog = {
	name: 'ChannelDialog',
	components: { ChatDialog, ChannelMessageList, CommentsButton },
	props:
	{
		dialogId: {
			type: String,
			required: true,
		},
	},
	data(): JsonObject
	{
		return {
			localCommentsCounterMap: {},
		};
	},
	computed:
	{
		dialog(): ImModelChat
		{
			return this.$store.getters['chats/get'](this.dialogId, true);
		},
		layout(): ImModelLayout
		{
			return this.$store.getters['application/getLayout'];
		},
		isGuest(): boolean
		{
			return this.dialog.role === UserRole.guest;
		},
		isChatLayout(): boolean
		{
			return this.layout.name === Layout.chat.name;
		},
		realCommentsWithCounter(): number[]
		{
			return this.$store.getters['counters/getCommentsWithCounter'](this.dialog.chatId);
		},
		realCommentsCounterMap(): CommentCounterItem
		{
			const map = {};
			this.realCommentsWithCounter.forEach((commentChatId) => {
				map[commentChatId] = this.$store.getters['counters/getSpecificCommentsCounter']({
					channelId: this.dialog.chatId,
					commentChatId,
				});
			});

			return map;
		},
		localCommentsQueue(): number[]
		{
			return Object.keys(this.localCommentsCounterMap).map((key) => Number(key));
		},
		localTotalCommentsCounter(): number
		{
			let counter = 0;
			Object.values(this.localCommentsCounterMap).forEach((singleCounter) => {
				counter += singleCounter;
			});

			return counter;
		},
		showCommentsButton(): boolean
		{
			return this.isChatLayout && this.localCommentsQueue.length > 0;
		},
	},
	watch:
	{
		realCommentsWithCounter(newList: number[], oldList: number[]) {
			const addedChatIds = this.getAddedElements(newList, oldList);
			addedChatIds.forEach((addedChatId) => {
				this.localCommentsCounterMap[addedChatId] = this.realCommentsCounterMap[addedChatId];
			});

			const removedChatIds = this.getRemovedElements(newList, oldList);
			removedChatIds.forEach((removedChatId) => {
				delete this.localCommentsCounterMap[removedChatId];
			});
		},
	},
	created()
	{
		this.localCommentsCounterMap = { ...this.realCommentsCounterMap };
	},
	methods:
	{
		async onCommentsButtonClick()
		{
			const [chatIdToJump] = this.localCommentsQueue;
			const messageIdToJump: ?number = this.$store.getters['messages/comments/getMessageIdByChatId'](chatIdToJump);

			if (messageIdToJump)
			{
				this.$refs.dialog.goToMessageContext(messageIdToJump);
				delete this.localCommentsCounterMap[chatIdToJump];

				return;
			}

			await this.goToMessageContextByCommentsChatId(chatIdToJump);
			delete this.localCommentsCounterMap[chatIdToJump];
		},
		async goToMessageContextByCommentsChatId(chatId: string)
		{
			this.$refs.dialog.showLoadingBar();
			const messageId = await this.$refs.dialog.getMessageService().loadContextByChatId(chatId)
				.catch((error) => {
					// eslint-disable-next-line no-console
					console.error('ChannelDialog: goToMessageContextByCommentsChatId error', error);
				});
			this.$refs.dialog.hideLoadingBar();

			if (!messageId)
			{
				// eslint-disable-next-line no-console
				console.error('ChannelDialog: no messageId after loading context');
			}

			await this.$nextTick();
			this.$refs.dialog.getScrollManager().scrollToMessage(messageId);
			await this.$nextTick();
			this.$refs.dialog.highlightMessage(messageId);
		},
		getAddedElements(newList: number[], oldList: number[]): number[]
		{
			return newList.filter((chatId) => {
				return !oldList.includes(chatId);
			});
		},
		getRemovedElements(newList: number[], oldList: number[]): number[]
		{
			return oldList.filter((chatId) => {
				return !newList.includes(chatId);
			});
		},
	},
	template: `
		<ChatDialog ref="dialog" :dialogId="dialogId" :resetOnExit="isGuest">
			<template #message-list>
				<ChannelMessageList :dialogId="dialogId" />
			</template>
			<template #additional-float-button>
				<Transition name="float-button-transition">
					<CommentsButton
						v-if="showCommentsButton"
						:dialogId="dialogId"
						:counter="localTotalCommentsCounter"
						@click="onCommentsButtonClick"
						key="comments"
					/>
				</Transition>
			</template>
		</ChatDialog>
	`,
};
