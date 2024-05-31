/* eslint-disable */
this.BX = this.BX || {};
this.BX.Messenger = this.BX.Messenger || {};
this.BX.Messenger.v2 = this.BX.Messenger.v2 || {};
this.BX.Messenger.v2.Component = this.BX.Messenger.v2.Component || {};
(function (exports,im_v2_component_message_unsupported,ui_vue3_directives_lazyload,main_core_events,im_v2_lib_progressbar,im_v2_provider_service,im_v2_lib_menu,ui_icons_disk,im_v2_model,ui_vue3_components_socialvideo,im_v2_lib_utils,main_core,im_v2_component_message_elements,im_v2_component_message_base,im_v2_component_elements,im_v2_const) {
	'use strict';

	// @vue/component
	const ProgressBar = {
	  name: 'ProgressBar',
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    messageId: {
	      type: [String, Number],
	      required: true
	    }
	  },
	  computed: {
	    file() {
	      return this.item;
	    }
	  },
	  watch: {
	    'file.status': function () {
	      this.getProgressBarManager().update();
	    },
	    'file.progress': function () {
	      this.getProgressBarManager().update();
	    }
	  },
	  mounted() {
	    this.initProgressBar();
	  },
	  beforeUnmount() {
	    this.removeProgressBar();
	  },
	  methods: {
	    initProgressBar() {
	      if (this.file.progress === 100) {
	        return;
	      }
	      let blurElement;
	      if (this.file.progress < 0 || !this.isImage && !this.isVideo) {
	        blurElement = false;
	      }
	      this.progressBarManager = new im_v2_lib_progressbar.ProgressBarManager({
	        container: this.$refs['progress-bar'],
	        uploadState: this.file,
	        customConfig: {
	          blurElement,
	          hasTitle: false
	        }
	      });
	      this.progressBarManager.subscribe(im_v2_lib_progressbar.ProgressBarManager.event.cancel, () => {
	        main_core_events.EventEmitter.emit(im_v2_const.EventType.uploader.cancel, {
	          tempFileId: this.file.id,
	          tempMessageId: this.messageId
	        });
	      });
	      this.progressBarManager.subscribe(im_v2_lib_progressbar.ProgressBarManager.event.destroy, () => {
	        if (this.progressBar) {
	          this.progressBar = null;
	        }
	      });
	      this.progressBarManager.start();
	    },
	    removeProgressBar() {
	      if (!this.getProgressBarManager()) {
	        return;
	      }
	      this.getProgressBarManager().destroy();
	    },
	    getProgressBarManager() {
	      return this.progressBarManager;
	    }
	  },
	  template: `
		<div class="bx-im-progress-bar__container" ref="progress-bar"></div>
	`
	};

	const MAX_WIDTH = 420;
	const MAX_HEIGHT = 340;
	const MIN_WIDTH = 200;
	const MIN_HEIGHT = 100;

	// @vue/component
	const ImageItem = {
	  name: 'ImageItem',
	  directives: {
	    lazyload: ui_vue3_directives_lazyload.lazyload
	  },
	  components: {
	    ProgressBar
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    message: {
	      type: Object,
	      required: true
	    }
	  },
	  computed: {
	    messageItem() {
	      return this.message;
	    },
	    file() {
	      return this.item;
	    },
	    imageSize() {
	      let newWidth = this.file.image.width;
	      let newHeight = this.file.image.height;
	      if (this.file.image.width > MAX_WIDTH || this.file.image.height > MAX_HEIGHT) {
	        const aspectRatio = this.file.image.width / this.file.image.height;
	        if (this.file.image.width > MAX_WIDTH) {
	          newWidth = MAX_WIDTH;
	          newHeight = Math.round(MAX_WIDTH / aspectRatio);
	        }
	        if (newHeight > MAX_HEIGHT) {
	          newWidth = Math.round(MAX_HEIGHT * aspectRatio);
	          newHeight = MAX_HEIGHT;
	        }
	      }
	      const sizes = {
	        width: Math.max(newWidth, MIN_WIDTH),
	        height: Math.max(newHeight, MIN_HEIGHT)
	      };
	      return {
	        width: `${sizes.width}px`,
	        height: `${sizes.height}px`,
	        'object-fit': sizes.width < 100 || sizes.height < 100 ? 'cover' : 'contain'
	      };
	    },
	    viewerAttributes() {
	      return im_v2_lib_utils.Utils.file.getViewerDataAttributes(this.file.viewerAttrs);
	    },
	    canBeOpenedWithViewer() {
	      var _BX$UI;
	      return this.file.viewerAttrs && ((_BX$UI = BX.UI) == null ? void 0 : _BX$UI.Viewer);
	    },
	    imageTitle() {
	      const size = im_v2_lib_utils.Utils.file.formatFileSize(this.file.size);
	      return this.loc('IM_ELEMENTS_MEDIA_IMAGE_TITLE', {
	        '#NAME#': this.file.name,
	        '#SIZE#': size
	      });
	    },
	    isLoaded() {
	      return this.file.progress === 100;
	    },
	    isForward() {
	      return main_core.Type.isStringFilled(this.messageItem.forward.id);
	    }
	  },
	  methods: {
	    download() {
	      var _this$file$urlDownloa;
	      if (this.file.progress !== 100 || this.canBeOpenedWithViewer) {
	        return;
	      }
	      const url = (_this$file$urlDownloa = this.file.urlDownload) != null ? _this$file$urlDownloa : this.file.urlShow;
	      window.open(url, '_blank');
	    },
	    loc(phraseCode, replacements = {}) {
	      return this.$Bitrix.Loc.getMessage(phraseCode, replacements);
	    }
	  },
	  template: `
		<div 
			v-bind="viewerAttributes" 
			class="bx-im-media-image__container" 
			:class="{'--with-forward': isForward}"
			@click="download"
			:style="imageSize"
		>
			<img
				v-lazyload
				data-lazyload-dont-hide
				:data-lazyload-src="file.urlShow"
				:title="imageTitle"
				:alt="file.name"
				class="bx-im-media-image__source"
			/>
			<ProgressBar v-if="!isLoaded" :item="file" :messageId="messageItem.id" />
		</div>
	`
	};

	// @vue/component
	const ImageMessage = {
	  name: 'ImageMessage',
	  components: {
	    ReactionList: im_v2_component_message_elements.ReactionList,
	    BaseMessage: im_v2_component_message_base.BaseMessage,
	    MessageStatus: im_v2_component_message_elements.MessageStatus,
	    DefaultMessageContent: im_v2_component_message_elements.DefaultMessageContent,
	    ImageItem,
	    MessageHeader: im_v2_component_message_elements.MessageHeader,
	    MessageFooter: im_v2_component_message_elements.MessageFooter
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    dialogId: {
	      type: String,
	      required: true
	    },
	    withTitle: {
	      type: Boolean,
	      default: true
	    },
	    menuIsActiveForId: {
	      type: [String, Number],
	      default: 0
	    }
	  },
	  computed: {
	    FileType: () => im_v2_const.FileType,
	    message() {
	      return this.item;
	    },
	    dialog() {
	      return this.$store.getters['chats/get'](this.dialogId);
	    },
	    onlyImage() {
	      return this.message.text.length === 0 && this.message.attach.length === 0;
	    },
	    hasText() {
	      return this.message.text.length > 0;
	    },
	    hasAttach() {
	      return this.message.attach.length > 0;
	    },
	    isChannelPost() {
	      return [im_v2_const.ChatType.channel, im_v2_const.ChatType.openChannel].includes(this.dialog.type);
	    },
	    showContextMenu() {
	      return this.onlyImage;
	    },
	    showBottomContainer() {
	      return this.hasText || this.hasAttach || this.isChannelPost;
	    },
	    messageFile() {
	      const firstFileId = this.message.files[0];
	      return this.$store.getters['files/get'](firstFileId, true);
	    },
	    canSetReactions() {
	      return main_core.Type.isNumber(this.message.id);
	    }
	  },
	  template: `
		<BaseMessage :item="item" :dialogId="dialogId">
			<div class="bx-im-message-image__container">
				<MessageHeader :withTitle="false" :item="item" class="bx-im-message-image__header" />
				<div class="bx-im-message-image__content">
					<ImageItem
						:key="messageFile.id"
						:item="messageFile"
						:message="message"
					/>
					<div v-if="onlyImage" class="bx-im-message-image__message-status-container">
						<MessageStatus :item="message" :isOverlay="onlyImage" />
					</div>
				</div>
				<div v-if="showBottomContainer" class="bx-im-message-image__bottom-container">
					<DefaultMessageContent
						v-if="hasText || hasAttach"
						:item="item"
						:dialogId="dialogId"
						:withText="hasText"
						:withAttach="hasAttach"
					/>
					<MessageFooter :item="item" :dialogId="dialogId" />
				</div>
			</div>
			<template #after-message>
				<div v-if="onlyImage" class="bx-im-message-image__reaction-list-container">
					<ReactionList :messageId="message.id" />
				</div>
			</template>
		</BaseMessage>
	`
	};

	var _getMessageFile = /*#__PURE__*/babelHelpers.classPrivateFieldLooseKey("getMessageFile");
	class BaseFileContextMenu extends im_v2_lib_menu.BaseMenu {
	  constructor() {
	    super();
	    Object.defineProperty(this, _getMessageFile, {
	      value: _getMessageFile2
	    });
	    this.id = im_v2_const.PopupType.messageBaseFileMenu;
	    this.id = 'bx-im-message-file-context-menu';
	    this.diskService = new im_v2_provider_service.DiskService();
	  }
	  getMenuItems() {
	    return [this.getDownloadFileItem(), this.getSaveToDisk()];
	  }
	  getDownloadFileItem() {
	    const file = babelHelpers.classPrivateFieldLooseBase(this, _getMessageFile)[_getMessageFile]();
	    if (!file) {
	      return null;
	    }
	    return {
	      html: im_v2_lib_utils.Utils.file.createDownloadLink(main_core.Loc.getMessage('IM_MESSAGE_FILE_MENU_DOWNLOAD_FILE'), file.urlDownload, file.name),
	      onclick: function () {
	        this.menuInstance.close();
	      }.bind(this)
	    };
	  }
	  getSaveToDisk() {
	    const file = babelHelpers.classPrivateFieldLooseBase(this, _getMessageFile)[_getMessageFile]();
	    if (!file) {
	      return null;
	    }
	    return {
	      text: main_core.Loc.getMessage('IM_MESSAGE_FILE_MENU_SAVE_ON_DISK'),
	      onclick: function () {
	        void this.diskService.save(file.id).then(() => {
	          BX.UI.Notification.Center.notify({
	            content: main_core.Loc.getMessage('IM_MESSAGE_FILE_MENU_SAVE_ON_DISK_SUCCESS')
	          });
	        });
	        this.menuInstance.close();
	      }.bind(this)
	    };
	  }
	}
	function _getMessageFile2() {
	  if (this.context.files.length === 0) {
	    return null;
	  }

	  // for now, we have only one file in one message. In the future we need to change this logic.
	  return this.store.getters['files/get'](this.context.files[0]);
	}

	// @vue/component
	const BaseFileItem = {
	  name: 'BaseFileItem',
	  components: {
	    ProgressBar
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    messageId: {
	      type: [String, Number],
	      required: true
	    }
	  },
	  computed: {
	    file() {
	      return this.item;
	    },
	    fileShortName() {
	      const NAME_MAX_LENGTH = 40;
	      return im_v2_lib_utils.Utils.file.getShortFileName(this.file.name, NAME_MAX_LENGTH);
	    },
	    fileSize() {
	      return im_v2_lib_utils.Utils.file.formatFileSize(this.file.size);
	    },
	    iconClass() {
	      const iconType = im_v2_lib_utils.Utils.file.getIconTypeByFilename(this.file.name);
	      return `ui-icon-file-${iconType}`;
	    },
	    canBeOpenedWithViewer() {
	      var _BX$UI;
	      return this.file.viewerAttrs && ((_BX$UI = BX.UI) == null ? void 0 : _BX$UI.Viewer);
	    },
	    viewerAttributes() {
	      return im_v2_lib_utils.Utils.file.getViewerDataAttributes(this.file.viewerAttrs);
	    },
	    isLoaded() {
	      return this.file.progress === 100;
	    }
	  },
	  created() {
	    this.contextMenu = new BaseFileContextMenu();
	  },
	  beforeUnmount() {
	    this.contextMenu.destroy();
	  },
	  methods: {
	    download() {
	      var _this$file$urlDownloa;
	      if (this.file.progress !== 100 || this.canBeOpenedWithViewer) {
	        return;
	      }
	      const url = (_this$file$urlDownloa = this.file.urlDownload) != null ? _this$file$urlDownloa : this.file.urlShow;
	      window.open(url, '_blank');
	    },
	    loc(phraseCode, replacements = {}) {
	      return this.$Bitrix.Loc.getMessage(phraseCode, replacements);
	    },
	    openContextMenu(event) {
	      this.$emit('openContextMenu', event);
	    }
	  },
	  template: `
		<div class="bx-im-base-file-item__container bx-im-base-file-item__scope">
			<div class="bx-im-base-file-item__icon-container" ref="loader-icon" v-bind="viewerAttributes" @click="download">
				<div v-if="isLoaded" :class="iconClass" class="bx-im-base-file-item__type-icon ui-icon"><i></i></div>
				<ProgressBar v-else :item="file" :messageId="messageId" />
			</div>
			<div class="bx-im-base-file-item__content" v-bind="viewerAttributes" @click="download">
				<span :title="file.name" class="bx-im-base-file-item__title">
					{{ fileShortName }}
				</span>
				<div class="bx-im-base-file-item__size">{{ fileSize }}</div>
			</div>
			<div 
				class="bx-im-base-file-item__download-icon"
				:class="{'--not-active': !isLoaded}"
				@click="openContextMenu"
			></div>
		</div>
	`
	};

	// @vue/component
	const BaseFileMessage = {
	  name: 'BaseFileMessage',
	  components: {
	    BaseMessage: im_v2_component_message_base.BaseMessage,
	    DefaultMessageContent: im_v2_component_message_elements.DefaultMessageContent,
	    BaseFileItem,
	    MessageHeader: im_v2_component_message_elements.MessageHeader,
	    MessageFooter: im_v2_component_message_elements.MessageFooter
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    dialogId: {
	      type: String,
	      required: true
	    },
	    withTitle: {
	      type: Boolean,
	      default: true
	    }
	  },
	  computed: {
	    FileType: () => im_v2_const.FileType,
	    message() {
	      return this.item;
	    },
	    messageFile() {
	      const firstFileId = this.message.files[0];
	      return this.$store.getters['files/get'](firstFileId, true);
	    },
	    canSetReactions() {
	      return main_core.Type.isNumber(this.message.id);
	    }
	  },
	  created() {
	    this.contextMenu = new BaseFileContextMenu();
	  },
	  beforeUnmount() {
	    this.contextMenu.destroy();
	  },
	  methods: {
	    onOpenContextMenu(event) {
	      const context = {
	        dialogId: this.dialogId,
	        ...this.message
	      };
	      this.contextMenu.openMenu(context, event.target);
	    }
	  },
	  template: `
		<BaseMessage :item="item" :dialogId="dialogId">
			<div class="bx-im-message-base-file__container">
				<MessageHeader :withTitle="withTitle" :item="item" class="bx-im-message-base-file__author-title" />
				<BaseFileItem
					:key="messageFile.id"
					:item="messageFile"
					:messageId="message.id"
					@openContextMenu="onOpenContextMenu"
				/>
				<DefaultMessageContent :item="item" :dialogId="dialogId" />
				<MessageFooter :item="item" :dialogId="dialogId" />
			</div>
		</BaseMessage>
	`
	};

	const VIDEO_SIZE_TO_AUTOPLAY = 5000000;
	const MAX_WIDTH$1 = 420;
	const MAX_HEIGHT$1 = 340;
	const MIN_WIDTH$1 = 200;
	const MIN_HEIGHT$1 = 100;
	const DEFAULT_WIDTH = 320;
	const DEFAULT_HEIGHT = 180;

	// @vue/component
	const VideoItem = {
	  name: 'VideoItem',
	  components: {
	    SocialVideo: ui_vue3_components_socialvideo.SocialVideo,
	    ProgressBar
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    message: {
	      type: Object,
	      required: true
	    }
	  },
	  computed: {
	    messageItem() {
	      return this.message;
	    },
	    file() {
	      return this.item;
	    },
	    autoplay() {
	      return this.file.size < VIDEO_SIZE_TO_AUTOPLAY;
	    },
	    canBeOpenedWithViewer() {
	      var _BX$UI;
	      return this.file.viewerAttrs && ((_BX$UI = BX.UI) == null ? void 0 : _BX$UI.Viewer);
	    },
	    viewerAttributes() {
	      return im_v2_lib_utils.Utils.file.getViewerDataAttributes(this.file.viewerAttrs);
	    },
	    imageSize() {
	      let newWidth = this.file.image.width;
	      let newHeight = this.file.image.height;
	      if (!newHeight || !newWidth) {
	        return {
	          width: `${DEFAULT_WIDTH}px`,
	          height: `${DEFAULT_HEIGHT}px`
	        };
	      }
	      if (this.file.image.width > MAX_WIDTH$1 || this.file.image.height > MAX_HEIGHT$1) {
	        const aspectRatio = this.file.image.width / this.file.image.height;
	        if (this.file.image.width > MAX_WIDTH$1) {
	          newWidth = MAX_WIDTH$1;
	          newHeight = Math.round(MAX_WIDTH$1 / aspectRatio);
	        }
	        if (newHeight > MAX_HEIGHT$1) {
	          newWidth = Math.round(MAX_HEIGHT$1 * aspectRatio);
	          newHeight = MAX_HEIGHT$1;
	        }
	      }
	      const sizes = {
	        width: Math.max(newWidth, MIN_WIDTH$1),
	        height: Math.max(newHeight, MIN_HEIGHT$1)
	      };
	      return {
	        width: `${sizes.width}px`,
	        height: `${sizes.height}px`,
	        'object-fit': sizes.width < 100 || sizes.height < 100 ? 'cover' : 'contain'
	      };
	    },
	    isLoaded() {
	      return this.file.progress === 100;
	    },
	    isForward() {
	      return main_core.Type.isStringFilled(this.messageItem.forward.id);
	    }
	  },
	  methods: {
	    download() {
	      var _this$file$urlDownloa;
	      if (this.file.progress !== 100 || this.canBeOpenedWithViewer) {
	        return;
	      }
	      const url = (_this$file$urlDownloa = this.file.urlDownload) != null ? _this$file$urlDownloa : this.file.urlShow;
	      window.open(url, '_blank');
	    },
	    getPlayCallback() {
	      if (this.autoplay) {
	        return null;
	      }
	      return () => {};
	    }
	  },
	  template: `
		<div
			@click="download"
			class="bx-im-video-item__container bx-im-video-item__scope"
			:class="{'--with-forward': isForward}"
		>
			<ProgressBar v-if="!isLoaded" :item="file" :messageId="message.id" />
			<SocialVideo
				v-bind="viewerAttributes"
				:id="file.id"
				:src="file.urlShow"
				:preview="file.urlPreview"
				:elementStyle="imageSize"
				:autoplay="autoplay"
				:showControls="isLoaded"
				:playCallback="getPlayCallback()"
			/>
		</div>
	`
	};

	// @vue/component
	const VideoMessage = {
	  name: 'VideoMessage',
	  components: {
	    ReactionList: im_v2_component_message_elements.ReactionList,
	    BaseMessage: im_v2_component_message_base.BaseMessage,
	    MessageStatus: im_v2_component_message_elements.MessageStatus,
	    DefaultMessageContent: im_v2_component_message_elements.DefaultMessageContent,
	    VideoItem,
	    MessageHeader: im_v2_component_message_elements.MessageHeader,
	    MessageFooter: im_v2_component_message_elements.MessageFooter
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    dialogId: {
	      type: String,
	      required: true
	    },
	    menuIsActiveForId: {
	      type: [String, Number],
	      default: 0
	    }
	  },
	  computed: {
	    FileType: () => im_v2_const.FileType,
	    dialog() {
	      return this.$store.getters['chats/get'](this.dialogId);
	    },
	    message() {
	      return this.item;
	    },
	    onlyVideo() {
	      return this.message.text.length === 0 && this.message.attach.length === 0;
	    },
	    hasText() {
	      return this.message.text.length > 0;
	    },
	    hasAttach() {
	      return this.message.attach.length > 0;
	    },
	    isChannelPost() {
	      return [im_v2_const.ChatType.channel, im_v2_const.ChatType.openChannel].includes(this.dialog.type);
	    },
	    showBottomContainer() {
	      return this.hasText || this.hasAttach || this.isChannelPost;
	    },
	    messageFile() {
	      const firstFileId = this.message.files[0];
	      return this.$store.getters['files/get'](firstFileId, true);
	    },
	    canSetReactions() {
	      return main_core.Type.isNumber(this.message.id);
	    }
	  },
	  template: `
		<BaseMessage :item="item" :dialogId="dialogId">
			<div class="bx-im-message-video__container">
				<MessageHeader :withTitle="false" :item="item" class="bx-im-message-video__header" />
				<div class="bx-im-message-video__content">
					<VideoItem
						:key="messageFile.id"
						:item="messageFile"
						:message="message"
					/>
					<div v-if="onlyVideo" class="bx-im-message-video__message-status-container">
						<MessageStatus :item="message" :isOverlay="onlyVideo" />
					</div>
				</div>
				<div v-if="showBottomContainer" class="bx-im-message-video__bottom-container">
					<DefaultMessageContent
						v-if="hasText || hasAttach"
						:item="item"
						:dialogId="dialogId"
						:withText="hasText"
						:withAttach="hasAttach"
					/>
					<MessageFooter :item="item" :dialogId="dialogId" />
				</div>
			</div>
			<template #after-message>
				<div v-if="onlyVideo" class="bx-im-message-video__reaction-list-container">
					<ReactionList :messageId="message.id" />
				</div>
			</template>
		</BaseMessage>
	`
	};

	// @vue/component
	const AudioItem = {
	  name: 'AudioItem',
	  components: {
	    AudioPlayer: im_v2_component_elements.AudioPlayer,
	    ProgressBar
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    messageType: {
	      type: String,
	      required: true
	    },
	    messageId: {
	      type: [String, Number],
	      required: true
	    }
	  },
	  computed: {
	    file() {
	      return this.item;
	    },
	    playerBackgroundType() {
	      return this.messageType === im_v2_const.MessageType.self ? 'dark' : 'light';
	    },
	    isLoaded() {
	      return this.file.progress === 100;
	    }
	  },
	  template: `
		<div class="bx-im-media-audio__container">
			<ProgressBar v-if="!isLoaded" :item="file" :messageId="messageId" />
			<AudioPlayer
				:id="file.id"
				:src="file.urlShow"
				:file="file"
				:timelineType="Math.floor(Math.random() * 5)"
				:authorId="file.authorId"
				:withContextMenu="false"
				:withAvatar="false"
			/>
		</div>
	`
	};

	// @vue/component
	const AudioMessage = {
	  name: 'AudioMessage',
	  components: {
	    BaseMessage: im_v2_component_message_base.BaseMessage,
	    MessageHeader: im_v2_component_message_elements.MessageHeader,
	    MessageFooter: im_v2_component_message_elements.MessageFooter,
	    DefaultMessageContent: im_v2_component_message_elements.DefaultMessageContent,
	    AudioItem
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    dialogId: {
	      type: String,
	      required: true
	    },
	    withTitle: {
	      type: Boolean,
	      default: false
	    }
	  },
	  computed: {
	    FileType: () => im_v2_const.FileType,
	    message() {
	      return this.item;
	    },
	    messageFile() {
	      const firstFileId = this.message.files[0];
	      return this.$store.getters['files/get'](firstFileId, true);
	    },
	    canSetReactions() {
	      return main_core.Type.isNumber(this.message.id);
	    },
	    messageType() {
	      return this.$store.getters['messages/getMessageType'](this.message.id);
	    }
	  },
	  template: `
		<BaseMessage :item="item" :dialogId="dialogId">
			<div class="bx-im-message-audio__container">
				<MessageHeader :withTitle="withTitle" :item="item" class="bx-im-message-audio__header"/>
				<AudioItem
					:key="messageFile.id"
					:item="messageFile"
					:messageId="message.id"
					:messageType="messageType"
				/>
			</div>
			<div class="bx-im-message-audio__default-message-container">
				<DefaultMessageContent :item="item" :dialogId="dialogId" />
				<MessageFooter :item="item" :dialogId="dialogId" />
			</div>
		</BaseMessage>
	`
	};

	const FileMessageType = Object.freeze({
	  image: 'ImageMessage',
	  audio: 'AudioMessage',
	  video: 'VideoMessage',
	  base: 'BaseFileMessage',
	  collection: 'CollectionFileMessage'
	});

	// @vue/component
	const FileMessage = {
	  name: 'FileMessage',
	  components: {
	    BaseFileMessage,
	    ImageMessage,
	    VideoMessage,
	    AudioMessage,
	    UnsupportedMessage: im_v2_component_message_unsupported.UnsupportedMessage
	  },
	  props: {
	    item: {
	      type: Object,
	      required: true
	    },
	    dialogId: {
	      type: String,
	      required: true
	    },
	    withTitle: {
	      type: Boolean,
	      default: true
	    },
	    menuIsActiveForId: {
	      type: [String, Number],
	      default: 0
	    }
	  },
	  computed: {
	    FileType: () => im_v2_const.FileType,
	    message() {
	      return this.item;
	    },
	    messageFiles() {
	      const files = [];
	      if (this.message.files.length === 0) {
	        return files;
	      }
	      this.message.files.forEach(fileId => {
	        const file = this.$store.getters['files/get'](fileId, true);
	        files.push(file);
	      });
	      return files;
	    },
	    componentName() {
	      const file = this.messageFiles[0];
	      const hasPreview = Boolean(file.image);
	      if (file.type === im_v2_const.FileType.image && hasPreview) {
	        return FileMessageType.image;
	      }
	      if (file.type === im_v2_const.FileType.audio) {
	        return FileMessageType.audio;
	      }

	      // file.type value is empty for mkv files
	      const isVideo = file.type === im_v2_const.FileType.video || im_v2_lib_utils.Utils.file.getFileExtension(file.name) === 'mkv';
	      if (isVideo && hasPreview) {
	        return FileMessageType.video;
	      }
	      return FileMessageType.base;
	    }
	  },
	  template: `
		<component 
			:is="componentName" 
			:item="message" 
			:dialogId="dialogId" 
			:withTitle="withTitle" 
			:menuIsActiveForId="menuIsActiveForId"
			:withRetryButton="false"
		/>
	`
	};

	exports.FileMessage = FileMessage;

}((this.BX.Messenger.v2.Component.Message = this.BX.Messenger.v2.Component.Message || {}),BX.Messenger.v2.Component.Message,BX.Vue3.Directives,BX.Event,BX.Messenger.v2.Lib,BX.Messenger.v2.Provider.Service,BX.Messenger.v2.Lib,BX,BX.Messenger.v2.Model,BX.Vue3.Components,BX.Messenger.v2.Lib,BX,BX.Messenger.v2.Component.Message,BX.Messenger.v2.Component.Message,BX.Messenger.v2.Component.Elements,BX.Messenger.v2.Const));
//# sourceMappingURL=file-message.bundle.js.map
