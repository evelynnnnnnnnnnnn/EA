this.BX = this.BX || {};
this.BX.Crm = this.BX.Crm || {};
(function (exports,ui_notification,main_popup,main_core_events,pull_queuemanager,crm_kanban_sort,main_core) {
	'use strict';

	var _templateObject, _templateObject2, _templateObject3, _templateObject4, _templateObject5, _templateObject6, _templateObject7, _templateObject8, _templateObject9, _templateObject10;
	var TYPE_VIEW = 'view';
	var TYPE_EDIT = 'edit';
	var FieldsSelector = /*#__PURE__*/function () {
	  function FieldsSelector(options) {
	    var _this$options$headers, _this$options$default;
	    babelHelpers.classCallCheck(this, FieldsSelector);
	    this.popup = null;
	    this.fields = null;
	    this.fieldsPopupItems = null;
	    this.options = options;
	    this.type = this.options.hasOwnProperty('type') ? this.options.type : TYPE_VIEW;
	    this.selectedFields = this.options.hasOwnProperty('selectedFields') ? this.options.selectedFields.slice(0) : [];
	    this.enableHeadersSections = Boolean(this.options.headersSections);
	    this.headersSections = (_this$options$headers = this.options.headersSections) !== null && _this$options$headers !== void 0 ? _this$options$headers : {};
	    this.defaultHeaderSectionId = (_this$options$default = this.options.defaultHeaderSectionId) !== null && _this$options$default !== void 0 ? _this$options$default : null;
	    this.fieldVisibleClass = 'crm-kanban-popup-field-search-list-item-visible';
	    this.fieldHiddenClass = 'crm-kanban-popup-field-search-list-item-hidden';
	  }
	  babelHelpers.createClass(FieldsSelector, [{
	    key: "show",
	    value: function show() {
	      if (!this.popup) {
	        this.popup = this.createPopup();
	      }
	      if (this.fields) {
	        this.popup.setContent(this.getFieldsLayout());
	      } else {
	        this.loadPopupContent(this.popup);
	      }
	      this.popup.show();
	    }
	  }, {
	    key: "createPopup",
	    value: function createPopup() {
	      var _this = this;
	      return main_popup.PopupManager.create({
	        id: 'kanban_custom_fields_' + this.type,
	        className: 'crm-kanban-popup-field',
	        titleBar: main_core.Loc.getMessage('CRM_KANBAN_CUSTOM_FIELDS_' + this.type.toUpperCase()),
	        cacheable: false,
	        closeIcon: true,
	        lightShadow: true,
	        overlay: true,
	        draggable: true,
	        closeByEsc: true,
	        contentColor: 'white',
	        maxHeight: window.innerHeight - 50,
	        events: {
	          onClose: function onClose() {
	            _this.fieldsPopupItems = null;
	            _this.popup = null;
	          }
	        },
	        buttons: [new BX.UI.SaveButton({
	          color: BX.UI.Button.Color.PRIMARY,
	          state: this.fields ? '' : BX.UI.Button.State.DISABLED,
	          onclick: function onclick() {
	            var selectedFields = _this.fields ? _this.fields.filter(function (field) {
	              return _this.selectedFields.indexOf(field.NAME) >= 0;
	            }) : [];
	            if (selectedFields.length) {
	              _this.popup.close();
	              _this.executeCallback(selectedFields);
	            } else {
	              ui_notification.UI.Notification.Center.notify({
	                content: main_core.Loc.getMessage('CRM_KANBAN_POPUP_AT_LEAST_ONE_FIELD'),
	                autoHide: true,
	                autoHideDelay: 2000
	              });
	            }
	          }
	        }), new BX.UI.CancelButton({
	          onclick: function onclick() {
	            _this.popup.close();
	          }
	        })]
	      });
	    }
	  }, {
	    key: "loadPopupContent",
	    value: function loadPopupContent(popup) {
	      var _this2 = this;
	      var loaderContainer = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["<div class=\"crm-kanban-popup-field-loader\"></div>"])));
	      var loader = new BX.Loader({
	        target: loaderContainer,
	        size: 80
	      });
	      loader.show();
	      popup.setContent(loaderContainer);
	      BX.ajax.runComponentAction('bitrix:crm.kanban', 'getFields', {
	        mode: 'ajax',
	        data: {
	          entityType: this.options.entityTypeName,
	          viewType: this.type
	        }
	      }).then(function (response) {
	        loader.destroy();
	        _this2.fields = response.data;
	        popup.setContent(_this2.getFieldsLayout());
	        popup.getButtons().forEach(function (button) {
	          return button.setDisabled(false);
	        });
	        popup.adjustPosition();
	      })["catch"](function (response) {
	        BX.Kanban.Utils.showErrorDialog(response.errors.pop().message);
	      });
	      return popup;
	    }
	  }, {
	    key: "getFieldsLayout",
	    value: function getFieldsLayout() {
	      var _this3 = this;
	      var sectionsWithFields = this.distributeFieldsBySections(this.fields);
	      var container = main_core.Tag.render(_templateObject2 || (_templateObject2 = babelHelpers.taggedTemplateLiteral(["<div class=\"crm-kanban-popup-field\"></div>"])));
	      var headerWrapper = main_core.Tag.render(_templateObject3 || (_templateObject3 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t<div class=\"crm-kanban-popup-field-search-header-wrapper\">\n\t\t\t\t<div class=\"ui-form-row-inline\"></div>\n\t\t\t</div>\n\t\t"])));
	      container.prepend(headerWrapper);
	      this.preparePopupContentHeaderSections(headerWrapper);
	      this.preparePopupContentHeaderSearch(headerWrapper);
	      this.getSections().map(function (section) {
	        var sectionWrapperId = _this3.getSectionWrapperNameBySectionName(section.name);
	        var sectionWrapper = main_core.Tag.render(_templateObject4 || (_templateObject4 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div \n\t\t\t\t\tclass=\"crm-kanban-popup-field-search-section\" \n\t\t\t\t\tdata-crm-kanban-popup-field-search-section=\"", "\">\n\t\t\t\t</div>\n\t\t\t"])), sectionWrapperId);
	        main_core.Dom.append(sectionWrapper, container);
	        var sectionName = section.name;
	        if (sectionsWithFields.hasOwnProperty(sectionName) && sectionsWithFields[sectionName].length) {
	          main_core.Dom.append(main_core.Tag.render(_templateObject5 || (_templateObject5 = babelHelpers.taggedTemplateLiteral(["<div class=\"crm-kanban-popup-field-title\">", "</div>"])), main_core.Text.encode(section.title)), sectionWrapper);
	          main_core.Dom.append(main_core.Tag.render(_templateObject6 || (_templateObject6 = babelHelpers.taggedTemplateLiteral(["<div class=\"crm-kanban-popup-field-wrapper\">\n\t\t\t\t\t\t", "\n\t\t\t\t\t</div>"])), sectionsWithFields[sectionName].map(function (field) {
	            var label = field.LABEL;
	            if (!label.length && section['elements'] && section['elements'][field.NAME] && section['elements'][field.NAME]['title'] && section['elements'][field.NAME]['title'].length) {
	              label = section['elements'][field.NAME]['title'];
	            }
	            var encodedLabel = main_core.Text.encode(label);
	            return main_core.Tag.render(_templateObject7 || (_templateObject7 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t\t\t\t\t<div class=\"crm-kanban-popup-field-item\" title=\"", "\">\n\t\t\t\t\t\t\t\t\t<input \n\t\t\t\t\t\t\t\t\t\tid=\"cf_", "\" \n\t\t\t\t\t\t\t\t\t\ttype=\"checkbox\" \n\t\t\t\t\t\t\t\t\t\tname=\"", "\"\n\t\t\t\t\t\t\t\t\t\tclass=\"crm-kanban-popup-field-item-input\"\n\t\t\t\t\t\t\t\t\t\tdata-label=\"", "\"\n\t\t\t\t\t\t\t\t\t\t", "\n\t\t\t\t\t\t\t\t\t\tonclick=\"", "\"\n\t\t\t\t\t\t\t\t\t/>\n\t\t\t\t\t\t\t\t\t<label for=\"cf_", "\" class=\"crm-kanban-popup-field-item-label\">\n\t\t\t\t\t\t\t\t\t\t", "\n\t\t\t\t\t\t\t\t\t</label>\n\t\t\t\t\t\t\t\t</div>"])), encodedLabel, main_core.Text.encode(field.ID), main_core.Text.encode(field.NAME), encodedLabel, _this3.selectedFields.indexOf(field.NAME) >= 0 ? 'checked' : '', _this3.onFieldClick.bind(_this3), main_core.Text.encode(field.ID), encodedLabel);
	          })), sectionWrapper);
	        }
	      });
	      return container;
	    }
	  }, {
	    key: "preparePopupContentHeaderSections",
	    value: function preparePopupContentHeaderSections(headerWrapper) {
	      if (!this.enableHeadersSections) {
	        return;
	      }
	      var headerSectionsWrapper = main_core.Tag.render(_templateObject8 || (_templateObject8 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t<div class=\"ui-form-row\">\n\t\t\t\t<div class=\"ui-form-content crm-kanban-popup-field-search-section-wrapper\"></div>\n\t\t\t</div>\n\t\t"])));
	      headerWrapper.firstElementChild.appendChild(headerSectionsWrapper);
	      var headersSections = this.getHeadersSections();
	      for (var key in headersSections) {
	        var itemClass = 'crm-kanban-popup-field-search-section-item-icon' + (headersSections[key].selected ? " crm-kanban-popup-field-search-section-item-icon-active" : '');
	        var headerSectionItem = main_core.Tag.render(_templateObject9 || (_templateObject9 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"crm-kanban-popup-field-search-section-item\" data-kanban-popup-filter-section-button=\"", "\">\n\t\t\t\t\t<div class=\"", "\">\n\t\t\t\t\t\t", "\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t"])), key, itemClass, main_core.Text.encode(headersSections[key].name));
	        headerSectionsWrapper.firstElementChild.appendChild(headerSectionItem);
	        if (this.type !== TYPE_VIEW) {
	          break;
	        }
	        main_core.Event.bind(headerSectionItem, 'click', this.onFilterSectionClick.bind(this, headerSectionItem));
	      }
	    }
	  }, {
	    key: "onFilterSectionClick",
	    value: function onFilterSectionClick(item) {
	      var activeClass = 'crm-kanban-popup-field-search-section-item-icon-active';
	      var sectionId = item.dataset.kanbanPopupFilterSectionButton;
	      var sections = document.querySelectorAll("[data-crm-kanban-popup-field-search-section=\"".concat(sectionId, "\"]"));
	      if (main_core.Dom.hasClass(item.firstElementChild, activeClass)) {
	        main_core.Dom.removeClass(item.firstElementChild, activeClass);
	        this.filterSectionsToggle(sections, 'hide');
	      } else {
	        main_core.Dom.addClass(item.firstElementChild, activeClass);
	        this.filterSectionsToggle(sections, 'show');
	      }
	    }
	  }, {
	    key: "filterSectionsToggle",
	    value: function filterSectionsToggle(sections, action) {
	      Array.from(sections).map(function (section) {
	        action === 'show' ? main_core.Dom.show(section) : main_core.Dom.hide(section);
	      });
	    }
	  }, {
	    key: "preparePopupContentHeaderSearch",
	    value: function preparePopupContentHeaderSearch(headerWrapper) {
	      var searchForm = main_core.Tag.render(_templateObject10 || (_templateObject10 = babelHelpers.taggedTemplateLiteral(["\n\t\t\t<div class=\"ui-form-row\">\n\t\t\t\t<div class=\"ui-form-content crm-kanban-popup-field-search-input-wrapper\">\n\t\t\t\t\t<div class=\"ui-ctl ui-ctl-textbox ui-ctl-before-icon ui-ctl-after-icon\">\n\t\t\t\t\t\t<div class=\"ui-ctl-before ui-ctl-icon-search\"></div>\n\t\t\t\t\t\t<button class=\"ui-ctl-after ui-ctl-icon-clear\"></button>\n\t\t\t\t\t\t<input type=\"text\" class=\"ui-ctl-element crm-kanban-popup-field-search-section-input\">\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t"])));
	      headerWrapper.firstElementChild.appendChild(searchForm);
	      var inputs = searchForm.getElementsByClassName('crm-kanban-popup-field-search-section-input');
	      if (inputs.length) {
	        var input = inputs[0];
	        main_core.Event.bind(input, 'input', this.onFilterSectionSearchInput.bind(this, input));
	        main_core.Event.bind(input.previousElementSibling, 'click', this.onFilterSectionSearchInputClear.bind(this, input));
	      }
	    }
	  }, {
	    key: "onFilterSectionSearchInput",
	    value: function onFilterSectionSearchInput(input) {
	      var _this4 = this;
	      var search = input.value;
	      if (search.length) {
	        search = search.toLowerCase();
	      }
	      this.getFieldsPopupItems().map(function (item) {
	        var title = item.innerText.toLowerCase();
	        if (search.length && title.indexOf(search) === -1) {
	          main_core.Dom.removeClass(item, _this4.fieldVisibleClass);
	          main_core.Dom.addClass(item, _this4.fieldHiddenClass);
	        } else {
	          main_core.Dom.removeClass(item, _this4.fieldHiddenClass);
	          main_core.Dom.addClass(item, _this4.fieldVisibleClass);
	          item.style.display = 'block';
	        }
	      });
	    }
	  }, {
	    key: "getFieldsPopupItems",
	    value: function getFieldsPopupItems() {
	      if (!main_core.Type.isArray(this.fieldsPopupItems)) {
	        this.fieldsPopupItems = Array.from(this.popup.getPopupContainer().querySelectorAll('.crm-kanban-popup-field-item'));
	        this.prepareAnimation();
	      }
	      return this.fieldsPopupItems;
	    }
	  }, {
	    key: "prepareAnimation",
	    value: function prepareAnimation() {
	      var _this5 = this;
	      this.fieldsPopupItems.map(function (item) {
	        main_core.Event.bind(item, 'animationend', _this5.onAnimationEnd.bind(_this5, item));
	      });
	    }
	  }, {
	    key: "onAnimationEnd",
	    value: function onAnimationEnd(item) {
	      item.style.display = main_core.Dom.hasClass(item, this.fieldHiddenClass) ? 'none' : 'block';
	    }
	  }, {
	    key: "onFilterSectionSearchInputClear",
	    value: function onFilterSectionSearchInputClear(input) {
	      if (input.value.length) {
	        input.value = '';
	        this.onFilterSectionSearchInput(input);
	      }
	    }
	  }, {
	    key: "getSectionWrapperNameBySectionName",
	    value: function getSectionWrapperNameBySectionName(name) {
	      var headerSections = this.getHeadersSections();
	      for (var id in headerSections) {
	        if (this.headersSections[id].sections && this.headersSections[id].sections.includes(name)) {
	          return this.headersSections[id].id;
	        }
	      }
	      return this.headersSections[this.defaultHeaderSectionId] && this.defaultHeaderSectionId ? this.headersSections[this.defaultHeaderSectionId].id : null;
	    }
	  }, {
	    key: "getHeadersSections",
	    value: function getHeadersSections() {
	      var _this$headersSections;
	      return (_this$headersSections = this.headersSections) !== null && _this$headersSections !== void 0 ? _this$headersSections : {};
	    }
	  }, {
	    key: "distributeFieldsBySections",
	    value: function distributeFieldsBySections(fields) {
	      // remove ignored fields from result:
	      var ignoredFields = this.getIgnoredFields();
	      fields = fields.filter(function (item) {
	        return !(ignoredFields.hasOwnProperty(item.NAME) && ignoredFields[item.NAME]);
	      });
	      var fieldsBySections = {};
	      var defaultSectionName = '';
	      var sections = this.options.hasOwnProperty('sections') ? this.options.sections : [];
	      for (var i = 0; i < sections.length; i++) {
	        var section = sections[i];
	        var sectionName = section.name;
	        fieldsBySections[sectionName] = [];
	        if (main_core.Type.isPlainObject(section.elements)) {
	          fieldsBySections[sectionName] = this.filterFieldsByList(fields, section.elements);
	        } else if (section.hasOwnProperty('elementsRule')) {
	          fieldsBySections[sectionName] = this.filterFieldsByRule(fields, new RegExp(section.elementsRule));
	        } else if (section.elements === '*') {
	          defaultSectionName = sectionName;
	        }
	      }
	      if (defaultSectionName !== '') {
	        fieldsBySections[defaultSectionName] = this.filterNotUsedFields(fields, fieldsBySections);
	      }
	      return fieldsBySections;
	    }
	  }, {
	    key: "filterFieldsByList",
	    value: function filterFieldsByList(fields, whiteList) {
	      return fields.filter(function (item) {
	        return whiteList.hasOwnProperty(item.NAME);
	      });
	    }
	  }, {
	    key: "filterFieldsByRule",
	    value: function filterFieldsByRule(fields, rule) {
	      return fields.filter(function (item) {
	        return item.NAME.match(rule);
	      });
	    }
	  }, {
	    key: "filterNotUsedFields",
	    value: function filterNotUsedFields(fields, alreadyUsedFieldsBySection) {
	      var alreadyUsedFieldsNames = Object.values(alreadyUsedFieldsBySection).reduce(function (prevFields, sectionFields) {
	        return prevFields.concat(sectionFields.map(function (item) {
	          return item.NAME;
	        }));
	      }, []);
	      return fields.filter(function (item) {
	        return alreadyUsedFieldsNames.indexOf(item.NAME) < 0;
	      });
	    }
	  }, {
	    key: "getSections",
	    value: function getSections() {
	      return this.options.hasOwnProperty('sections') ? this.options.sections : [];
	    }
	  }, {
	    key: "getIgnoredFields",
	    value: function getIgnoredFields() {
	      var fields = Object.assign({}, this.options.ignoredFields);
	      var extraFields = [];
	      if (this.type === TYPE_EDIT) {
	        extraFields = ['ID', 'CLOSED', 'DATE_CREATE', 'DATE_MODIFY', 'COMMENTS', 'OPPORTUNITY'];
	      } else {
	        extraFields = ['PHONE', 'EMAIL', 'WEB', 'IM'];
	      }
	      extraFields.forEach(function (fieldName) {
	        return fields[fieldName] = true;
	      });
	      return fields;
	    }
	  }, {
	    key: "executeCallback",
	    value: function executeCallback(selectedFields) {
	      if (!this.options.hasOwnProperty('onSelect') || !main_core.Type.isFunction(this.options.onSelect)) {
	        return;
	      }
	      var callbackPayload = {};
	      selectedFields.forEach(function (field) {
	        callbackPayload[field.NAME] = field.LABEL ? field.LABEL : '';
	      });
	      this.options.onSelect(callbackPayload);
	    }
	  }, {
	    key: "onFieldClick",
	    value: function onFieldClick(event) {
	      var fieldName = event.target.name;
	      if (event.target.checked && this.selectedFields.indexOf(fieldName) < 0) {
	        this.selectedFields.push(fieldName);
	      }
	      if (!event.target.checked && this.selectedFields.indexOf(fieldName) >= 0) {
	        this.selectedFields.splice(this.selectedFields.indexOf(fieldName), 1);
	      }
	    }
	  }]);
	  return FieldsSelector;
	}();

	var PullOperation = /*#__PURE__*/function () {
	  babelHelpers.createClass(PullOperation, null, [{
	    key: "createInstance",
	    value: function createInstance(data) {
	      return new PullOperation(data.grid).setItemId(data.itemId).setAction(data.action).setActionParams(data.actionParams);
	    }
	  }]);
	  function PullOperation(grid) {
	    babelHelpers.classCallCheck(this, PullOperation);
	    this.grid = grid;
	  }
	  babelHelpers.createClass(PullOperation, [{
	    key: "setItemId",
	    value: function setItemId(itemId) {
	      this.itemId = itemId;
	      return this;
	    }
	  }, {
	    key: "getItemId",
	    value: function getItemId() {
	      return this.itemId;
	    }
	  }, {
	    key: "setAction",
	    value: function setAction(action) {
	      this.action = action;
	      return this;
	    }
	  }, {
	    key: "getAction",
	    value: function getAction() {
	      return this.action;
	    }
	  }, {
	    key: "setActionParams",
	    value: function setActionParams(actionParams) {
	      this.actionParams = actionParams;
	      return this;
	    }
	  }, {
	    key: "getActionParams",
	    value: function getActionParams() {
	      return this.actionParams;
	    }
	  }, {
	    key: "execute",
	    value: function execute() {
	      var action = this.getAction();
	      if (action === 'updateItem') {
	        this.updateItem();
	        return;
	      }
	      if (action === 'addItem') {
	        this.addItem();
	      }
	    }
	  }, {
	    key: "updateItem",
	    value: function updateItem() {
	      var params = this.getActionParams();
	      var item = this.grid.getItem(params.item.id);
	      var paramsItem = params.item;
	      if (!item) {
	        return;
	      }
	      var insertItemParams = {};
	      var _paramsItem$data = paramsItem.data,
	        lastActivity = _paramsItem$data.lastActivity,
	        newColumnId = _paramsItem$data.columnId,
	        price = _paramsItem$data.price;
	      if (main_core.Type.isObjectLike(lastActivity) && lastActivity.timestamp !== item.data.lastActivity.timestamp) {
	        insertItemParams.canShowLastActivitySortTour = true;
	      }
	      var oldPrice = parseFloat(item.data.price);
	      var oldColumnId = item.columnId;
	      for (var key in paramsItem.data) {
	        if (key in item.data) {
	          item.data[key] = paramsItem.data[key];
	        }
	      }
	      item.rawData = paramsItem.rawData;
	      item.setActivityExistInnerHtml();
	      item.useAnimation = true;
	      item.setChangedInPullRequest();
	      this.grid.resetMultiSelectMode();
	      var newColumn = this.grid.getColumn(newColumnId);
	      var newPrice = parseFloat(price);
	      insertItemParams.newColumnId = newColumnId;
	      this.grid.insertItem(item, insertItemParams);
	      item.columnId = newColumnId;
	      if (!this.grid.getTypeInfoParam('showTotalPrice')) {
	        return;
	      }
	      if (oldColumnId === newColumnId) {
	        if (oldPrice < newPrice) {
	          newColumn.incPrice(newPrice - oldPrice);
	          newColumn.renderSubTitle();
	        } else if (oldPrice > newPrice) {
	          newColumn.decPrice(oldPrice - newPrice);
	          newColumn.renderSubTitle();
	        }
	        return;
	      }
	      var oldColumn = this.grid.getColumn(oldColumnId);
	      oldColumn.decPrice(oldPrice);
	      oldColumn.renderSubTitle();
	      if (newColumn) {
	        newColumn.incPrice(newPrice);
	        newColumn.renderSubTitle();
	      }
	    }
	  }, {
	    key: "addItem",
	    value: function addItem() {
	      var params = this.getActionParams();
	      var oldItem = this.grid.getItem(params.item.id);
	      if (oldItem) {
	        return;
	      }
	      var column = this.grid.getColumn(params.item.data.columnId);
	      if (!column) {
	        return;
	      }
	      var sorter = crm_kanban_sort.Sorter.createWithCurrentSortType(column.getItems());
	      var beforeItem = sorter.calcBeforeItemByParams(params.item.data.sort);
	      if (beforeItem) {
	        params.item.targetId = beforeItem.getId();
	      }
	      this.grid.addItem(params.item);
	    }
	  }]);
	  return PullOperation;
	}();

	var ViewMode = {
	  MODE_STAGES: 'STAGES',
	  MODE_ACTIVITIES: 'ACTIVITIES',
	  getDefault: function getDefault() {
	    return this.MODE_STAGES;
	  },
	  getAll: function getAll() {
	    return [this.MODE_STAGES, this.MODE_ACTIVITIES];
	  },
	  normalize: function normalize(mode) {
	    return this.getAll().includes(mode) ? mode : this.getDefault();
	  }
	};
	Object.freeze(ViewMode);

	function _classPrivateMethodInitSpec(obj, privateSet) { _checkPrivateRedeclaration(obj, privateSet); privateSet.add(obj); }
	function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
	function _classPrivateMethodGet(receiver, privateSet, fn) { if (!privateSet.has(receiver)) { throw new TypeError("attempted to get private field on non-instance"); } return fn; }
	var EventName = {
	  itemUpdated: 'ITEMUPDATED',
	  itemAdded: 'ITEMADDED',
	  itemDeleted: 'ITEMDELETED',
	  stageAdded: 'STAGEADDED',
	  stageUpdated: 'STAGEUPDATED',
	  stageDeleted: 'STAGEDELETED'
	};
	var _onBeforeQueueExecute = /*#__PURE__*/new WeakSet();
	var _onQueueExecute = /*#__PURE__*/new WeakSet();
	var _onReload = /*#__PURE__*/new WeakSet();
	var _onBeforePull = /*#__PURE__*/new WeakSet();
	var _onPull = /*#__PURE__*/new WeakSet();
	var _onPullItemUpdated = /*#__PURE__*/new WeakSet();
	var _onPullItemAdded = /*#__PURE__*/new WeakSet();
	var _getPullData = /*#__PURE__*/new WeakSet();
	var _onPullItemDeleted = /*#__PURE__*/new WeakSet();
	var _onPullStageChanged = /*#__PURE__*/new WeakSet();
	var _onPullStageDeleted = /*#__PURE__*/new WeakSet();
	var PullManager = function PullManager(_grid) {
	  var _this = this;
	  babelHelpers.classCallCheck(this, PullManager);
	  _classPrivateMethodInitSpec(this, _onPullStageDeleted);
	  _classPrivateMethodInitSpec(this, _onPullStageChanged);
	  _classPrivateMethodInitSpec(this, _onPullItemDeleted);
	  _classPrivateMethodInitSpec(this, _getPullData);
	  _classPrivateMethodInitSpec(this, _onPullItemAdded);
	  _classPrivateMethodInitSpec(this, _onPullItemUpdated);
	  _classPrivateMethodInitSpec(this, _onPull);
	  _classPrivateMethodInitSpec(this, _onBeforePull);
	  _classPrivateMethodInitSpec(this, _onReload);
	  _classPrivateMethodInitSpec(this, _onQueueExecute);
	  _classPrivateMethodInitSpec(this, _onBeforeQueueExecute);
	  if (!BX.PULL) {
	    console.info('BX.PULL is not initialized');
	    return;
	  }
	  this.grid = _grid;
	  var _data = _grid.getData();
	  var _options = {
	    moduleId: _data.moduleId,
	    pullTag: _data.pullTag,
	    userId: _data.userId,
	    additionalData: {
	      viewMode: _data.viewMode
	    },
	    events: {
	      onBeforePull: function onBeforePull(event) {
	        _classPrivateMethodGet(_this, _onBeforePull, _onBeforePull2).call(_this, event);
	      },
	      onPull: function onPull(event) {
	        _classPrivateMethodGet(_this, _onPull, _onPull2).call(_this, event);
	      }
	    },
	    callbacks: {
	      onBeforeQueueExecute: function onBeforeQueueExecute(items) {
	        return _classPrivateMethodGet(_this, _onBeforeQueueExecute, _onBeforeQueueExecute2).call(_this, items);
	      },
	      onQueueExecute: function onQueueExecute(items) {
	        return _classPrivateMethodGet(_this, _onQueueExecute, _onQueueExecute2).call(_this, items);
	      },
	      onReload: function onReload() {
	        _classPrivateMethodGet(_this, _onReload, _onReload2).call(_this);
	      }
	    }
	  };
	  this.queueManager = new pull_queuemanager.QueueManager(_options);
	};
	function _onBeforeQueueExecute2(items) {
	  var _this2 = this;
	  items.forEach(function (item) {
	    var data = item.data;
	    var operation = PullOperation.createInstance({
	      grid: _this2.grid,
	      itemId: data.id,
	      action: data.action,
	      actionParams: data.actionParams
	    });
	    operation.execute(); // change to async and use Promise.all in return
	  });

	  return Promise.resolve();
	}
	function _onQueueExecute2(items) {
	  var ids = [];
	  items.forEach(function (_ref) {
	    var id = _ref.id,
	      action = _ref.data.action;
	    if (action === 'addItem' || action === 'updateItem') {
	      ids.push(parseInt(id, 10));
	    }
	  });
	  if (ids.length === 0) {
	    return Promise.resolve();
	  }
	  return this.grid.loadNew(ids, false, true, true, true);
	}
	function _onReload2() {
	  this.grid.reload();
	}
	function _onBeforePull2(event) {
	  var _event$data = event.data,
	    options = _event$data.options,
	    pullData = _event$data.pullData;
	  if (!pullData.command.startsWith(options.pullTag) && options.additionalData.viewMode !== ViewMode.MODE_ACTIVITIES) {
	    event.preventDefault();
	  }
	}
	function _onPull2(event) {
	  var params = event.data.pullData.params;
	  if (params.eventName === EventName.itemUpdated) {
	    _classPrivateMethodGet(this, _onPullItemUpdated, _onPullItemUpdated2).call(this, event);
	    return;
	  }
	  if (params.eventName === EventName.itemAdded) {
	    _classPrivateMethodGet(this, _onPullItemAdded, _onPullItemAdded2).call(this, event);
	    return;
	  }
	  if (params.eventName === EventName.itemDeleted) {
	    _classPrivateMethodGet(this, _onPullItemDeleted, _onPullItemDeleted2).call(this, event);
	    return;
	  }
	  if (params.eventName === EventName.stageAdded) {
	    _classPrivateMethodGet(this, _onPullStageChanged, _onPullStageChanged2).call(this, event);
	    return;
	  }
	  if (params.eventName === EventName.stageUpdated) {
	    _classPrivateMethodGet(this, _onPullStageChanged, _onPullStageChanged2).call(this, event);
	    return;
	  }
	  if (params.eventName === EventName.stageDeleted) {
	    _classPrivateMethodGet(this, _onPullStageDeleted, _onPullStageDeleted2).call(this, event);
	  }
	}
	function _onPullItemUpdated2(event) {
	  if (main_core.Type.isNil(event.data)) {
	    return;
	  }
	  var _event$data2 = event.data,
	    params = _event$data2.pullData.params,
	    promises = _event$data2.promises;
	  var item = this.grid.getItem(params.item.id);
	  if (item) {
	    promises.push(Promise.resolve({
	      data: _classPrivateMethodGet(this, _getPullData, _getPullData2).call(this, 'updateItem', params)
	    }));
	    return;
	  }
	  _classPrivateMethodGet(this, _onPullItemAdded, _onPullItemAdded2).call(this, params);
	  event.preventDefault();
	}
	function _onPullItemAdded2(event) {
	  if (main_core.Type.isNil(event.data)) {
	    return;
	  }
	  var _event$data3 = event.data,
	    params = _event$data3.pullData.params,
	    promises = _event$data3.promises;
	  var itemId = params.item.id;
	  var oldItem = this.grid.getItem(itemId);
	  if (oldItem) {
	    event.preventDefault();
	    return;
	  }
	  promises.push(Promise.resolve({
	    data: _classPrivateMethodGet(this, _getPullData, _getPullData2).call(this, 'addItem', params)
	  }));
	}
	function _getPullData2(action, actionParams) {
	  var id = actionParams.item.id;
	  return {
	    id: id,
	    action: action,
	    actionParams: actionParams
	  };
	}
	function _onPullItemDeleted2(event) {
	  var _this3 = this;
	  var params = event.data.pullData.params;
	  if (!main_core.Type.isPlainObject(params.item)) {
	    return;
	  }
	  var _params$item = params.item,
	    id = _params$item.id,
	    columnId = _params$item.data.columnId;

	  /**
	   * Delay so that the element has time to be rendered before deletion,
	   * if an event for changing the element came before. Ticket #141983
	   */
	  var delay = this.queueManager.hasInQueue(id) ? this.queueManager.getLoadItemsDelay() : 0;
	  setTimeout(function () {
	    _this3.queueManager.deleteFromQueue(id);
	    var grid = _this3.grid;
	    var item = grid.getItem(id);
	    if (!item) {
	      return;
	    }
	    grid.removeItem(id);
	    if (grid.getTypeInfoParam('showTotalPrice')) {
	      var column = grid.getColumn(columnId);
	      column.decPrice(item.data.price);
	      column.renderSubTitle();
	    }
	  }, delay);
	  event.preventDefault();
	}
	function _onPullStageChanged2(event) {
	  event.preventDefault();
	  this.grid.onApplyFilter();
	}
	function _onPullStageDeleted2(event) {
	  event.preventDefault();
	  var params = event.data.pullData.params;
	  this.grid.removeColumn(params.stage.id);
	}

	exports.PullManager = PullManager;
	exports.FieldsSelector = FieldsSelector;
	exports.ViewMode = ViewMode;

}((this.BX.Crm.Kanban = this.BX.Crm.Kanban || {}),BX,BX.Main,BX.Event,BX.Pull,BX.CRM.Kanban,BX));
//# sourceMappingURL=kanban.js.map
