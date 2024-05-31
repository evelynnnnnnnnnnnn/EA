<?php

namespace Bitrix\Im\V2\Chat\Comment;

use Bitrix\Im\Model\ChatTable;
use Bitrix\Im\V2\Entity\User\UserShortPopupItem;
use Bitrix\Im\V2\Message\LastMessages;
use Bitrix\Im\V2\Rest\PopupData;
use Bitrix\Im\V2\Rest\PopupDataAggregatable;
use Bitrix\Im\V2\Rest\PopupDataItem;

class CommentPopupItem implements PopupDataItem, PopupDataAggregatable
{
	/**
	 * @var int[]
	 */
	private array $messageIds;
	private int $chatId;
	private array $userIds = [];
	private array $childChatIds = [];
	private ?array $commentsInfo = null;
	private ?LastMessages $lastMessages = null;

	public function __construct(int $chatId, array $messageIds = [])
	{
		$this->messageIds = array_unique($messageIds);
		$this->chatId = $chatId;
	}

	public function merge(PopupDataItem $item): self
	{
		if ($item instanceof self)
		{
			$this->messageIds = array_unique(array_merge($this->messageIds, $item->messageIds));
		}

		return $this;
	}

	public static function getRestEntityName(): string
	{
		return 'commentInfo';
	}

	public function toRestFormat(array $option = []): array
	{
		return $this->getInfo();
	}

	protected function getInfo(): array
	{
		if (empty($this->messageIds))
		{
			return [];
		}

		$this->fill();

		return $this->commentsInfo;
	}

	protected function fill(): void
	{
		$this->fillBaseCommentsInfo();
		$this->fillUsers();
	}

	protected function fillBaseCommentsInfo(): void
	{
		if (isset($this->commentsInfo))
		{
			return;
		}

		$this->commentsInfo = [];

		if (empty($this->messageIds))
		{
			return;
		}

		$raw = ChatTable::query()
			->setSelect(['ID', 'MESSAGE_COUNT', 'PARENT_MID'])
			->where('PARENT_ID', $this->chatId)
			->whereIn('PARENT_MID', $this->messageIds)
			->fetchAll()
		;

		foreach ($raw as $row)
		{
			$this->childChatIds[] = (int)$row['ID'];
			$this->commentsInfo[] = [
				'chatId' => (int)$row['ID'],
				'dialogId' => 'chat' . $row['ID'],
				'messageId' => (int)$row['PARENT_MID'],
				'lastUserIds' => [],
				'messageCount' => (int)$row['MESSAGE_COUNT']
			];
		}
	}

	protected function fillUsers(): void
	{
		$this->fillBaseCommentsInfo();
		$lastMessages = $this->getLastMessages();

		foreach ($this->commentsInfo as $key => $commentInfo)
		{
			$lastUserIds = $lastMessages->getUsersByChatId($commentInfo['chatId']);
			$this->commentsInfo[$key]['lastUserIds'] = $lastUserIds;

			foreach ($lastUserIds as $userId)
			{
				$this->userIds[$userId] = $userId;
			}
		}
	}

	protected function getLastMessages(): LastMessages
	{
		if (!isset($this->lastMessages))
		{
			$this->fillBaseCommentsInfo();
			$this->lastMessages = new LastMessages($this->childChatIds);
		}

		return $this->lastMessages;
	}

	public function getPopupData(array $excludedList = []): PopupData
	{
		$this->fillUsers();

		return new PopupData([new UserShortPopupItem($this->userIds)], $excludedList);
	}
}