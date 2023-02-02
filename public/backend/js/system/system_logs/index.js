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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "0b397983736b7c5cccec":
/***/ (function(module, exports) {

$(function () {
  var $body = $('body');
  var tableLogs = $('#table_system_logs').DataTable({
    'serverSide': true,
    'paging': true,
    'ajax': $.fn.dataTable.pipeline({
      url: route('system_logs.table'),
      data: function data(q) {
        q.filters = JSON.stringify($('#system_logs_search_form').serializeArray());
      }
    }),
    'columnDefs': [{
      'targets': [-1],
      'searchable': false,
      'orderable': false,
      'visible': true,
      'className': 'dt-left',
      'width': '8%'
    }]
  });
  $('.btn-refresh-table, #btn_reset_filter').on('click', function (e) {
    e.stopPropagation();
    $('#system_logs_search_form').resetForm();
    tableLogs.reloadTable();
  });
  $body.on('submit', '#system_logs_search_form', function () {
    tableLogs.reloadTable();
    return false;
  });
  $body.on('click', '.btn-action-view', function () {
    var url = $(this).data('url');
    var text = $(this).parent().find('.txt-content').val();
    var stack = $(this).parent().find('.txt-stack').val();
    $('#modal_lg').showModal({
      url: url,
      method: 'post',
      params: {
        content: text,
        stack: stack
      }
    }); // return request.doPost({
    // 	url,
    // 	params: {
    // 		content: text,
    // 		stack: stack,
    // 	},
    // 	callback: data => {
    // 		$('#modal_lg').find('.modal-content').html(data)
    // 		$('#modal_lg').modal({
    // 			backdrop: 'static',
    // 			keyboard: true,
    // 		})
    // 	},
    // })
  });
});

/***/ }),

/***/ 8:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("0b397983736b7c5cccec");


/***/ })

/******/ });