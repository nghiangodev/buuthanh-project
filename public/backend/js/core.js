/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/backend/js/app/core.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* eslint-disable no-undef,no-console */


var $$ = function ($) {
  var handleModal = function handleModal() {
    // fix stackable modal issue: when 2 or more modals opened, closing one of modal will remove .modal-open class.
    $(document).on('hidden.bs.modal', function () {
      if ($('.modal:visible').length) {
        $('body').addClass('modal-open');
      }
    }); // fix page scrollbars issue

    $(document).on('show.bs.modal', '.modal', function () {
      if ($(this).hasClass('modal-scroll')) {
        $('body').addClass('modal-open-noscroll');
      }
    }); // fix page scrollbars issue

    $(document).on('hidden.bs.modal', '.modal', function () {
      $('body').removeClass('modal-open-noscroll');
    }); // remove ajax content and remove cache on modal closed

    $(document).on('hidden.bs.modal', '.modal:not(.modal-cached)', function () {
      $(this).removeData('bs.modal');
    });
  };

  var handleJqueryAjax = function handleJqueryAjax() {
    $(document).ajaxComplete(function () {
      unblock();
    });
    $(document).ajaxError(function () {
      unblock();
    });
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  };

  var handleInput = function handleInput() {
    //event cho nút check all & single ở table
    $(document).on('click', '.kt-checkbox--all > [type="checkbox"]', function () {
      var cbSingle = $('.kt-checkbox--single > [type="checkbox"]');

      if (!$(this).is(':checked')) {
        cbSingle.prop('checked', '');
      } else {
        cbSingle.prop('checked', 'checked');
      }
    }); //event cho nút check từng dòng ở table

    $(document).on('click', '.kt-checkbox--single > [type="checkbox"]', function () {
      var cbSingle = $('.kt-checkbox--single > [type="checkbox"]');
      var cbAll = $('.kt-checkbox--all > [type="checkbox"]');

      if ($(this).is(':checked')) {
        var cbSingleChecked = $('.kt-checkbox--single > [type="checkbox"]:checked');

        if (cbSingle.length === cbSingleChecked.length) {
          cbAll.prop('checked', 'checked');
        } else {
          cbAll.prop('checked', '');
        }
      } else {
        cbAll.prop('checked', '');
      }
    }); //Set select text cho thẻ input focus
    // noinspection JSCheckFunctionSignatures

    $('input, textarea').focus(function () {
      $(this).select();
    });
  };

  var handleAxios = __webpack_require__("./resources/backend/js/app/plugins/_axios.js");

  var handleSelect2 = __webpack_require__("./resources/backend/js/app/plugins/_select2.js");

  var handleDatepicker = __webpack_require__("./resources/backend/js/app/plugins/_datepicker.js");

  var handleHighcharts = __webpack_require__("./resources/backend/js/app/plugins/_highcharts.js");

  var handleMomentJs = __webpack_require__("./resources/backend/js/app/plugins/_moment.js");

  var handleAlphanum = __webpack_require__("./resources/backend/js/app/plugins/_alphanum.js");

  var handleCleave = __webpack_require__("./resources/backend/js/app/plugins/_cleave.js");

  var handleDatatables = __webpack_require__("./resources/backend/js/app/plugins/_datatables.js");

  var handleValidation = __webpack_require__("./resources/backend/js/app/plugins/_validations.js");

  var handlePluginJquery = __webpack_require__("./resources/backend/js/app/plugins/_jq_plugins.js");

  return {
    init: function init() {
      handleAxios();
      handleModal();
      handleJqueryAjax();
      handleInput();
      handleSelect2();
      handleDatepicker();
      handleHighcharts();
      handleMomentJs();
      handleAlphanum();
      handleCleave();
      handleDatatables();
      handleValidation();
      handlePluginJquery();
    }
  };
}(jQuery);

