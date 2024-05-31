import {EventEmitter} from "main.core.events";
import {ProductSetField} from "./productset";
import type {BaseEvent} from "main.core.events";

export class ProductSetFieldFactory
{
	constructor(entityEditorControlFactory = 'BX.UI.EntityEditorControlFactory')
	{
		EventEmitter.subscribe(entityEditorControlFactory + ':onInitialize', (event: BaseEvent) => {
			const [, eventArgs] = event.getCompatData();
			eventArgs.methods['productSet'] = this.factory.bind(this);
		});
	}

	factory(type, controlId, settings)
	{
		if (type === 'productSet')
		{
			return ProductSetField.create(controlId, settings);
		}

		return null;
	}
}