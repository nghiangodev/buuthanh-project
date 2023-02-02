window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	const $app = $('#app')
	const tableRole = $('#table_roles').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('roles.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#roles_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		lengthChange: true,
		'columnDefs': [
			{
				'targets': [0],
				'visible': true,
			},
			{
				'targets': [-1],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'className': 'dt-center',
				'width': '5%',
			},
		],
	})

	$('#roles_search_form').on('submit', function() {
		tableRole.reloadTable()
		return false
	})

	$('.btn-refresh-table, #btn_reset_filter').on('click', function(e) {
		e.stopPropagation()

		$('#roles_search_form').resetForm()
		tableRole.reloadTable()
	})
	$('#link_delete_selected_rows').on('click', function() {
		let ids = $('.kt-checkbox--single > input[type=\'checkbox\']:checked').getValue()

		if (ids.length > 0) {
			tableRole.actionDelete({btnDelete: $(this), params: {ids: ids}})
		}
	})
	$app.on('click', '.btn-action-delete', function() {
		tableRole.actionDelete({btnDelete: $(this)})
	})
	$app.on('click', '.btn-change-status', function() {
		tableRole.actionEdit({btnEdit: $(this), params: {state: $(this).data('state')}})
	})
})