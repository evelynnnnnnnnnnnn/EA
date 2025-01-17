import { ajax as Ajax, Loc, Tag, Text, Type, Uri } from 'main.core';
import { Popup } from 'main.popup';
import { Button } from 'ui.buttons';
import { BaseEvent, EventEmitter } from 'main.core.events';
import 'sidepanel';

export type SourceDashboardInfo = {
	title: string,
	link: string,
}

type DashboardInfo = {
	id: number,
	isEditable: boolean,
	type: 'SYSTEM' | 'MARKET' | 'CUSTOM',
	appId: string, // for analytic
	editLink: string,
	title: string,
	sourceDashboardInfo?: SourceDashboardInfo,
};

export class DashboardManager
{
	static DASHBOARD_STATUS_LOAD = 'L';
	static DASHBOARD_STATUS_READY = 'R';
	static DASHBOARD_STATUS_FAILED = 'F';

	constructor()
	{
		this.subscribeOnEvents();
	}

	subscribeOnEvents()
	{
		BX.PULL && BX.PULL.extendWatch('superset_dashboard', true);
		EventEmitter.subscribe('onPullEvent-biconnector', (event: BaseEvent) => {
			const [eventName, eventData] = event.data;
			if (eventName !== 'onDashboardStatusUpdated' || !eventData)
			{
				return;
			}

			const dashboardList = eventData?.dashboardList;
			if (dashboardList)
			{
				EventEmitter.emit('BIConnector.Superset.DashboardManager:onDashboardBatchStatusUpdate', {
					dashboardList: dashboardList,
				});
			}
		});
	}

	processEditDashboard(
		dashboardInfo: DashboardInfo,
		onCloseProcessing: () => void = () => {},
		onCompleteProcessing: (popupType: string) => void = () => {},
		onFailProcessing: (popupType: string) => void = () => {},
	)
	{
		if (dashboardInfo.type === 'CUSTOM')
		{
			this.processLoginDashboard(dashboardInfo, onCloseProcessing, onCompleteProcessing, onFailProcessing);
		}
		else
		{
			this.processCopyDashboard(dashboardInfo, onCloseProcessing, onCompleteProcessing, onFailProcessing);
		}
	}

	processCopyDashboard(
		dashboardInfo: DashboardInfo,
		onCloseProcessing: (popupType: string) => void = () => {},
		onCompleteProcessing: (popupType: string) => void = () => {},
		onFailProcessing: (popupType: string) => void = () => {},
	): void
	{
		const attentionText = dashboardInfo.type === 'SYSTEM'
			? Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_LOGIN_POPUP_COPY_SYSTEM_DASHBOARD_ATTENTION')
			: Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_LOGIN_POPUP_COPY_MARKET_DASHBOARD_ATTENTION')
		;
		const confirmContent = Tag.render`
			<div class="dashboard-login-popup-copy-attention">
				${attentionText}
			</div>
		`;

		const popupType = 'popup_copy';

		const continueBtn = new Button({
			text: Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_LOGIN_POPUP_CONTINUE_BTN'),
			color: Button.Color.PRIMARY,
			onclick: () => {
				continueBtn.setWaiting(true);
				this.duplicateDashboard(dashboardInfo.id)
					.then((response) => {
						onCompleteProcessing(popupType);
						const dashboard = response.data.dashboard;
						if (dashboard)
						{
							window.open(dashboard.detail_url, '_top');
						}
						else
						{
							BX.UI.Notification.Center.notify({
								content: BX.util.htmlspecialchars(
									Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_COPY_ERROR'),
								),
							});
						}
					})
					.catch((response) => {
						onFailProcessing(popupType);
						if (response.errors && Type.isStringFilled(response.errors[0]?.message))
						{
							BX.UI.Notification.Center.notify({
								content: Text.encode(response.errors[0].message),
							});
						}
					});
			},
		});

		const popup = new Popup({
			content: confirmContent,
			overlay: true,
			width: 620,
			className: 'dashboard-login-popup',
			closeIcon: true,
			closeByEsc: true,
			disableScroll: true,
			titleBar: Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_LOGIN_POPUP_TITLE'),
			buttons: [
				continueBtn,
				new Button({
					text: Loc.getMessage('SUPERSET_DASHBOARD_DETAIL_LOGIN_POPUP_CANCEL_BTN'),
					color: Button.Color.LIGHT,
					onclick: () => {
						popup.close();
					},
				}),
			],
			events: {
				onClose: () => {
					onCloseProcessing('popup_copy');
				},
			},
		});

		popup.show();
	}

