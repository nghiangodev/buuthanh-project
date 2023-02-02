window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	const $app = $('#app')
	const tableLog = $('#table_logs').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('activity_logs.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#logs_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		lengthChange: true,
		'columnDefs': [
			{
				'targets': [0],
				'searchable': false,
				'sortable': false,
				'orderable': false,
				'visible': true,
				'width': '5%',
			},
			{
				'targets': [-1],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'className': 'dt-left all',
				'width': '5%',
			},
		],
	})

	$app.on('click', '.btn-action-view', function() {
		let url = $(this).data('url')

		$('#modal_lg').showModal({url})
	})
	$('#logs_search_form').on('submit', function() {
		tableLog.reloadTable()
		return false
	})
	$('.btn-refresh-table, #btn_reset_filter').on('click', function(e) {
		e.stopPropagation()

		$('#logs_search_form').resetForm()
		tableLog.reloadTable()
	})

	$('#select_caused_by').select2Ajax({
		data(q) {
			q.withAdmin = true
		}
	})
})