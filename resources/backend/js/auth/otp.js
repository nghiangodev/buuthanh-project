$(function() {
	$('#btn_resend_otp').on('click', function() {
		let url = $(this).data('url')

		window.blockPage()

		window.request.doPost({url}).finally(() => window.unblock())
	})
})