/**
 * @module crm/entity-tab/type/entities/lead
 */
jn.define('crm/entity-tab/type/entities/lead', (require, exports, module) => {
	const { Base: BaseEntityType } = require('crm/entity-tab/type/entities/base');
	const { excludeItem } = require('crm/entity-tab/type/traits/exclude-item');
	const { TypeId, TypeName } = require('crm/type');
	const { Loc } = require('loc');

	/**
	 * @class Lead
	 */
	class Lead extends BaseEntityType
	{
		/**
		 * @returns {Number}
		 */
		getId()
		{
			return TypeId.Lead;
		}

		/**
		 * @returns {String}
		 */
		getName()
		{
			return TypeName.Lead;
		}

		/**
		 * @returns {Object[]}
		 */
		getItemActions(permissions)
		{
			const actions = super.getItemActions(permissions);

			return [
				...actions,
				{
					id: 'exclude',
					title: Loc.getMessage('M_CRM_ENTITY_TAB_ACTION_EXCLUDE'),
					sort: 500,
					onClickCallback: excludeItem.bind(this),
					onDisableClick: this.showForbiddenActionNotification.bind(this),
					data: {
						svgIcon: '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.2524 16.1863C8.34512 16.8561 9.63052 17.2423 11.0061 17.2423C14.9785 17.2423 18.1988 14.022 18.1988 10.0496C18.1988 8.67398 17.8127 7.38858 17.1429 6.29586L7.2524 16.1863H7.2524ZM4.86933 13.8039L14.7598 3.9134C13.6671 3.24358 12.3817 2.85742 11.0061 2.85742C7.03365 2.85742 3.81335 6.07771 3.81335 10.0501C3.81335 11.4257 4.19951 12.7111 4.86933 13.8039ZM11.0061 20.0689C5.47261 20.0689 0.986816 15.5831 0.986816 10.0496C0.986816 4.51607 5.47261 0.0302734 11.0061 0.0302734C16.5396 0.0302734 21.0254 4.51607 21.0254 10.0496C21.0254 15.5831 16.5396 20.0689 11.0061 20.0689Z" fill="#6a737f"/></svg>',
					},
					isDisabled: !permissions.exclude,
				},
			];
		}
	}

	module.exports = { Lead };
});
