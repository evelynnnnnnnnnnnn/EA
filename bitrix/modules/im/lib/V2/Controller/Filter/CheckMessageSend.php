<?php

namespace Bitrix\Im\V2\Controller\Filter;

use Bitrix\Im\V2\Chat;
use Bitrix\Im\V2\Chat\ChatError;
use Bitrix\Im\V2\Chat\PrivateChat;
use Bitrix\Main\Engine\ActionFilter\Base;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;

class CheckMessageSend extends Base
{
	public function onBeforeAction(Event $event)
	{
		$arguments = $this->getAction()->getArguments();
		$chat = $arguments['chat'];

		if (!$chat instanceof Chat)
		{
			$this->addError(new ChatError(ChatError::NOT_FOUND, 'Chat not found'));

			return new EventResult(EventResult::ERROR, null, null, $this);
		}

		$result = $this->canPost($chat);
		if (!$result)
		{
			$this->addError(new ChatError(ChatError::ACCESS_DENIED, 'Access denied'));

			return new EventResult(EventResult::ERROR, null, null, $this);
		}

		if (!$chat->checkAllowedAction('SEND'))
		{
			$this->addError(new ChatError(
				ChatError::ACCESS_DENIED,
				'It is forbidden to send messages to this chat'
			));

			return new EventResult(EventResult::ERROR, null, null, $this);
		}

		return null;
	}

	private function canPost(Chat $chat): bool
	{
		if ($chat instanceof PrivateChat)
		{
			return true;
		}

		$userRole = $chat->getRole();
		$chatRole = $chat->getManageMessages();

		return Chat\Permission::compareRole($userRole, $chatRole);
	}
}