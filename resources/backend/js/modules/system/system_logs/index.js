$(function() {
	let $body = $('body')

	let tableLogs = $('#table_system_logs').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('system_logs.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#system_logs_search_form').serializeArray())
			},
		}),
		'columnDefs': [
			{
				'targets': [-1],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'className': 'dt-left',
				'width': '8%',
			},
		],
	})
	$('.btn-refresh-table, #btn_reset_filter').on('click', function(e) {
		e.stopPropagation()

		$('#system_logs_search_form').resetForm()
		tableLogs.reloadTable()
	})

	$body.on('submit', '#system_logs_search_form', function() {
		tableLogs.reloadTable()
		return false
	})
	$body.on('click', '.btn-action-view', function() {
		let url = $(this).data('url')
		let text = $(this).parent().find('.txt-content').val()
		let stack = $(this).parent().find('.txt-stack').val()

		$('#modal_lg').showModal({
			url, method: 'post', params: {
				content: text,
				stack: stack,
			},
		})

		// return request.doPost({
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
	})
})