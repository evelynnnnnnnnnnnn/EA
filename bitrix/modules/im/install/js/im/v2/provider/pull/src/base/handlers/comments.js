import {Core} from 'im.v2.application.core';
import {Logger} from 'im.v2.lib.logger';

import {CommentSubscribeParams} from '../../types/comments';

export class CommentsPullHandler
{
	handleCommentSubscribe(params: CommentSubscribeParams)
	{
		Logger.warn('CommentsPullHandler: handleCommentSubscribe', params);
		if (params.subscribe)
		{
			Core.getStore().dispatch('chats/unmute', {
				dialogId: params.dialogId,
			});

			return;
		}

		Core.getStore().dispatch('chats/mute', {
			dialogId: params.dialogId,
		});
	}
}
