$(function () {
	$('#btn_refresh').click(function () {
		$.ajax({
			type: 'GET',
			url: 'refreshcaptcha',
			success: function (data) {
				$('.span-captcha').html(data.captcha)
			},
		})
	})
})