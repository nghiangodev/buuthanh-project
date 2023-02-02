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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "66101057796c288d3e00":
/***/ (function(module, exports) {

window.vueApp = new Vue({
  el: '#app'
});
$(function () {
  var $numberalForm = $('#numberals_form');
  var isConfirm = $numberalForm.data('confirm');
  var isAjax = $numberalForm.data('ajax');
  var $body = $('body');

  var initRowDetailPlugin = function initRowDetailPlugin() {
    $('.select-row-unit').last().select2Ajax();
    window.$$.handleCleave();
  };

  var tableItemCat = $('#table_item_cat').DataTable({
    respnsive: true,
    scrollY: 360,
    paging: false,
    conditionalPaging: true,
    scrollCollapse: true,
    columnDefs: [{
      targets: [1],
      className: 'editable dt-center'
    }, {
      targets: [2],
      className: 'editable dt-center'
    }, {
      targets: [3],
      className: 'dt-center'
    }, {
      targets: [4],
      'width': '20%',
      className: ''
    }, {
      targets: [6],
      className: 'dt-right'
    }]
  }).on('draw.dt', function () {
    tableItemCat.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function (cell, i) {
      cell.innerHTML = tableItemCat.page.info().page * 10 + i + 1;
    });
  });
  $numberalForm.validate({
    submitHandler: isAjax && function (form, e) {
      if (tableItemCat.data().length <= 0 || tableItemCat.data().length > 20) {
        flash({
          message: __('Please input data more than 1 or less than 20 into table'),
          level: 'danger'
        });
        return false;
      }

      window.blockPage();
      e.preventDefault();

      function save() {
        var formData = new FormData(form);
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
  $('#select_gender').select2({
    allowClear: false
  });
  $('#select_star_resolution').select2Ajax({
    allowClear: false
  });

  var addClassValid = function addClassValid(element) {
    var errorMessage = '<span class="text-danger text-error">' + __('This field is required.') + '</span>';
    element.addClass('is-invalid');
    element.parent().append(errorMessage);
  };

  var countAge = function countAge(value) {
    var partOfDobs = value.split('-');
    var currentAge = new Date().getFullYear() - partOfDobs[2];
    return currentAge;
  };

  $body.on('change', '#txt_dob', function () {
    $('#txt_age').val(countAge($(this).val()));
  });
  $body.on('change', '.edit-dob', function () {
    $('.edit-age-span').text(countAge($(this).val()));
    $('.edit-age').val(countAge($(this).val()));
  });
  $('#btn_add_item').on('click', function () {
    var starResolution = $('#select_star_resolution').select2('data')[0];
    var fullName = $('#txt_full_name').val();
    var dob = $('#txt_dob').val();
    var age = $('#txt_age').val();
    var gender = $('#select_gender').val();

    var genderText = __('Male');

    $('#form_detail').find('input', 'select', '.text-error').removeClass('is-invalid');
    $('.text-error').remove();
    $('select').parent().find('.text-error').remove();

    if (!$('#txt_full_name').val() || !$('#txt_dob').val() || !$('#select_star_resolution').val()) {
      addClassValid($('#txt_full_name')) || addClassValid($('#txt_dob')) || addClassValid($('#select_star_resolution'));
      return false;
    }

    if (gender !== '1') {
      genderText = __('Female');
    }

    var starResolutionId = starResolution.id,
        starResolutionName = starResolution.name;
    var rowIndex = tableItemCat.data().length + window.randomInt(100, 999);
    var dataTable = ['', "<span>".concat(fullName, "</span><input class=\"form-control\" type=\"hidden\" value=\"").concat(fullName, "\" name=\"itemCats[").concat(rowIndex, "][full_name]\">"), "<span>".concat(dob, "</span><input class=\"form-control text-datepicker\" type=\"hidden\" value=\"").concat(dob, "\" name=\"itemCats[").concat(rowIndex, "][dob]\">"), "<span>".concat(age, "</span><input class=\"form-control edit-age\" type=\"hidden\" value=\"").concat(age, "\" name=\"itemCats[").concat(rowIndex, "][age]\">"), // `<span>${starResolutionName}</span><input class="form-control" type="hidden" value="${starResolutionId}" name="itemCats[${rowIndex}][starResolutionId]]">`,
    "<select class=\"form-control select2-ajax select-row-unit\" data-column=\"name\" data-url=\"".concat(route('numberals.star_resolution_list'), "\" name=\"itemCats[").concat(rowIndex, "][star_resolution_id]\">\n\t\t\t\t   <option value=\"").concat(starResolutionId, "\">").concat(starResolutionName, "</option>\n\t\t\t    </select>"), "<span>".concat(genderText, "</span><input class=\"form-control\" type=\"hidden\" value=\"").concat(gender, "\" name=\"itemCats[").concat(rowIndex, "][gender]\">"), "\n                    <button class=\"btn-action-edit btn-primary btn-edit-item\" type=\"button\"><i class=\"far fa-edit\"></i></button>\n                    <button class=\"btn-action-delete btn-danger btn-delete-item\" type=\"button\"><i class=\"far fa-trash\"></i></button>\n                "];
    tableItemCat.row.add(dataTable).draw();
    initRowDetailPlugin();
    $('#txt_full_name,#txt_dob').val('').trigger('change').text('');
    $('#select_star_resolution').val('').trigger('change'); // $('#table_item_cat .select2-container--default').remove()
    // $('#table_item_cat .select2-container--below').remove()
  });
  $body.on('click', '.btn-delete-item', function () {
    var rowIndex = $(this).parents('tr[role="row"]').index();

    if (rowIndex === -1) {
      rowIndex = $(this).parents('.child').prev().index();
    }

    if ($(this).data('id')) {
      Swal.fire({
        title: lang['Confirm action!!!'],
        text: lang['Do you want to continue?'],
        icon: 'error',
        showCancelButton: true,
        customClass: {
          confirmButton: 'btn btn-danger',
          cancelButton: 'btn btn-outline-hover-danger',
          header: 'header-danger'
        },
        confirmButtonText: lang['Yes'],
        cancelButtonText: lang['No'],
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          tableItemCat.row(rowIndex).remove().draw(false);
        }
      });
    } else {
      tableItemCat.row($(this).parents('tr')).remove().draw();
    }
  });
  $body.on('click', '.btn-edit-item', function () {
    var $tr = $(this).parents('tr');

    if ($(this).hasClass('btn-success')) {
      $tr.find('td.editable').each(function () {
        var editable = $(this);
        var inputable = editable.find('input').attr('type', 'hidden');
        editable.find('span').show().text(inputable.val());
      });
      $(this).removeClass('btn-success').addClass('btn-primary').html("<i class=\"far fa-edit\"></i>");
    } else {
      $tr.find('td.editable').each(function () {
        var editable = $(this);
        editable.find('span').hide();
        editable.find('input').attr('type', 'text');
      });
      $(this).removeClass('btn-primary').addClass('btn-success').html("<i class=\"far fa-check\"></i>");
    }
  });
});

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("66101057796c288d3e00");


/***/ })

/******/ });