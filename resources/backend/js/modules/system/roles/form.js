window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	let $roleForm = $('#role_form')
	let isConfirm = $roleForm.data('confirm')
	let isAjax = $roleForm.data('ajax')

	$roleForm.validate({
		submitHandler: isAjax && function(form, e) {
			window.blockPage()
			e.preventDefault()

			function save() {
				$(form).submitData({returnEarly: true}).then(data => {
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
})