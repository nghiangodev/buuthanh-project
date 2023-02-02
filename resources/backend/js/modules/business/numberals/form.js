window.vueApp = new Vue({
    el: '#app',
})

$(function() {
    const $numberalForm = $('#numberals_form')
    const isConfirm = $numberalForm.data('confirm')
    const isAjax = $numberalForm.data('ajax')
    const $body = $('body')

    let initRowDetailPlugin = function() {
        $('.select-row-unit').last().select2Ajax()

        window.$$.handleCleave()
    }

    let tableItemCat = $('#table_item_cat').DataTable({
        respnsive: true,
        scrollY: 360,
        paging: false,
        conditionalPaging: true,
        scrollCollapse: true,
        columnDefs: [
            {
                targets: [1],
                className: 'editable dt-center',
            },
            {
                targets: [2],
                className: 'editable dt-center',
            },
            {
                targets: [3],
                className: 'dt-center',
            },
            {
                targets: [4],
                'width': '20%',
                className: '',
            },
            {
                targets: [6],
                className: 'dt-right',
            },
        ],
    }).on('draw.dt', function() {
        tableItemCat.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            cell.innerHTML = (tableItemCat.page.info().page * 10) + i + 1
        })
    })

    $numberalForm.validate({
        submitHandler: isAjax && function(form, e) {
            if (tableItemCat.data().length <= 0 || tableItemCat.data().length > 20) {
                flash({message: __('Please input data more than 1 or less than 20 into table'), level: 'danger'})
                return false
            }

            window.blockPage()
            e.preventDefault()

            function save() {
                let formData = new FormData(form)

                $(form).submitData({returnEarly: true, formData}).then(data => {
                        let msg = data.message
                        let redirectUrl = data.redirect_url
                        if (redirectUrl !== undefined) {
                            window.success({text: msg, callback: () => location.href = redirectUrl})
                        }
                    })
                }

                if (isConfirm) {
                    $(form).swal(result => {
                        if (result.value) {
                            save()
                        }
                    })
                } else {
                    save()
                }
            },
        })

        $('#select_gender').select2({
            allowClear: false,
        })

    $('#select_star_resolution').select2Ajax({
        allowClear: false,
    })

    let addClassValid = function(element) {
        let errorMessage = '<span class="text-danger text-error">' + __('This field is required.') + '</span>'

        element.addClass('is-invalid')
        element.parent().append(errorMessage)
    }

    let countAge = function(value) {
        var partOfDobs = value.split('-')
        let currentAge = new Date().getFullYear() - partOfDobs[2]
        return currentAge
    }

    $body.on('change', '#txt_dob', function() {
        $('#txt_age').val(countAge($(this).val()))
    })

    $body.on('change', '.edit-dob', function() {
        $('.edit-age-span').text(countAge($(this).val()))
        $('.edit-age').val(countAge($(this).val()))
    })

    $('#btn_add_item').on('click', function() {
        let starResolution = $('#select_star_resolution').select2('data')[0]
        let fullName = $('#txt_full_name').val()
        let dob = $('#txt_dob').val()
        let age = $('#txt_age').val()
        let gender = $('#select_gender').val()
        let genderText = __('Male')

        $('#form_detail').find('input', 'select', '.text-error').removeClass('is-invalid')
            $('.text-error').remove()
            $('select').parent().find('.text-error').remove()

            if (!$('#txt_full_name').val() || !$('#txt_dob').val() || !$('#select_star_resolution').val()) {
                addClassValid($('#txt_full_name')) || addClassValid($('#txt_dob')) || addClassValid($('#select_star_resolution'))
                return false
            }

            if (gender !== '1') {
                genderText = __('Female')
            }

            let {
                id: starResolutionId, name: starResolutionName,
            } = starResolution

            let rowIndex = tableItemCat.data().length + window.randomInt(100, 999)
            let dataTable = [
                '',
                `<span>${fullName}</span><input class="form-control" type="hidden" value="${fullName}" name="itemCats[${rowIndex}][full_name]">`,
                `<span>${dob}</span><input class="form-control text-datepicker" type="hidden" value="${dob}" name="itemCats[${rowIndex}][dob]">`,
                `<span>${age}</span><input class="form-control edit-age" type="hidden" value="${age}" name="itemCats[${rowIndex}][age]">`,
                // `<span>${starResolutionName}</span><input class="form-control" type="hidden" value="${starResolutionId}" name="itemCats[${rowIndex}][starResolutionId]]">`,
                `<select class="form-control select2-ajax select-row-unit" data-column="name" data-url="${route('numberals.star_resolution_list')}" name="itemCats[${rowIndex}][star_resolution_id]">
				   <option value="${starResolutionId}">${starResolutionName}</option>
			    </select>`,
                `<span>${genderText}</span><input class="form-control" type="hidden" value="${gender}" name="itemCats[${rowIndex}][gender]">`,
                `
                    <button class="btn-action-edit btn-primary btn-edit-item" type="button"><i class="far fa-edit"></i></button>
                    <button class="btn-action-delete btn-danger btn-delete-item" type="button"><i class="far fa-trash"></i></button>
                `,
            ]
        tableItemCat.row.add(dataTable).draw()
        initRowDetailPlugin()
        $('#txt_full_name,#txt_dob').val('').trigger('change').text('')
        $('#select_star_resolution').val('').trigger('change')
        // $('#table_item_cat .select2-container--default').remove()
        // $('#table_item_cat .select2-container--below').remove()

    })

        $body.on('click', '.btn-delete-item', function() {
            let rowIndex = $(this).parents('tr[role="row"]').index()
            if (rowIndex === -1) {
                rowIndex = $(this).parents('.child').prev().index()
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
                        header: 'header-danger',
                    },
                    confirmButtonText: lang['Yes'],
                    cancelButtonText: lang['No'],
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.value) {
                        tableItemCat.row(rowIndex).remove().draw(false)
                    }
                })
            } else {
                tableItemCat.row($(this).parents('tr')).remove().draw()
            }
        })

        $body.on('click', '.btn-edit-item', function() {
            let $tr = $(this).parents('tr')
            if ($(this).hasClass('btn-success')) {
                $tr.find('td.editable').each(function() {
                    let editable = $(this)
                    let inputable = editable.find('input').attr('type', 'hidden')
                    editable.find('span').show().text(inputable.val())
                })
                $(this).removeClass('btn-success').addClass('btn-primary').html(`<i class="far fa-edit"></i>`)
            } else {
                $tr.find('td.editable').each(function() {
                    let editable = $(this)
                    editable.find('span').hide()
                    editable.find('input').attr('type', 'text')
                })
                $(this).removeClass('btn-primary').addClass('btn-success').html(`<i class="far fa-check"></i>`)
            }
        })
    },
)
