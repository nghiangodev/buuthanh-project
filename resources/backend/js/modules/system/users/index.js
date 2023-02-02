window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	const $modalLg = $('#modal_lg')
	const $body = $('body')
	const tableUser = $('#table_users').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('users.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#users_search_form').serializeArray())
			},
		}),
		'conditionalPaging': true,
		'columnDefs': [
			{
				'targets': [0],
				'width': '5%',
				'className': 'dt-center all',
			},
			{
				'targets': [-1],
				'className': 'dt-right all nowrap-col',
			},
		],
	})
	$body.on('click', '.btn-action-delete', function() {
		tableUser.actionDelete({
			btnDelete: $(this),
		})
	})
	$body.on('click', '.btn-action-change-state', function() {
		let message = $(this).data('message')
		tableUser.actionEdit({
			btnEdit: $(this),
			params: {
				state: $(this).data('state'),
			},
			message,
		})
	})
	$body.on('click', '.btn-reset-default-password', function() {
		tableUser.actionEdit({btnEdit: $(this)})
	})
	//note: Tìm kiếm
	$('#users_search_form').on('submit', function() {
		tableUser.reloadTable()
		return false
	})

	$('.btn-refresh-table, #btn_reset_filter').on('click', function(e) {
		e.stopPropagation()

		$('#users_search_form').resetForm()
		tableUser.reloadTable()
	})
	//note: form cập nhật nhiều dòng
	$modalLg.on('shown.bs.modal', function() {
		$('.select').select2()
	})
	$body.on('submit', '#users_form', function() {
		KTApp.block('.modal')
		let ids = $('.kt-checkbox--single > input[type=\'checkbox\']:checked').getValue().join(',')
		if (ids.length > 0) {
			let url = $(this).prop('action')
			// noinspection JSCheckFunctionSignatures
			let formData = new FormData($(this)[0])

			formData.append('ids', ids)

			$(this).submitData({url: url, formData: formData}).then(() => {
				tableUser.reloadTable()
				$('#modal_lg').modal('hide')
			})
		}

		return false
	})

	//note: thao tác nhanh
	$('#link_delete_selected_rows').on('click', function() {
		let ids = $('.kt-checkbox--single > input[type=\'checkbox\']:checked').getValue()
		if (ids.length > 0) {
			tableUser.actionDelete({
				btnDelete: $(this),
				params: {
					ids: ids,
				},
			})
		}
	})
	$('#link_edit_selected_rows').on('click', function() {
		let ids = $('.kt-checkbox--single > input[type=\'checkbox\']:checked').getValue()
		if (ids.length > 0) {
			let editUrl = $(this).data('url')

			$modalLg.showModal({url: editUrl})
		}
	})
})