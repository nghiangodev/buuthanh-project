window.vueApp = new Vue({
	el: '#app',
})

$(function() {
    const $body = $('body')
    const tableNumberal = $('#table_numberals').DataTable({
        'serverSide': true,
        'paging': true,
        'ajax': $.fn.dataTable.pipeline({
            url: route('numberals.table', {}, false),
            data: function(q) {
                q.filters = JSON.stringify($('#numberals_search_form').serializeArray())
            },
        }),
        'conditionalPaging': true
    })
    $body.on('click', '.btn-action-delete', function () {
        tableNumberal.actionDelete({btnDelete: $(this)})
    })

    //note: Tìm kiếm
    $('#numberals_search_form').on('submit', function() {
        tableNumberal.reloadTable()
        return false
    })
    $('.btn-refresh-table, #btn_reset_filter').on('click', function(e) {
        e.stopPropagation()

        $('#numberals_search_form').resetForm()
        tableNumberal.reloadTable()
    })

    //note: thao tác nhanh, nếu có sử dụng checkbox thì uncomment
    // $('#link_delete_selected_rows').on('click', function() {
    //     let ids = $(".kt-checkbox--single > input[type='checkbox']:checked").getValues()
    //
    //     if (ids.length > 0) {
    //         tableNumberal.actionDelete({btnDelete: $(this), params: {ids: ids}})
    //     }
    // })
})
