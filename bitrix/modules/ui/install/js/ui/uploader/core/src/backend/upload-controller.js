import { ajax as Ajax, Type, type AjaxResponse, type JsonObject } from 'main.core';

import Server from './server';
import Chunk from './chunk';
import AbstractUploadController from './abstract-upload-controller';
import UploaderError from '../uploader-error';
import type UploaderFile from '../uploader-file';

export default class UploadController extends AbstractUploadController
{
	#file: UploaderFile = null;
	#chunkOffset: ?number = null;
	#chunkTimeout: ?number = null;
	#token: string = null;
	#xhr: XMLHttpRequest = null;
	#aborted: boolean = false;

	constructor(server: Server, options: { [key: string]: any } = {})
	{
		super(server, options);
	}

	upload(file: UploaderFile): void
	{
		if (!Type.isFile(file.getBinary()))
		{
			this.emit('onError', { error: new UploaderError('WRONG_FILE_SOURCE') });

			return;
		}

		if (this.#chunkOffset !== null)
		{
			return;
		}

		this.#file = file;

		const nextChunk: ?Chunk = this.#getNextChunk();
		if (nextChunk)
		{
			this.#uploadChunk(nextChunk);
		}
	}

	abort(): void
	{
		if (this.#xhr)
		{
			this.#aborted = true;
			this.#xhr.abort();
			this.#xhr = null;
		}

		clearTimeout(this.#chunkTimeout);
	}

	#uploadChunk(chunk: Chunk): void
	{
		const totalSize: number = this.getFile().getSize();
		const isOnlyOneChunk: boolean = chunk.getOffset() === 0 && totalSize === chunk.getSize();

		let fileName: string = this.getFile().getName();
		if (fileName.normalize)
		{
			fileName = fileName.normalize();
		}

		const type: string = Type.isStringFilled(this.getFile().getType())
			? this.getFile().getType()
			: 'application/octet-stream'
		;

		const headers = [
			{ name: 'Content-Type', value: type },
			{ name: 'X-Upload-Content-Name', value: encodeURIComponent(fileName) },
		];

		if (!isOnlyOneChunk)
		{
			const rangeStart: number = chunk.getOffset();
			const rangeEnd: number = chunk.getOffset() + chunk.getSize() - 1;
			const rangeHeader = `bytes ${rangeStart}-${rangeEnd}/${totalSize}`;

			headers.push({ name: 'Content-Range', value: rangeHeader });
		}

		const controllerOptions = this.getServer().getControllerOptions();
		Ajax.runAction('ui.fileuploader.upload', {
			headers,
			data: chunk.getData(),
			preparePost: false,
			getParameters: {
				controller: this.getServer().getController(),
				controllerOptions: controllerOptions ? JSON.stringify(controllerOptions) : null,
				token: this.getToken() || '',
			},
			onrequeststart: (xhr): void => {
				this.#xhr = xhr;
				this.#aborted = false;
			},
			onprogressupload: (event: ProgressEvent): void => {
				if (event.lengthComputable)
				{
					const size: number = this.getFile().getSize();
					const uploadedBytes: number = Math.min(size, chunk.getOffset() + event.loaded);
					const progress: number = size > 0 ? Math.floor(uploadedBytes / size * 100) : 100;
					this.emit('onProgress', { progress });
				}
			},
		})
			.then((response) => {
				if (response.data.token)
				{
					this.setToken(response.data.token);

					if (this.getFile().getServerFileId() === null)
					{
						// Now we can remove a temp file on the backend
						this.getFile().setServerFileId(response.data.token);
					}

					const size: number = this.getFile().getSize();
					const progress: number = size > 0 ? Math.floor((chunk.getOffset() + chunk.getSize()) / size * 100) : 100;
					this.emit('onProgress', { progress });

					const nextChunk: ?Chunk = this.#getNextChunk();
					if (nextChunk)
					{
						this.#uploadChunk(nextChunk);
					}
					else
					{
						this.emit('onProgress', { progress: 100 });
						this.emit('onUpload', { fileInfo: response.data.file });
					}
				}
				else
				{
					this.emit('onError', { error: new UploaderError('SERVER_ERROR') });
				}
			})
			.catch((response: AjaxResponse<JsonObject>) => {
				if (this.#aborted)
				{
					return;
				}

				const error: UploaderError = UploaderError.createFromAjaxErrors(response.errors);
				const shouldRetry: boolean = (
					error.getCode() === 'NETWORK_ERROR'
					|| error.getType() === UploaderError.Type.UNKNOWN
				);

				if (!shouldRetry || !this.#retryUploadChunk(chunk))
				{
					this.emit('onError', { error });
				}
			})
		;
	}

	#retryUploadChunk(chunk: Chunk): boolean
	{
		const nextDelay: ?number = chunk.getNextRetryDelay();
		if (nextDelay === null)
		{
			return false;
		}

		clearTimeout(this.#chunkTimeout);

		this.#chunkTimeout = setTimeout((): void => {
			this.#uploadChunk(chunk);
		}, nextDelay);

		return true;
	}

	#getNextChunk(): ?Chunk
	{
		if (this.getChunkOffset() !== null && this.getChunkOffset() >= this.getFile().getSize())
		{
			// End of File
			return null;
		}

		if (this.getChunkOffset() === null)
		{
			// First call
			this.#chunkOffset = 0;
		}

		let chunk: Chunk = null;
		if (this.getChunkOffset() === 0 && this.getFile().getSize() <= this.getChunkSize())
		{
			chunk = new Chunk(this.getFile().getBinary(), this.getChunkOffset());
			this.#chunkOffset = this.getFile().getSize();
		}
		else
		{
			const currentChunkSize: number = Math.min(this.getChunkSize(), this.getFile().getSize() - this.getChunkOffset());
			const nextOffset: number = this.getChunkOffset() + currentChunkSize;
			const fileRange: Blob = this.getFile().getBinary().slice(this.getChunkOffset(), nextOffset);

			chunk = new Chunk(fileRange, this.getChunkOffset());
			this.#chunkOffset = nextOffset;
		}

		chunk.setRetries([...this.getServer().getChunkRetryDelays()]);

		return chunk;
	}

	getFile(): UploaderFile
	{
		return this.#file;
	}

	getChunkSize(): number
	{
		return this.getServer().getChunkSize();
	}

	getChunkOffset(): number
	{
		return this.#chunkOffset;
	}

	getToken(): ?string
	{
		return this.#token;
	}

	setToken(token: string): void
	{
		if (Type.isStringFilled(token))
		{
			this.#token = token;
		}
	}
}
