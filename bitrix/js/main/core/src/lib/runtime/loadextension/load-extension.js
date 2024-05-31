import extensionsStorage from './internal/extensions-storage';
import Type from '../../type';
import Extension, { type ExtensionPromiseValue } from './internal/extension';

export default async function loadExtension(...extensionName: Array<string>): Promise<any>
{
	const extensionNames: Array<string> = extensionName.flat();

	const result: Array<Promise<ExtensionPromiseValue>> = extensionNames.map((name: string) => {
		if (extensionsStorage.has(name))
		{
			return extensionsStorage.get(name).load();
		}

		const extension: Extension = new Extension({ name });
		extensionsStorage.set(name, extension);

		return extension.load();
	});

	return Promise
		.all(result)
		.then((exports: Array<any>) => {
			return exports.reduce((acc, currentExports) => {
				if (Type.isPlainObject(currentExports))
				{
					return { ...acc, ...currentExports };
				}

				return acc;
			}, {});
		});
}
