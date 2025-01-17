import {Util} from 'calendar.util';
import {DateTimeControl} from "calendar.controls";
import {Dom, Type} from "main.core";

export class RepeatSelector
{
	constructor(params)
	{
		let formElements =  params.rruleType.form.elements;

		this.getDate = params.getDate;
		this.previousDate = null;
		this.DOM = {
			formElements: formElements,
			wrap: params.wrap,
			rruleType: params.rruleType,
			interval: formElements['EVENT_RRULE[INTERVAL]'],
			rruleEndsOn: {
				never: formElements['rrule_endson'][0],
				count: formElements['rrule_endson'][1],
				until: formElements['rrule_endson'][2],
			},
			count: formElements['EVENT_RRULE[COUNT]'],
			until: formElements['EVENT_RRULE[UNTIL]'],
		};
		this.viewMode = false;

		this.create();
	}

	create()
	{
		BX.bind(this.DOM.rruleType, 'change', () => {
			this.changeType(this.DOM.rruleType.value);
		});

		BX.bind(this.DOM.until, 'click', (e) => {
			DateTimeControl.showInputCalendar(e);
			this.DOM.rruleEndsOn.until.checked = true;
		});

		BX.bind(this.DOM.count, 'click', () => {
			this.DOM.rruleEndsOn.count.checked = true;
		});
	}

	changeType(type)
	{
		this.DOM.rruleType.value = type ? type.toUpperCase() : 'NONE';
		let rruleType = this.DOM.rruleType.value.toLowerCase();
		this.DOM.wrap.className = 'calendar-rrule-type-' + rruleType;

		if (rruleType === 'weekly' && BX.type.isFunction(this.getDate))
		{
			let fromDate = this.getDate();
			if (BX.type.isDate(fromDate))
			{
				let day = Util.getWeekDayByInd(fromDate.getDay());
				this.DOM.formElements['EVENT_RRULE[BYDAY][]'].forEach(function(input)
				{
					if (input.checked && this.previousDay === input.value && this.previousDay !== day)
					{
						input.checked = false;
					}
					else
					{
						input.checked = input.checked || input.value === day;
					}
				}, this)
				
				this.previousDay = day;
			}
		}
	}

	setValue(rrule = {})
	{
		if (Type.isNil(rrule))
		{
			rrule = {};
		}

		this.changeType(rrule.FREQ);
		this.DOM.interval.value = rrule.INTERVAL || 1;
		if (rrule.COUNT)
		{
			this.DOM.rruleEndsOn.count.checked = 'checked';
			this.DOM.count.value = rrule.COUNT;
		}
		else if(rrule['~UNTIL'])
		{
			this.DOM.rruleEndsOn.until.checked = 'checked';
			this.DOM.until.value = rrule['~UNTIL'];
		}
		else
		{
			this.DOM.rruleEndsOn.never.checked = 'checked';
		}

		if (BX.type.isPlainObject(rrule.BYDAY))
		{
			this.DOM.formElements['EVENT_RRULE[BYDAY][]'].forEach(function(input)
			{
				input.checked = rrule.BYDAY.hasOwnProperty(input.value);
			}, this)
		}
	}

	getType()
	{
		return this.DOM.rruleType.value.toLowerCase();
	}

	setViewMode(description: string)
	{
		if (!Type.isStringFilled(description))
		{
			description = this.DOM.rruleType.options[this.DOM.rruleType.options.selectedIndex].innerText;
		}
		Dom.clean(this.DOM.wrap);
		this.DOM.wrap.innerText = description.toLowerCase();
		Dom.addClass(this.DOM.wrap, 'calendar-field calendar-repeat-selector-readonly');
	}
}