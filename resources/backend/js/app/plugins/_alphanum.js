let initAlphanum = function() {
	// noinspection JSUnresolvedVariable
	if (typeof $.fn.alphanum === 'function') {
		$('.text-string').each(function() {
			$(this).alpha({
				maxLength: $(this).attr('maxlength') || 100,
			})
		})

		$('.text-alphanum').each(function() {
			$(this).alphanum({
				allow: '-!@#$%^&*(),./\\',
				maxLength: $(this).attr('maxlength') || 200,
			})
		})

		$('.text-phone').alphanum({
			allowMinus: false,
			allowLatin: false,
			allowSpace: false,
			allowOtherCharSets: false,
			maxLength: 11,
		})
		$('.text-mobile-phone').alphanum({
			allowMinus: false,
			allowLatin: false,
			allowSpace: false,
			allowOtherCharSets: false,
			maxLength: 10,
		})
	}
}

module.exports = initAlphanum