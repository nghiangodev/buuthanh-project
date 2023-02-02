$(function() {
	let $body = $('body')

	$body.on('click', '.span-bell-icon', function() {
		$(this).removeClass('swing')
	})

	//notification mark done
	$body.on('click', '.notification-section .kt-notification__item', function(e) {
		let readUrl = $(this).data('read-url')
		request.doPost({
			url: readUrl, callback: () => {
				let $spanTotalNoti = $('.span-notification-indicator')
				let totalNotification = $spanTotalNoti.text()
				totalNotification = totalNotification !== '' ? parseInt(totalNotification) - 1 : ''
				if (totalNotification === '' || totalNotification === 0) {
					$spanTotalNoti.hide()
				} else {
					$spanTotalNoti.show().text(totalNotification)
				}

				$(this).addClass('kt-notification__item--read')
			},
		})
	})
})