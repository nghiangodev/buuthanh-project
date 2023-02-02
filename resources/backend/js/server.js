const SERVER_PORT = 8080
const http = require('http')

const express = require('express')
const app = express()

const server = http.Server(app)
const io = require('socket.io').listen(server)

const redis = require('redis')
const ioredis = require('socket.io-redis')

// Multi-server socket handling allowing you to scale horizontally 
// or use a load balancer with Redis distributing messages across servers.
io.adapter(ioredis({host: 'localhost', port: 6379}))

//

/*
 * Redis pub/sub
 */

// Listen to local Redis broadcasts
const sub = redis.createClient()

sub.on('error', function(error) {
	console.log('ERROR ' + error)
})

sub.on('subscribe', function(channel, count) {
	console.log('SUBSCRIBE', channel, count)
})

// Handle messages from channels we're subscribed to
sub.on('message', function(channel, payload) {
	console.log('INCOMING MESSAGE', channel, payload)

	payload = JSON.parse(payload)

	// Merge channel into payload
	payload.data._channel = channel

	// Send the data through to any client in the channel room (!)
	// (i.e. server room, usually being just the one user)
	io.sockets.in(channel).emit(payload.event, payload.data)
	// io.emit(payload.event, payload.data)
})

/*
 * Server
 */

// Start listening for incoming client connections
io.sockets.on('connection', function(socket) {

	console.log('NEW CLIENT CONNECTED')

	socket.on('subscribe-to-channel', function(data) {
		console.log('SUBSCRIBE TO CHANNEL', data)

		// Subscribe to the Redis channel using our global subscriber
		sub.subscribe(data.channel)

		// Join the (somewhat local) server room for this channel. This
		// way we can later pass our channel events right through to
		// the room instead of broadcasting them to every client.
		socket.join(data.channel)
	})

	socket.on('unsubscribe-to-channel', function(data) {
		console.log('UNSUBSCRIBE TO CHANNEL', data)

		// Unsubscribe to the Redis channel using our global subscriber
		sub.unsubscribe(data.channel)
	})

	socket.on('disconnect', function() {
		console.log('DISCONNECT')
	})

	socket.on('message', function() {
		console.log('message')
	})

})

// Start listening for client connections
server.listen(SERVER_PORT, function() {
	console.log('Listening to incoming client connections on port ' + SERVER_PORT)
})