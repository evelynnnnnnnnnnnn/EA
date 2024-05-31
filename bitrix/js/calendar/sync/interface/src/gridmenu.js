export class GridMenu
{

	constructor(options)
	{
		this.provider = options.provider;
		this.gridUnit = options.gridUnit;
	}

	createInstance(options)
	{
		return new this(options);
	}

	showOutlookMenu()
	{

	}

	getCaldavMenu()
	{

	}


}