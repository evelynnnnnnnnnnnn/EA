import {Type} from 'main.core';
import {EventEmitter} from 'main.core.events';

import {EventType, RecentSettingsMap, SettingsMap} from 'im.old-chat-embedding.const';
import {Logger} from 'im.old-chat-embedding.lib.logger';
import {Utils} from 'im.old-chat-embedding.lib.utils';

export class SettingsManager
{
	static instance = null;
	store: Object = null;

	static init($Bitrix): void
	{
		if (this.instance)
		{
			return;
		}

		this.instance = new this($Bitrix);
	}

	constructor($Bitrix)
	{
		this.store = $Bitrix.Data.get('controller').store;
		this.initSettings();

		this.onSettingsChangeHandler = this.onSettingsChange.bind(this);
		EventEmitter.subscribe(EventType.dialog.settingsChange, this.onSettingsChangeHandler);

		if (Utils.platform.isBitrixDesktop() && !Type.isUndefined(BX.desktop))
		{
			BX.desktop.addCustomEvent('bxSaveSettings', (settings) => {
				this.onSettingsChangeHandler({data: settings});
			});
		}
	}

	initSettings()
	{
		if (!BX.MessengerProxy)
		{
			console.error('Im.RecentList: SettingsManager: BX.MessengerProxy is not available');
			return false;
		}

		this.initGeneralSettings();
		this.initRecentSettings();
	}

	initGeneralSettings()
	{
		const initialSettings = {};
		Object.entries(SettingsMap).forEach(([oldName, name]) => {
			initialSettings[name] = BX.MessengerProxy.getOption(oldName);
		});

		this.store.dispatch('application/setOptions', initialSettings);
	}

	initRecentSettings()
	{
		const initialSettings = {};
		Object.entries(RecentSettingsMap).forEach(([oldName, name]) => {
			initialSettings[name] = BX.MessengerProxy.getOption(oldName);
		});

		this.store.dispatch('recent/setOptions', initialSettings);
	}

	onSettingsChange({data: event})
	{
		Logger.warn('Im.RecentList: SettingsChange', event);
		const generalSettings = {};
		const recentSettings = {};
		Object.entries(event).forEach(([name, value]) => {
			if (Object.keys(RecentSettingsMap).includes(name))
			{
				recentSettings[RecentSettingsMap[name]] = value;
			}

			if (Object.keys(SettingsMap).includes(name))
			{
				generalSettings[SettingsMap[name]] = value;
			}
		});

		this.store.dispatch('application/setOptions', generalSettings);
		this.store.dispatch('recent/setOptions', recentSettings);
	}

	destroy()
	{
		EventEmitter.unsubscribe(EventType.dialog.settingsChange, this.onSettingsChangeHandler);
	}
}