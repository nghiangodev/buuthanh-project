if ($('#txt_quicksearch').length > 0) {
	// eslint-disable-next-line
	const quicksearch = new mQuicksearch('txt_quicksearch', {
		mode: KTUtil.attr('txt_quicksearch', 'm-quicksearch-mode'), // quick search type
		minLength: 1,
	})

	quicksearch.on('search', function(the) {
		the.showProgress()

		_.debounce(() => {
			$.ajax({
				url: '/quicksearch',
				data: {query: the.query},
				dataType: 'html',
				success: function(res) {
					the.hideProgress()
					the.showResult(res)
				},
				error: function(result) {
					the.hideProgress()
					the.showError(result)
				},
			})
		}, 500)()
	})
}