module.exports = $$;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_alphanum.js":
/***/ (function(module, exports) {

var initAlphanum = function initAlphanum() {
  // noinspection JSUnresolvedVariable
  if (typeof $.fn.alphanum === 'function') {
    $('.text-alphanum').alphanum({
      allow: '-_,./%#@()*'
    });
    $('.text-string').alpha();
    $('.text-phone').alphanum({
      allowMinus: false,
      allowLatin: false,
      allowSpace: false,
      allowOtherCharSets: false,
      maxLength: 11
    });
    $('.text-mobile-phone').alphanum({
      allowMinus: false,
      allowLatin: false,
      allowSpace: false,
      allowOtherCharSets: false,
      maxLength: 10
    });
  }
};

module.exports = initAlphanum;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_axios.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var initAxios = function initAxios() {
  axios.interceptors.response.use(function (response) {
    return response.data;
  }, function (error) {
    //note: unauthorized user
    if (error.response !== undefined) {
      var httpCode = error.response.status;

      if (httpCode === 401 || httpCode === 419) {
        var text = error.response.data.message || error.message;
        error(function () {
          return location.reload();
        }, {
          text: text
        });
      }

      return Promise.reject(ajaxErrorHandler(error.response));
    }

    return Promise.reject(error);
  });
};

module.exports = initAxios;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_cleave.js":
/***/ (function(module, exports) {

var initCleave = function initCleave() {
  if (typeof Cleave === 'function') {
    if ($('.text-decimal').length > 0) {
      $('.text-decimal').each(function () {
        new Cleave('.text-decimal', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });
      });
    }

    if ($('.text-numeric').length > 0) {
      $('.text-numeric').each(function () {
        new Cleave(this, {
          numeral: true
        });
      });
    }
  }
};

module.exports = initCleave;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_datatables.js":
/***/ (function(module, exports) {

var initDatatable = function initDatatable() {
  if (typeof $.fn.dataTable === 'function') {
    var language = $('html').attr('lang');
    var optionLang = {
      'sLengthMenu': " \n\t\t\t\t<select class=\"kt_selectpicker\" data-width=\"85px\">\n\t\t\t\t\t<option value=\"10\">10</option>\n\t\t\t\t\t<option value=\"20\">20</option>\n\t\t\t\t\t<option value=\"30\">30</option>\n\t\t\t\t\t<option value=\"40\">40</option>\n\t\t\t\t\t<option value=\"50\">50</option>\n\t\t\t\t</select>",
      'sSearch': 'Search:',
      'oPaginate': {
        'sFirst': '<i class="far fa-angle-double-left"></i>',
        'sPrevious': '<i class="far fa-angle-left"></i>',
        'sNext': '<i class="far fa-angle-right"></i>',
        'sLast': '<i class="far fa-angle-double-right"></i>'
      },
      'sEmptyTable': 'No data available',
      'sProcessing': 'Loading...',
      'sZeroRecords': 'No matching records found',
      'sInfo': 'Showing _START_ to _END_ of _TOTAL_ entries',
      'sInfoEmpty': 'Showing 0 to 0 of 0 entries',
      'sInfoFiltered': '(filtered from _MAX_ total entries)',
      'sInfoPostFix': '',
      'sUrl': ''
    };

    if (language === 'vi') {
      optionLang = {
        'sEmptyTable': 'Không có dữ liệu',
        'sProcessing': 'Đang xử lý...',
        sLengthMenu: " \n\t\t\t\t\t<select class=\"kt_selectpicker\" data-width=\"85px\">\n\t\t\t\t\t\t<option value=\"10\">10</option>\n\t\t\t\t\t\t<option value=\"20\">20</option>\n\t\t\t\t\t\t<option value=\"30\">30</option>\n\t\t\t\t\t\t<option value=\"40\">40</option>\n\t\t\t\t\t\t<option value=\"50\">50</option>\n\t\t\t\t\t</select>",
        'sZeroRecords': 'Không tìm thấy dữ liệu phù hợp',
        'sInfo': 'Đang xem _START_ đến _END_ trên _TOTAL_ mục',
        'sInfoEmpty': 'Đang xem 0 đến 0 trong tổng số 0 mục',
        'sInfoFiltered': '(được lọc từ _MAX_ dòng)',
        'sInfoPostFix': '',
        'sSearch': 'Tìm:',
        'sUrl': '',
        'oPaginate': {
          'sFirst': '<i class="far fa-angle-double-left"></i>',
          'sPrevious': '<i class="far fa-angle-left"></i>',
          'sNext': '<i class="far fa-angle-right"></i>',
          'sLast': '<i class="far fa-angle-double-right"></i>'
        }
      };
    }

    $.extend(true, $.fn.dataTable.defaults, {
      'oLanguage': optionLang,
      'info': true,
      'searching': false,
      'columnDefs': [{
        'targets': [0],
        'searchable': false,
        'sortable': false,
        'orderable': false,
        'visible': true,
        'width': '5%',
        'className': 'dt-center'
      }, {
        'targets': [-1],
        'searchable': false,
        'orderable': false,
        'visible': true,
        'className': 'dt-left all nowrap-col',
        'width': '5%'
      }],
      'dom': 'rt<"bottom"ilp>',
      'order': [],
      'iDisplayLength': 10,
      'autoWidth': true,
      'processing': false,
      'paging': false,
      'searchDelay': 500,
      'pagingType': KTUtil.isMobileDevice() ? 'simple_numbers' : 'full_numbers',
      'responsive': true,
      'lengthChange': true,
      'conditionalPaging': true,
      buttons: ['excelHtml5', 'pdfHtml5']
    });

    $.fn.dataTable.pipeline = function (opts) {
      // Configuration options
      var conf = $.extend({
        pages: 5,
        // number of pages to cache
        url: '',
        // script url
        data: null,
        // function or object with parameters to send to the server
        // matching how `ajax.data` works in DataTables
        method: 'POST' // Ajax HTTP method

      }, opts); // Private variables for storing the cache

      var cacheLower = -1;
      var cacheUpper = null;
      var cacheLastRequest = null;
      var cacheLastJson = null;
      return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;

        if (requestLength < 0) {
          requestLength = 50;
        }

        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
          // API requested that the cache be cleared
          ajax = true;
          settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
          // outside cached data - need to make a request
          ajax = true;
        } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) || JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) || JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)) {
          // properties changed (ordering, columns, searching)
          ajax = true;
        } // Store the request for checking next time around


        cacheLastRequest = _.merge({}, request);

        if (ajax) {
          // Need data from the server
          if (requestStart < cacheLower) {
            requestStart = requestStart - requestLength * (conf.pages - 1);

            if (requestStart < 0) {
              requestStart = 0;
            }
          }

          cacheLower = requestStart;
          cacheUpper = requestStart + requestLength * conf.pages;
          request.start = requestStart;
          request.length = requestLength * conf.pages; // Provide the same `data` options as DataTables.

          if (typeof conf.data === 'function') {
            // As a function it is executed with the data object as an arg
            // for manipulation. If an object is returned, it is used as the
            // data object to submit
            var d = conf.data(request);

            if (d) {
              _.assign(request, d);
            }
          } else if (isPlainObject(conf.data)) {
            // As an object, the data given extends the default
            _.assign(request, conf.data);
          }

          settings.jqXHR = $.ajax({
            'type': conf.method,
            'url': conf.url,
            'data': request,
            'dataType': 'json',
            'cache': false,
            'success': function success(json) {
              cacheLastJson = _.merge({}, json); // noinspection EqualityComparisonWithCoercionJS

              if (cacheLower != drawStart) {
                json.data.splice(0, drawStart - cacheLower);
              }

              if (requestLength > -1) {
                json.data.splice(requestLength, json.data.length);
              }

              drawCallback(json);
            },
            'error': function (_error) {
              function error(_x) {
                return _error.apply(this, arguments);
              }

              error.toString = function () {
                return _error.toString();
              };

              return error;
            }(function (jqXHR) {
              var errorMsg = null;
              var status = jqXHR.status;

              if (status === 419) {
                errorMsg = lang['Login session has expired. Please log in again.'];
              }

              if (status === 500) {
                errorMsg = lang['Whoops, something went wrong on our servers.'];
              }

              if (errorMsg) {
                error(function () {
                  if (status === 419) {
                    location.reloadTable();
                  }
                }, {
                  text: errorMsg
                });
              }
            })
          });
        } else {
          // let json = $.extend(true, {}, cacheLastJson)
          var json = _.merge({}, cacheLastJson);

          json.draw = request.draw; // Update the echo for each response

          json.data.splice(0, requestStart - cacheLower);
          json.data.splice(requestLength, json.data.length);
          drawCallback(json);
        }
      };
    };
    /**
     * @memberOf $.fn.dataTable.Api
     */


    var clearPipline = function clearPipline() {
      return this.iterator('table', function (settings) {
        settings.clearCache = true;
      });
    };

    $.fn.dataTable.Api.register('clearPipeline()', clearPipline);
    /**
     * @memberOf $.fn.dataTable.Api
     */

    var reloadTable = function reloadTable() {
      return this.clearPipeline().draw();
    };

    $.fn.dataTable.Api.register('reloadTable()', reloadTable);
    /**
     * @memberOf $.fn.dataTable.Api
     */

    var exportExcel = function exportExcel() {
      return this.buttons(0).trigger();
    };

    $.fn.dataTable.Api.register('exportExcel()', exportExcel);
    /**
     * @memberOf $.fn.dataTable.Api
     */

    var exportPdf = function exportPdf() {
      return this.buttons(1).trigger();
    };

    $.fn.dataTable.Api.register('exportPdf()', exportPdf);
    /**
     * @method
     * @memberOf $.fn.dataTable.Api
     * @param btnDelete
     * @param message
     * @param title
     * @param params
     */

    var actionDelete = function actionDelete() {
      var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
          btnDelete = _ref.btnDelete,
          _ref$message = _ref.message,
          message = _ref$message === void 0 ? lang['Do you want to continue?'] : _ref$message,
          _ref$title = _ref.title,
          title = _ref$title === void 0 ? lang['Delete data !!!'] : _ref$title,
          _ref$params = _ref.params,
          params = _ref$params === void 0 ? {} : _ref$params;

      var table = this;
      var url = btnDelete.data('url');

      if (url !== '' && url !== undefined) {
        var checkbox = btnDelete.parents('tr').find('.kt-checkbox--single > [type="checkbox"]');
        var deleteTitle = btnDelete.data('title');

        if (deleteTitle === undefined) {
          deleteTitle = title;
        }

        checkbox.prop('checked', 'checked');
        btnDelete.swal(function (result) {
          if (result.value) {
            request.doDelete({
              url: url,
              params: params,
              callback: function callback(data) {
                flash({
                  message: data.message
                });
                table.reloadTable();
              }
            });
          }

          checkbox.prop('checked', '');
        }, {
          title: deleteTitle,
          type: 'error',
          text: message
        });
      }
    };

    $.fn.dataTable.Api.register('actionDelete()', actionDelete);
    /**
     * @method
     * @memberOf $.fn.dataTable.Api
     * @param btnEdit
     * @param redirectTo
     * @param params
     * @param message
     * @param title
     */

    var actionEdit = function actionEdit() {
      var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
          btnEdit = _ref2.btnEdit,
          redirectTo = _ref2.redirectTo,
          _ref2$params = _ref2.params,
          params = _ref2$params === void 0 ? {} : _ref2$params,
          _ref2$message = _ref2.message,
          message = _ref2$message === void 0 ? lang['Do you want to continue?'] : _ref2$message,
          _ref2$title = _ref2.title,
          title = _ref2$title === void 0 ? lang['Edit data !!!'] : _ref2$title;

      var table = this;
      var url = btnEdit.data('url');

      if (url !== '' && url !== undefined) {
        var checkbox = btnEdit.parents('tr').find('.kt-checkbox--single > [type="checkbox"]');
        var editTitle = btnEdit.data('title');

        if (editTitle === undefined) {
          editTitle = title;
        }

        checkbox.prop('checked', 'checked');
        btnEdit.swal(function (result) {
          if (result.value) {
            request.doPost({
              url: url,
              params: params,
              callback: function callback(data) {
                flash({
                  message: data.message
                });

                if (redirectTo !== undefined && redirectTo !== '') {
                  location.href = redirectTo;
                }

                table.reloadTable();
              }
            });
          } else {
            unblock();
          }

          checkbox.prop('checked', '');
        }, {
          title: editTitle,
          type: 'warning',
          text: message
        });
      }
    };

    $.fn.dataTable.Api.register('actionEdit()', actionEdit);
    /**
     * Update original input/select on change in child row
     */

    $.fn.dataTable.Api.register('updateChildRow()', function () {
      var self = this;
      var tableSelector = self.context[0].sTableId; // Update original input/select on change in child row

      $("#".concat(tableSelector, " tbody")).on('keyup change', '.child input, .child select, .child textarea', function () {
        var $el = $(this);
        var rowIdx = $el.closest('ul').data('dtr-index');
        var colIdx = $el.closest('li').data('dtr-index');
        var cell = self.cell({
          row: rowIdx,
          column: colIdx
        }).node();
        $('input, select, textarea', cell).val($el.val());

        if ($el.is(':checked')) {
          $('input', cell).prop('checked', true);
        } else {
          $('input', cell).removeProp('checked');
        }
      });
    }); //conditionalPaging

    $(document).on('init.dt', function (e, dtSettings) {
      $('.kt_selectpicker').selectpicker({
        style: 'btn-light btn-sm',
        width: '65px'
      });

      if (e.namespace !== 'dt') {
        return;
      }

      var options = dtSettings.oInit.conditionalPaging;

      if (options === true) {
        var api = new $.fn.dataTable.Api(dtSettings);

        var conditionalPaging = function conditionalPaging(e) {
          var $pagingContainer = $(api.table().container());
          var $paging = $pagingContainer.find('div.dataTables_paginate'),
              $pagingLength = $pagingContainer.find('div.dataTables_length'),
              pages = api.page.info().pages;

          if (e instanceof $.Event) {
            if (pages <= 1) {
              $paging.css('display', 'none');
            } else {
              $paging.css('display', 'block');
              $pagingLength.css('display', 'block');
            }
          } else if (pages <= 1) {
            $paging.css('display', 'none');
            $pagingLength.css('display', 'none');
          }
        };

        conditionalPaging();
        api.on('draw.dt', conditionalPaging);
      }
    });
    $(document).on('preXhr.dt', function () {
      blockPage();
    });
    $(document).on('xhr.dt', function () {
      unblock();
    });
    var $datatables = $('.datatables');

    if ($datatables.length > 0) {
      $datatables.DataTable({
        paging: true,
        conditionalPaging: true,
        'columnDefs': [{
          'targets': '_all',
          'searchable': true,
          'orderable': true,
          'visible': true
        }, {
          'targets': [-1],
          'searchable': false,
          'orderable': false,
          'visible': true
        }]
      });
    }
  }
};

