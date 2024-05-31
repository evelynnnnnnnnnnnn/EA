import {Type} from 'main.core';
import {BuilderModel} from 'ui.vue3.vuex';

import {formatFieldsWithConfig} from 'im.v2.model';

import {commentFieldsConfig} from './format/field-config';
import type { JsonObject } from 'main.core';
import type { ImModelCommentInfo } from 'im.v2.model';
import type { RawCommentInfo } from 'im.v2.provider.service';

const LAST_USERS_TO_SHOW = 3;

type CommentsState = {
	collection: {
		[messageId: string]: ImModelCommentInfo
	}
};

export class CommentsModel extends BuilderModel
{
	getState(): CommentsState
	{
		return {
			collection: {},
		};
	}

	getElementState(): ImModelCommentInfo
	{
		return {
			chatId: 0,
			lastUserIds: [],
			messageCount: 0,
			messageId: 0,
		};
	}

	getGetters(): Object
	{
		return {
			/** @function messages/comments/getByMessageId */
			getByMessageId: (state: CommentsState) => (messageId: number): ?ImModelCommentInfo => {
				return state.collection[messageId] ?? this.getElementState();
			},
			/** @function messages/comments/getMessageIdByChatId */
			getMessageIdByChatId: (state: CommentsState) => (chatId: number): ?number => {
				const collection = Object.values(state.collection);
				const foundItem = collection.find((item) => {
					return item.chatId === chatId;
				});

				return foundItem?.messageId;
			},
		};
	}

	getActions(): Object
	{
		return {
			/** @function messages/comments/set */
			set: (store, rawPayload: RawCommentInfo[] | RawCommentInfo) => {
				let payload = rawPayload;
				if (!payload)
				{
					return;
				}

				if (!Array.isArray(payload) && Type.isPlainObject(payload))
				{
					payload = [payload];
				}

				payload = payload.map((item: RawCommentInfo) => {
					const currentItem: ImModelCommentInfo = store.state.collection[item.messageId];
					if (currentItem)
					{
						return { ...currentItem, ...this.#formatFields(item) };
					}

					return { ...this.getElementState(), ...this.#formatFields(item) };
				});

				store.commit('set', payload);
			},
			/** @function messages/comments/setLastUser */
			setLastUser: (store, payload: { messageId: number, newUserId: number }) => {
				const { messageId, newUserId } = payload;
				const currentItem = store.state.collection[messageId];
				if (!currentItem || newUserId === 0)
				{
					return;
				}

				store.commit('setLastUser', payload);
			},
		};
	}

	/* eslint-disable no-param-reassign */
	getMutations(): Object
	{
		return {
			set: (state: CommentsState, payload: RawCommentInfo[]) => {
				payload.forEach((item) => {
					state.collection[item.messageId] = item;
				});
			},
			setLastUser: (state: CommentsState, payload: { messageId: number, newUserId: number }) => {
				const { messageId, newUserId } = payload;
				const { lastUserIds: currentUsers } = state.collection[messageId];
				if (currentUsers.includes(newUserId))
				{
					return;
				}

				if (currentUsers.length < LAST_USERS_TO_SHOW)
				{
					currentUsers.unshift(newUserId);

					return;
				}

				currentUsers.pop();
				currentUsers.unshift(newUserId);
			},
		};
	}

	#formatFields(fields: JsonObject): JsonObject
	{
		return formatFieldsWithConfig(fields, commentFieldsConfig);
	}
}
