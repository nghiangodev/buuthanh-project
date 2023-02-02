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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("80e756e3feee659ef921");


/***/ }),

/***/ "80e756e3feee659ef921":
/***/ (function(module, exports) {

window.vueApp = new Vue({
  el: '#app'
});
$(function () {
  var $userForm = $('#users_form');
  var isConfirm = $userForm.data('confirm');
  var isAjax = $userForm.data('ajax');
  $userForm.validate({
    // define validation rules
    rules: {
      password: {
        pwCheck: function pwCheck() {
          return $('#txt_password').val() !== '';
        },
        required: function required() {
          var userId = $('#txt_user_id').val();
          return userId === '';
        }
      },
      password_confirmation: {
        required: function required() {
          return $('#txt_password').val() !== '';
        },
        equalTo: '#txt_password'
      },
      email: {
        email: function email() {
          return $('#txt_email').val() !== '';
        }
      },
      'otp_type[]': {
        required: function required() {
          return $('#select_use_otp').val() === '1';
        }
      },
      'subscribe_type[]': {
        required: function required() {
          return $('#select_subscribe').val() === '1';
        }
      }
    },
    messages: {
      password: {
        require: __('This field is required.')
      },
      password_confirmation: __('passwords.same_password'),
      'otp_type[]': __('Please select a method'),
      'subscribe_type[]': ['Please select a method']
    },
    submitHandler: isAjax && function (form, e) {
      window.blockPage();
      e.preventDefault();

      function save() {
        var avatar = vueApp.$children[3].$refs.pond.getFile();
        var formData = new FormData(form);

        if (avatar) {
          var fileToUpload = avatar.file;
          var isFileObject = fileToUpload instanceof File;

          if (!isFileObject) {
            fileToUpload = new File([fileToUpload], fileToUpload.name, {
              lastModified: fileToUpload.lastModified
            });
          }

          formData.append('file_avatar', fileToUpload);
        }

        $(form).submitData({
          returnEarly: true,
          formData: formData
        }).then(function (data) {
          var msg = data.message;
          var redirectUrl = data.redirect_url;

          if (redirectUrl !== undefined) {
            window.success({
              text: msg,
              callback: function callback() {
                return location.href = redirectUrl;
              }
            });
          }
        });
      }

      if (isConfirm) {
        $(form).swal(function (result) {
          if (result.value) {
            save();
          }
        });
      } else {
        save();
      }
    }
  });
  $('#select_use_otp').on('change', function () {
    var value = $(this).val();
    var $otpTypeSection = $('#otp_type_section');

    if (value && value === '1') {
      $otpTypeSection.removeClass('d-none');
    } else {
      $otpTypeSection.addClass('d-none');
    }
  });
  $('#select_subscribe').on('change', function () {
    var value = $(this).val();
    var $subscribeTypeSection = $('#subscribe_type_section');

    if (value && value === '1') {
      $subscribeTypeSection.removeClass('d-none');
    } else {
      $subscribeTypeSection.addClass('d-none');
    }
  });
});

/***/ })

/******/ });