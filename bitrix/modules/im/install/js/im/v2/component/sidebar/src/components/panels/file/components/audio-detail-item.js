import {ImModelFile, ImModelSidebarFileItem} from 'im.v2.model';
import {AudioPlayer, Avatar, AvatarSize} from 'im.v2.component.elements';

import '../css/audio-detail-item.css';

// @vue/component
export const AudioDetailItem = {
	name: 'AudioDetailItem',
	components: { AudioPlayer, Avatar },
	props: {
		id: {
			type: Number,
			required: true,
		},
		fileItem: {
			type: Object,
			required: true,
		},
	},
	emits: ['contextMenuClick'],
	data() {
		return {
			timelineType: 0,
		};
	},
	computed:
	{
		AvatarSize: () => AvatarSize,
		sidebarFileItem(): ImModelSidebarFileItem
		{
			return this.fileItem;
		},
		file(): ImModelFile
		{
			return this.$store.getters['files/get'](this.sidebarFileItem.fileId, true);
		},
		audioUrl(): string
		{
			return this.file.urlDownload;
		},
	},
	created()
	{
		this.timelineType = Math.floor(Math.random() * 5);
	},
	methods:
	{
		onContextMenuClick(event)
		{
			this.$emit('contextMenuClick', {
				sidebarFile: this.sidebarFileItem,
				file: this.file,
				messageId: this.sidebarFileItem.messageId,
			}, event.currentTarget);
		},
	},
	template: `
		<div class="bx-im-sidebar-file-audio-detail-item__container bx-im-sidebar-file-audio-detail-item__scope">
			<AudioPlayer 
				:id="id"
				:src="audioUrl" 
				:file="file" 
				:timelineType="timelineType" 
				:authorId="sidebarFileItem.authorId" 
				@contextMenuClick="onContextMenuClick"
			/>
		</div>
	`,
};
