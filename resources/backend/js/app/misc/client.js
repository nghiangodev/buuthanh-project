const userId = document.querySelector('meta[name=\'user-id\']').getAttribute('content')
const port = document.querySelector('meta[name=\'socket-port\']').getAttribute('content')
const appName = document.querySelector('meta[name=\'app-name\']').getAttribute('content')
const PRIVATE_CHANNEL = `private-${appName}-user-${userId}`

const io = require('socket.io-client')

const host = window.location.host.split(':')[0]
let uri = port ? '//' + host + `:${port}` : '//' + host
const socket = io.connect(uri, {secure: false, rejectUnauthorized: false})

socket.on('connect', function() {
	console.log('CONNECT')

	socket.on('event', function(data) {
		console.log('EVENT', data)
	})

	socket.on('message', function(data) {
		console.log(data)
		flash({message: data.message, level: data.level})
	})

	socket.on('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
		console.log(data)
		let item = `<a href="javascript:void(0)" class="kt-notification__item">
						<div class="kt-notification__item-icon">
							<i class="flaticon2-line-chart kt-font-success"></i>
						</div>
						<div class="kt-notification__item-details">
							<div class="kt-notification__item-title">
								${data.message}
							</div>
							<div class="kt-notification__item-time">
								${moment(data.notified_at).fromNow()}
							</div>
						</div>
					</a>`

		$('.kt-notification').prepend(item)

		// let $spanTotalNoti = $('.span-total-notification')
		// let totalNotification = $spanTotalNoti.text()
		// $spanTotalNoti.text(totalNotification !== '' ? parseInt(totalNotification) + 1 : 1)

		$('.span-bell-icon').addClass('swing')
		$('.span-notification-indicator').show()

		const audio = new Audio('/audio/ring_bell.mp3')
		audio.play()
	})

	socket.on('disconnect', function() {
		console.log('disconnect')
	})

	// Can be any channel. For private channels, Laravel should pass it upon page load (or given by another user).
	socket.emit('subscribe-to-channel', {channel: PRIVATE_CHANNEL})
})

$('.logout-form').on('submit', function() {
	socket.disconnect()

	socket.emit('unsubscribe-to-channel', {channel: PRIVATE_CHANNEL})
})
