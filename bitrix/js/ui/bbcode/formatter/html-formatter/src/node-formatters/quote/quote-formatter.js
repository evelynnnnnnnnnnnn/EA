import {Dom} from 'main.core';

import './style.css';
import { NodeFormatter, type NodeFormatterOptions } from 'ui.bbcode.formatter';

export class QuoteNodeFormatter extends NodeFormatter
{
	constructor(options: NodeFormatterOptions = {})
	{
		super({
			name: 'quote',
			convert(): HTMLQuoteElement {
				return Dom.create({
					tag: 'blockquote',
					attrs: {
						className: 'ui-formatter-blockquote',
					},
				});
			},
			...options,
		});
	}
}