module.exports = initDatatable;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_datepicker.js":
/***/ (function(module, exports) {

var initDatepicker = function initDatepicker() {
  var i18nObject = {
    days: ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'],
    daysShort: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
    daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
    months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
    monthsShort: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
    meridiem: '',
    today: 'Hôm nay',
    clear: 'Xóa'
  };
  var language = $('html').attr('lang');

  if (typeof $.fn.datepicker === 'function') {
    $.extend(true, $.fn.datepicker.defaults, {
      format: 'dd-mm-yyyy',
      autoclose: true,
      orientation: 'bottom left',
      todayHighlight: true,
      language: language,
      todayBtn: 'linked' // clearBtn: true

    });
    $.fn.datepicker.dates['vi'] = i18nObject;
    $('.text-datepicker, .input-group.date').datepicker();
    var d = new Date();
    d.setFullYear(d.getFullYear() - 10);
    d.setDate(31);
    d.setMonth(11);
    $('.text-datepicker-dob').datepicker({
      endDate: d,
      todayBtn: false
    });
  }

  if (typeof $.fn.datetimepicker === 'function') {
    $.extend(true, $.fn.datetimepicker.defaults, {
      format: 'dd-mm-yyyy hh:ii:ss',
      autoclose: true,
      orientation: 'bottom left',
      todayHighlight: true,
      language: language,
      todayBtn: 'linked',
      forceParse: false // clearBtn: true

    });
    $.fn.datetimepicker.dates['vi'] = i18nObject;
    $('.text-dateptimepicker, .input-group.datetime').datetimepicker();
  }

  if (typeof $.fn.timepicker === 'function') {
    $.extend(true, $.fn.timepicker.defaults, {
      showMeridian: false,
      explicitMode: true // defaultTime: '00:00',
      // defaultTime: false

    });
    $('.text-timepicker, .input-group.time').timepicker();
  }
};

module.exports = initDatepicker;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_highcharts.js":
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var initHighcharts = function initHighcharts() {
  if ((typeof Highcharts === "undefined" ? "undefined" : _typeof(Highcharts)) === 'object') {
    var options = {
      chart: {
        style: {
          fontFamily: 'Montserrat',
          fontWeight: 'bold'
        }
      },
      credits: {
        enabled: false
      }
    };
    Highcharts.setOptions(options);
  }
};

module.exports = initHighcharts;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_jq_plugins.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var jqueryPlugins = function jqueryPlugins() {
  /**
   * Tạo mảng giá trị từ nhiều input cùng class
   * @param attribute (optional): tên của data attribute
   * @param parse (optional): parse dữ liệu (Number, String, Boolean)
   * @return array
   */
  $.fn.getValue = function () {
    var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
        attribute = _ref.attribute,
        parse = _ref.parse;

    var elements = this.toArray();
    elements = attribute !== undefined ? elements.map(function (elem) {
      return elem.getAttribute("data-".concat(attribute));
    }) : elements.map(function (elem) {
      return elem.value;
    });
    return parse !== undefined ? elements.map(parse) : elements;
  };
  /**
   * Lưu form sử dụng Form data
   * @param url
   * @param formData
   * @param data: custom data
   * @param returnEarly: return promise without handle by default
   * @return Promise
   */


  $.fn.submitData = function () {
    var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
        url = _ref2.url,
        formData = _ref2.formData,
        data = _ref2.data,
        returnEarly = _ref2.returnEarly;

    blockPage();
    var method = 'post';
    url = url === undefined ? $(this).prop('action') : url;

    if (formData === undefined) {
      // noinspection JSCheckFunctionSignatures
      formData = this.is('form') ? new FormData(this[0]) : new FormData();
    }

    if (data !== undefined && _typeof(data) === 'object') {
      Object.entries(data).forEach(function (_ref3) {
        var _ref4 = _slicedToArray(_ref3, 2),
            key = _ref4[0],
            value = _ref4[1];

        return formData.append(key, value);
      });
    }

    if (returnEarly !== undefined && returnEarly) {
      return request.doRequest({
        url: url,
        data: formData,
        method: method,
        config: {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      });
    }

    return request.doRequest({
      url: url,
      data: formData,
      method: method,
      config: {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      },
      callback: function callback(data) {
        if (data.message !== undefined && data.message !== '') {
          flash({
            message: data.message
          });
        }

        return data;
      }
    });
  };
  /**
   * Hiện modal xác nhận hành động
   * @param callback: hàm xử lý hành động
   * @param text: nội dung
   * @param title: tiêu đề
   * @param type: loại modal xác nhận (warning, info, danger)
   * @param showCancelButton: hiện nút cancel hoặc không (default true)
   * @param confirmButtonText: text cho button confirm
   */


  $.fn.swal = function (callback) {
    var _ref5 = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
        _ref5$text = _ref5.text,
        text = _ref5$text === void 0 ? lang['Do you want to continue?'] : _ref5$text,
        _ref5$title = _ref5.title,
        title = _ref5$title === void 0 ? lang['Confirm action!!!'] : _ref5$title,
        _ref5$type = _ref5.type,
        type = _ref5$type === void 0 ? 'warning' : _ref5$type,
        _ref5$showCancelButto = _ref5.showCancelButton,
        showCancelButton = _ref5$showCancelButto === void 0 ? true : _ref5$showCancelButto,
        _ref5$confirmButtonTe = _ref5.confirmButtonText,
        confirmButtonText = _ref5$confirmButtonTe === void 0 ? lang['Yes'] : _ref5$confirmButtonTe;

    var confirmTitle = $(this).data('confirm-title') || title;
    var confirmText = $(this).data('confirm-text') || text;
    var contextClass = type;

    if (contextClass === 'error') {
      contextClass = 'danger';
    }

    if (contextClass === 'question') {
      contextClass = 'primary';
    }

    var icons = {
      danger: '<i class="fad kt-font-danger fa-times"></i>',
      warning: '<i class="fad kt-font-warning fa-exclamation"></i>',
      success: '<i class="fad kt-font-success fa-check"></i>',
      info: '<i class="fad kt-font-info fa-info"></i>',
      primary: '<i class="fad kt-font-primary fa-question"></i>'
    };
    window.blockPage();
    var fire = Swal.fire({
      title: confirmTitle,
      text: confirmText,
      icon: type,
      showCancelButton: showCancelButton,
      customClass: {
        confirmButton: "btn btn-".concat(contextClass),
        cancelButton: "btn btn-outline-hover-".concat(contextClass),
        header: "header-".concat(contextClass)
      },
      confirmButtonText: confirmButtonText,
      cancelButtonText: lang['No'],
      buttonsStyling: false,
      iconHtml: icons[contextClass]
    });

    if (callback !== undefined) {
      fire.then(callback);
    }

    fire["finally"](function () {
      window.unblock();
    });
    return fire;
  };
  /**
   * Hiện modal với content load ajax
   * @param url: đường dẫn gọi form modal
   * @param params: tham số truyền vào request
   * @param method: phương thức của ajax request
   * @returns {*}
   */


  $.fn.showModal = function (_ref6) {
    var _this = this;

    var url = _ref6.url,
        _ref6$params = _ref6.params,
        params = _ref6$params === void 0 ? {} : _ref6$params,
        _ref6$method = _ref6.method,
        method = _ref6$method === void 0 ? 'get' : _ref6$method;
    blockPage();
    return request.doRequest({
      url: url,
      data: params,
      method: method,
      callback: function callback(data) {
        _this.find('.modal-content').html(data);

        _this.modal({
          backdrop: 'static',
          keyboard: true
        });
      }
    });
  };
  /**
   * Clear form co select2
   */


  $.fn.resetForm = function () {
    var option = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'clear_all';

    if (option === 'clear_all') {
      this.find('input, select').val(null).trigger('change');
    } else {
      this[0].reset();
    }
  };
};

module.exports = jqueryPlugins;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_moment.js":
/***/ (function(module, exports) {

var initMoment = function initMoment() {
  if (typeof moment !== 'undefined') {
    moment.defineLocale('vi', {
      months: 'tháng 1_tháng 2_tháng 3_tháng 4_tháng 5_tháng 6_tháng 7_tháng 8_tháng 9_tháng 10_tháng 11_tháng 12'.split('_'),
      monthsShort: 'Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12'.split('_'),
      monthsParseExact: true,
      weekdays: 'chủ nhật_thứ hai_thứ ba_thứ tư_thứ năm_thứ sáu_thứ bảy'.split('_'),
      weekdaysShort: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
      weekdaysMin: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
      weekdaysParseExact: true,
      meridiemParse: /sa|ch/i,
      isPM: function isPM(input) {
        return /^ch$/i.test(input);
      },
      meridiem: function meridiem(hours, minutes, isLower) {
        if (hours < 12) {
          return isLower ? 'sa' : 'SA';
        } else {
          return isLower ? 'ch' : 'CH';
        }
      },
      longDateFormat: {
        LT: 'HH:mm',
        LTS: 'HH:mm:ss',
        L: 'DD/MM/YYYY',
        LL: 'D MMMM [năm] YYYY',
        LLL: 'D MMMM [năm] YYYY HH:mm',
        LLLL: 'dddd, D MMMM [năm] YYYY HH:mm',
        l: 'DD/M/YYYY',
        ll: 'D MMM YYYY',
        lll: 'D MMM YYYY HH:mm',
        llll: 'ddd, D MMM YYYY HH:mm'
      },
      calendar: {
        sameDay: '[Hôm nay lúc] LT',
        nextDay: '[Ngày mai lúc] LT',
        nextWeek: 'dddd [tuần tới lúc] LT',
        lastDay: '[Hôm qua lúc] LT',
        lastWeek: 'dddd [tuần rồi lúc] LT',
        sameElse: 'L'
      },
      relativeTime: {
        future: '%s tới',
        past: '%s trước',
        s: 'vài giây',
        ss: '%d giây',
        m: 'một phút',
        mm: '%d phút',
        h: 'một giờ',
        hh: '%d giờ',
        d: 'một ngày',
        dd: '%d ngày',
        M: 'một tháng',
        MM: '%d tháng',
        y: 'một năm',
        yy: '%d năm'
      },
      dayOfMonthOrdinalParse: /\d{1,2}/,
      ordinal: function ordinal(number) {
        return number;
      },
      week: {
        dow: 1,
        // Monday is the first day of the week.
        doy: 4 // The week that contains Jan 4th is the first week of the year.

      }
    });
  }
};

module.exports = initMoment;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_select2.js":
/***/ (function(module, exports) {

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var initSelect2 = function initSelect2() {
  if (typeof $.fn.select2 === 'function') {
    var language = $('html').attr('lang');
    var viObj = {
      inputTooLong: function inputTooLong(args) {
        var overChars = args.input.length - args.maximum;
        return 'Vui lòng xóa bớt ' + overChars + ' ký tự';
      },
      inputTooShort: function inputTooShort(args) {
        var remainingChars = args.minimum - args.input.length;
        return 'Vui lòng nhập thêm từ ' + remainingChars + ' ký tự trở lên';
      },
      loadingMore: function loadingMore() {
        return 'Đang lấy thêm kết quả…';
      },
      maximumSelected: function maximumSelected(args) {
        return 'Chỉ có thể chọn được ' + args.maximum + ' lựa chọn';
      },
      noResults: function noResults() {
        return 'Không tìm thấy kết quả';
      },
      searching: function searching() {
        return 'Đang tìm…';
      },
      removeAllItems: function removeAllItems() {
        return 'Xóa tất cả các mục';
      }
    };
    var enObj = {
      errorLoading: function errorLoading() {
        return 'The results could not be loaded.';
      },
      inputTooLong: function inputTooLong(args) {
        var overChars = args.input.length - args.maximum;
        var message = 'Please delete ' + overChars + ' character';

        if (overChars !== 1) {
          message += 's';
        }

        return message;
      },
      inputTooShort: function inputTooShort(args) {
        var remainingChars = args.minimum - args.input.length;
        return 'Please enter ' + remainingChars + ' or more characters';
      },
      loadingMore: function loadingMore() {
        return 'Loading more results…';
      },
      maximumSelected: function maximumSelected(args) {
        var message = 'You can only select ' + args.maximum + ' item';

        if (args.maximum !== 1) {
          message += 's';
        }

        return message;
      },
      noResults: function noResults() {
        return 'No results found';
      },
      searching: function searching() {
        return 'Searching…';
      },
      removeAllItems: function removeAllItems() {
        return 'Remove all items';
      }
    };
    var chooseText = lang['Choose']; //Select2 default config

    $.extend(true, $.fn.select2.defaults.defaults, {
      width: '100%',
      allowClear: true,
      placeholder: chooseText,
      language: language === 'vi' ? viObj : enObj
    });
    $('.select').select2();
    /**
     * Khai báo sử dụng select2 ajax
     * @param options
     * options: {
     *     url: đường dẫn gọi ajax,
     *     column: giá tri muốn hiển thị (default là name hoặc code),
     *     allowClear: thuộc tính clear select (default là true),
     *     data: function(q): hàm truyền tham số
     * }
     * @returns {*|void}
     */

    $.fn.select2Ajax = function () {
      var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var url = $(this).data('url');
      var col = $(this).data('column');
      var column = options.hasOwnProperty('column') ? options.column : '';
      var finalUrl = url || options.url;
      column = column || col;
      var settings = {
        ajax: {
          url: finalUrl,
          dataType: 'json',
          delay: 50,
          data: function data(params) {
            var paramFinal = {
              query: params.term,
              // search term
              page: params.page
            };

            if (typeof options.data === 'function') {
              options.data(params);

              _.assign(paramFinal, params);
            }

            return paramFinal;
          },
          processResults: function processResults(data, params) {
            params.page = params.page || 1; // noinspection JSUnresolvedVariable

            return {
              results: data.items,
              pagination: {
                more: params.page * 10 <= data.total_count
              }
            };
          },
          cache: true
        },
        escapeMarkup: function escapeMarkup(markup) {
          return markup;
        },
        allowClear: options.allowClear !== undefined ? options.allowClear : true,
        minimumInputLength: options.hasOwnProperty('minimumInputLength') ? options.minimumInputLength : 0,
        maximumSelectionLength: options.hasOwnProperty('maximumSelectionLength') ? options.maximumSelectionLength : 0,
        templateResult: options.hasOwnProperty('templateResult') ? options.templateResult : function (repo) {
          if (repo.loading) {
            return repo.text;
          }

          if (column !== '' && typeof repo[column] !== 'undefined') {
            return "<div class=\"select2-result-repository clearfix\"><div class=\"select2-result-repository__title\"> ".concat(repo[column], " </div>");
          }

          if (typeof repo['name'] !== 'undefined') {
            return "<div class=\"select2-result-repository clearfix\"><div class=\"select2-result-repository__title\"> ".concat(repo['name'], " </div>");
          }

          if (typeof repo['code'] !== 'undefined') {
            return "<div class=\"select2-result-repository clearfix\"><div class=\"select2-result-repository__title\"> ".concat(repo['code'], " </div>");
          }
        },
        templateSelection: options.hasOwnProperty('templateSelection') ? options.templateSelection : function (repo) {
          var val = repo.text;

          if (column !== '' && typeof repo[column] !== 'undefined') {
            val = repo[column];
          } else if (typeof repo.code !== 'undefined') {
            val = repo['code'];
          } else if (typeof repo.name !== 'undefined') {
            val = repo['name'];
          }

          return val;
        }
      };

      if ($(this).prop('multiple')) {
        settings = _objectSpread({}, {
          tags: true,
          tokenSeparators: [',', ' ']
        }, {}, settings);
      }

      return this.select2(settings);
    };

    var $select2Ajax = $('.select2-ajax');

    if ($select2Ajax.length > 0) {
      $select2Ajax.each(function () {
        $(this).select2Ajax();
      });
    }
  }
};

module.exports = initSelect2;

/***/ }),

/***/ "./resources/backend/js/app/plugins/_validations.js":
/***/ (function(module, exports) {

var initValidation = function initValidation() {
  var language = $('html').attr('lang');

  if (typeof $.validator !== 'undefined') {
    if (language === 'vi') {
      $.extend($.validator.messages, {
        required: 'Hãy nhập giá trị.',
        remote: 'Hãy sửa cho đúng.',
        email: 'Hãy nhập email.',
        url: 'Hãy nhập URL.',
        date: 'Hãy nhập ngày.',
        dateISO: 'Hãy nhập ngày (ISO).',
        number: 'Hãy nhập số.',
        digits: 'Hãy nhập chữ số.',
        creditcard: 'Hãy nhập số thẻ tín dụng.',
        equalTo: 'Hãy nhập giống thêm lần nữa.',
        extension: 'Phần mở rộng không đúng.',
        maxlength: $.validator.format('Hãy nhập từ {0} kí tự trở xuống.'),
        minlength: $.validator.format('Hãy nhập từ {0} kí tự trở lên.'),
        rangelength: $.validator.format('Hãy nhập từ {0} đến {1} kí tự.'),
        range: $.validator.format('Hãy nhập từ {0} đến {1}.'),
        max: $.validator.format('Hãy nhập từ {0} trở xuống.'),
        min: $.validator.format('Hãy nhập từ {0} trở lên.')
      });
    }

    $.validator.addMethod('greaterThan', function (value, element, params) {
      if ($(params[0]).val() !== '' && value !== '') {
        var isTime = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])?$/.test(value);

        if (isTime) {
          var beginningTime = moment($(params[0]).val(), 'h:mm');
          var endTime = moment(value, 'h:mm');
          return beginningTime.isBefore(endTime);
        } else {
          // noinspection JSCheckFunctionSignatures
          if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) > new Date($(params[0]).val());
          } else {
            return Number(value) > Number($(params[0]).val());
          }
        }
      }

      return true;
    }, '{1} phải lớn hơn {2}.');
    $.validator.addMethod('pwCheck', function (value) {
      return /^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/.test(value); // consists of only these
    }, 'Mật khẩu phải gồm ít nhất 8 kí tự bao gồm kí tự thường, kí tự hoa, số (VD: Cloudteam123)');
    $.validator.setDefaults({
      showErrors: function showErrors() {
        var numberOfInvalids = this.numberOfInvalids();
        var message = numberOfInvalids + lang[' field(s) are invalid'];

        if (numberOfInvalids > 0) {
          if ($('.modal-open').length === 0) {
            flash({
              message: message,
              level: 'danger',
              hide: false
            });
          }
        } else {
          window.events.$emit('hide');
        }

        this.defaultShowErrors();
      }
    });
  }
};

module.exports = initValidation;

/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/backend/js/app/core.js");


/***/ })

/******/ });
