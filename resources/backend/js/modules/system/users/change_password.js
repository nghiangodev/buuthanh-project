$(function() {
	$('body').on('submit', '#form_change_password', function(e) {
		e.preventDefault()

		let url = $(this).attr('action')
		// noinspection JSCheckFunctionSignatures
		let params = new FormData($(this)[0])
		KTApp.block(this)

		request.doPost({
			url, params, callback: data => {
				$('#modal_md').modal('hide')

				flash({message: data.message})
			},
		}).finally(() => KTApp.unblock(this))
	})

	new Vue({
		el: '#form_change_password',
	})
})