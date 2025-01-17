<?php

namespace Bitrix\ImMobile\NavigationTab;

use Bitrix\Main\Localization\Loc;

trait MessengerComponentTitle
{
	public function getTitle(): ?string
	{
		return Loc::getMessage('TAB_NAME_IM_RECENT_FULL');
	}
}