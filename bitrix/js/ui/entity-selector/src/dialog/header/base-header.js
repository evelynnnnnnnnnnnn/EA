import {Cache, Dom, Tag, Type} from 'main.core';
import Dialog from '../dialog';
import type Tab from '../tabs/tab';
import type { HeaderOptions } from './header-content';

export default class BaseHeader
{
	dialog: Dialog = null;
	tab: Tab = null;
	container: ?HTMLElement = null;
	cache = new Cache.MemoryCache();

	constructor(context: Dialog | Tab, options: HeaderOptions)
	{
		this.options = Type.isPlainObject(options) ? options : {};

		if (context instanceof Dialog)
		{
			this.dialog = context;
		}
		else
		{
			this.tab = context;
			this.dialog = this.tab.getDialog();
		}
	}

	getDialog(): Dialog
	{
		return this.dialog;
	}

	getTab(): ?Tab
	{
		return this.tab;
	}

	show(): void
	{
		Dom.addClass(this.getContainer(), 'ui-selector-header--show');
	}

	hide(): void
	{
		Dom.removeClass(this.getContainer(), 'ui-selector-header--show');
	}

	getOptions(): HeaderOptions
	{
		return this.options;
	}

	getOption(option: string, defaultValue?: any): any
	{
		if (!Type.isUndefined(this.options[option]))
		{
			return this.options[option];
		}
		else if (!Type.isUndefined(defaultValue))
		{
			return defaultValue;
		}

		return null;
	}

	getContainer(): HTMLElement
	{
		if (this.container === null)
		{
			this.container = Tag.render`
				<div class="ui-selector-header">${this.render()}</div>
			`;
		}

		return this.container;
	}

	/**
	 * @abstract
	 */
	render(): HTMLElement
	{
		throw new Error('You must implement render() method.');
	}
}