	processLoginDashboard(
		dashboardInfo: DashboardInfo,
		onCloseProcessing: (popupType: string) => void = () => {},
		onCompleteProcessing: (popupType: string) => void = () => {},
		onFailProcessing: (popupType: string) => void = () => {},
	): void
	{
		const popupType = 'popup_login';

		this.getEditUrl(dashboardInfo)
			.then((response) => {
				onCompleteProcessing(popupType);
				if (response)
				{
					window.open(response, '_blank').focus();
				}
			})
			.catch(() => {
				onFailProcessing(popupType);
				window.open(dashboardInfo.editLink, '_blank').focus();
			})
			.finally(() => {
				onCloseProcessing();
			});
	}

	duplicateDashboard(dashboardId: number | string): Promise
	{
		return Ajax.runAction('biconnector.dashboard.copy', {
			data: {
				id: dashboardId,
			},
		});
	}

	exportDashboard(
		dashboardId: number,
		onSuccessfulExport: ?function,
		onFailedExport: ?function,
	): Promise
	{
		return Ajax.runAction('biconnector.dashboard.export', {
			data: {
				id: dashboardId,
			},
		})
			.then((response) => {
				const filePath = response.data.filePath;
				if (filePath)
				{
					window.open(filePath, '_self');
				}

				if (Type.isFunction(onSuccessfulExport))
				{
					onSuccessfulExport();
				}
			})
			.catch((response) => {
				BX.UI.Notification.Center.notify({
					content: BX.util.htmlspecialchars(response.errors[0].message),
				});
				if (Type.isFunction(onFailedExport))
				{
					onFailedExport();
				}
			});
	}

	deleteDashboard(dashboardId): Promise
	{
		return Ajax.runAction('biconnector.dashboard.delete', {
			data: {
				id: dashboardId,
			},
		});
	}

	renameDashboard(dashboardId: number, title: string): Promise
	{
		return Ajax.runAction('biconnector.dashboard.rename', {
			data: {
				id: dashboardId,
				title: title,
			},
		});
	}

	restartDashboardImport(dashboardId: number): Promise
	{
		return Ajax.runAction('biconnector.dashboard.restartImport', {
			data: {
				id: dashboardId,
			},
		}).then(
			(response) => {
				const dashboardIds = response?.data?.restartedDashboardIds;
				if (!dashboardIds)
				{
					return;
				}

				const dashboardList = [];
				for (const restartedDashboardId of dashboardIds)
				{
					dashboardList.push({
						id: Number(restartedDashboardId),
						status: 'L',
					});
				}

				EventEmitter.emit(window, 'BIConnector.Superset.DashboardManager:onDashboardBatchStatusUpdate', {
					dashboardList: dashboardList,
				});
			},
		);
	}

	setDashboardTags(dashboardId: number, tags: {}): Promise
	{
		return Ajax.runAction('biconnector.dashboard.setDashboardTags', {
			data: {
				id: dashboardId,
				tags,
			},
		});
	}

	addTag(title: string): Promise
	{
		return Ajax.runAction('biconnector.dashboardTag.add', {
			data: {
				title,
			},
		});
	}

	static openSettingPeriodSlider(dashboardId: number = null)
	{
		const componentLink = dashboardId === null
			? '/bitrix/components/bitrix/biconnector.apachesuperset.setting/slider.php'
			: '/bitrix/components/bitrix/biconnector.apachesuperset.dashboard.setting/slider.php'
		;

		const sliderLink = new Uri(componentLink);
		if (dashboardId !== null)
		{
			sliderLink.setQueryParam('DASHBOARD_ID', Text.toNumber(dashboardId));
		}

		BX.SidePanel.Instance.open(
			sliderLink.toString(),
			{
				width: 790,
				allowChangeHistory: false,
				cacheable: false,
			},
		);
	}

	createEmptyDashboard(): Promise
	{
		return Ajax.runAction('biconnector.dashboard.createEmptyDashboard', {
			data: {},
		});
	}

	getEditUrl(dashboardInfo: DashboardInfo): Promise
	{
		return new Promise((resolve, reject) => {
			Ajax.runAction(
				'biconnector.dashboard.getEditUrl',
				{
					data: {
						editUrl: dashboardInfo.editLink,
					},
				},
			)
				.then((response) => {
					const data = response.data;
					if (data)
					{
						resolve(data);
					}
				})
				.catch((e) => {
					reject(e);
				});
		});
	}
}
