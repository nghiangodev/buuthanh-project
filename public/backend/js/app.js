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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("f64b1d314d6045d2a6b9");
__webpack_require__("867224ff66af7684ef4c");
__webpack_require__("b1b44e1eb764ab106a17");
__webpack_require__("1aa6885f1b906a5a72ef");
module.exports = __webpack_require__("46c850ebd9f78c4e962c");


/***/ }),

/***/ "1aa6885f1b906a5a72ef":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "46c850ebd9f78c4e962c":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "6046c90b89c04273b493":
/***/ (function(module, exports) {

$(function () {
  var $body = $('body');
  $body.on('click', '.span-bell-icon', function () {
    $(this).removeClass('swing');
  }); //notification mark done

  $body.on('click', '.notification-section .kt-notification__item', function (e) {
    var _this = this;

    var readUrl = $(this).data('read-url');
    request.doPost({
      url: readUrl,
      callback: function callback() {
        var $spanTotalNoti = $('.span-notification-indicator');
        var totalNotification = $spanTotalNoti.text();
        totalNotification = totalNotification !== '' ? parseInt(totalNotification) - 1 : '';

        if (totalNotification === '' || totalNotification === 0) {
          $spanTotalNoti.hide();
        } else {
          $spanTotalNoti.show().text(totalNotification);
        }

        $(_this).addClass('kt-notification__item--read');
      }
    });
  });
});

/***/ }),

/***/ "867224ff66af7684ef4c":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "b1b44e1eb764ab106a17":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "f64b1d314d6045d2a6b9":
/***/ (function(module, exports, __webpack_require__) {

/* eslint-disable no-undef */
$(function () {
  $$.init();
  $('input').each(function () {
    if (!$(this).attr('placeholder')) {
      $(this).attr('placeholder', __('Please input data'));
    }
  });
  var $body = $('body');
  $body.on('click', '.alert-close .close', function () {
    window.events.$emit('hide');
  });
  $body.on('changeDate', '#txt_from_date', function (selected) {
    var fromDateUnix = selected.date.valueOf();
    var minDate = new Date(fromDateUnix);
    $('#txt_to_date').datepicker('setStartDate', minDate);
    var toDateVal = $('#txt_to_date').val();

    if (toDateVal) {
      var toDateUnix = moment(toDateVal, 'DD-MM-YYYY').unix() * 1000;

      if (toDateUnix < fromDateUnix) {
        $('#txt_to_date').val($('#txt_from_date').val());
      }
    }

    $(this).datepicker('hide');
  });
  $body.on('click', '#btn_logout', function () {
    var form = $(this).next();
    $(form).submit();
  });
  $body.on('click', '#link_form_change_password', function () {
    var url = $(this).data('url');
    $('#modal_md').showModal({
      url: url
    });
  });
  $('.modal').on('show.bs.modal', function () {
    $(this).addClass('modal-brand').show(); // $('select').on('select2:open', function() {
    // 	$('.select2-search input').prop('focus', 0)
    // })
  });
  $('form').on('change', 'select', function () {
    $(this).valid();
  });
  $('form').on('click', '#link_back', function (e) {
    var _this = this;

    var shouldConfirm = $(this).data('should-confirm');
    e.preventDefault();

    if (shouldConfirm) {
      $(this).swal(function (result) {
        if (result.value) {
          location.href = $(_this).attr('href');
        }

        window.unblock();
      }, {
        type: 'question',
        title: __('You have not saved the information!!!')
      });
    } else {
      location.href = $(this).attr('href');
    }
  });

  if (typeof KTUtil !== 'undefined' && KTUtil.isMobileDevice()) {
    $('select').on('select2:open', function () {
      $('.select2-search input').prop('focus', 0);
    });
  }
}); // require('./components/quicksearch')

__webpack_require__("6046c90b89c04273b493");

/***/ })

/******/ });