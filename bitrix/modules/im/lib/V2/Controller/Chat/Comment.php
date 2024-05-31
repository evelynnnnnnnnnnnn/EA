<?php

namespace Bitrix\Im\V2\Controller\Chat;

use Bitrix\Im\V2\Chat;
use Bitrix\Im\V2\Controller\BaseController;
use Bitrix\Im\V2\Controller\Filter\ChatTypeFilter;

class Comment extends BaseController
{
	public function configureActions()
	{
		$config = parent::configureActions();

		$config['subscribe'] = [
			'+prefilters' => [
				new ChatTypeFilter([Chat\CommentChat::class]),
			],
		];
		$config['unsubscribe'] = [
			'+prefilters' => [
				new ChatTypeFilter([Chat\CommentChat::class]),
			],
		];

		return $config;
	}

	/**
	 * @restMethod im.v2.Chat.Comment.subscribe
	 */
	public function subscribeAction(Chat\CommentChat $chat): ?array
	{
		return $this->subscribe($chat, true);
	}

	/**
	 * @restMethod im.v2.Chat.Comment.unsubscribe
	 */
	public function unsubscribeAction(Chat\CommentChat $chat): ?array
	{
		return $this->subscribe($chat, false);
	}

	protected function subscribe(Chat\CommentChat $chat, bool $flag): ?array
	{
		$result = $chat->subscribe($flag);

		if (!$result->isSuccess())
		{
			$this->addErrors($result->getErrors());

			return null;
		}

		return ['result' => true];
	}
}