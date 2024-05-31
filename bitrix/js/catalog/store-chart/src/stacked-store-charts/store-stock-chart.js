// @flow

import {Loc} from "main.core";
import {StoreStackedChart} from "./store-stacked-chart";
import {TColumn, TSeries} from "../types/chart";

export type TStockStore = {
	name: string,
	sum_stored: number,
};

export class StoreStockChart extends StoreStackedChart<TStockStore>
{
	getChartLabel(): string | null
	{
		return super.getChartLabel();
	}

	isCommonChart(): boolean
	{
		return super.isCommonChart();
	}

	getChartSeries(): Array<TSeries>
	{
		return [
			{
				id: 'sum_stored',
				color: '#42659B',
				title: Loc.getMessage('STORE_STOCK_CHART_SUM_STORED_SERIES_TITLE'),
				getPopupContent: (storeData: TStockStore) => {
					return {
						title: Loc.getMessage('STORE_STOCK_CHART_SUM_STORED_SERIES_POPUP_TITLE'),
						content: `
							<div class="stacked-bar-chart-popup-info-item" style="display: block">
								<div class="stacked-bar-chart-popup-info-subtitle">${Loc.getMessage('STORE_STOCK_CHART_SUM_STORED_SERIES_POPUP_SUM')}</div>
								<div class="stacked-bar-chart-popup-info-value-box">
									<div id="chart-popup-template-sum" class="stacked-bar-chart-popup-info-value">${this.formatByCurrency(storeData.sum_stored)}</div>
								</div>
							</div>
						`,
					}
				},
			}
		];
	}

	getChartColumns(columns: Array<TStockStore>): Array<TColumn>
	{
		const stores = [];
		for (const storeId in columns)
		{
			stores.push(columns[storeId]);
		}

		return stores;
	}
}
