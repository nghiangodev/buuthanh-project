let initHighcharts = function() {
	if (typeof Highcharts === 'object') {
		const options = {
			chart: {
				style: {
					fontFamily: 'Montserrat',
					fontWeight: 'bold',
				},
			},
			credits: {
				enabled: false,
			},
		}

		Highcharts.setOptions(options)
	}
}

module.exports = initHighcharts