let initCleave = function() {
	if (typeof Cleave === 'function') {
		if ($('.text-numeric').length > 0) {
			$('.text-numeric').each(function() {
				new Cleave(this, {
					numeral: true,
				});
			})
		}
		if ($('.text-only-numeric').length > 0) {
			$('.text-only-numeric').each(function() {
				new Cleave(this, {
					numeral: true,
					numeralThousandsGroupStyle: 'none',
				})
			})
		}
		if ($('.text-quantity').length > 0) {
			$('.text-quantity').each(function() {
				new Cleave(this, {
					numeral: true,
					numeralIntegerScale: 5,
					numeralPositiveOnly: true,
					numeralDecimalScale: 0
				})
			})
		}
		if ($('.text-money').length > 0) {
			$('.text-money').each(function() {
				new Cleave(this, {
					numeral: true,
					numeralIntegerScale: 12,
					numeralPositiveOnly: true,
				})
			})
		}
	}
}

module.exports = initCleave