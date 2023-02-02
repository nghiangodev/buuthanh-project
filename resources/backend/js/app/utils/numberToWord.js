'use strict'

const DICTIONARY = {
	0: 'không',
	1: 'một',
	2: 'hai',
	3: 'ba',
	4: 'bốn',
	5: 'năm',
	6: 'sáu',
	7: 'bảy',
	8: 'tám',
	9: 'chín',
	10: 'mười',
	11: 'mười một',
	12: 'mười hai',
	13: 'mười ba',
	14: 'mười bốn',
	15: 'mười năm',
	16: 'mười sáu',
	17: 'mười bảy',
	18: 'mười tám',
	19: 'mười chín',
	20: 'hai mươi',
	30: 'ba mươi',
	40: 'bốn mươi',
	50: 'năm mươi',
	60: 'sáu mươi',
	70: 'bảy mươi',
	80: 'tám mươi',
	90: 'chín mươi',
	100: 'trăm',
	1000: 'nghìn',
	1000000: 'triệu',
	1000000000: 'tỷ',
	1000000000000: 'nghìn', //ngìn tỷ
	1000000000000000: 'triệu',
	1000000000000000000: 'tỷ tỷ',
}
const seperator = ' '

const isSafeNumber = value => {return typeof value === 'number' && Math.abs(value) <= 9007199254740991}
const log = (n, base) => Math.log(n) / Math.log(base)

const numberToWord = function numberToWord($number) {
	// $number = numeral($number).value()

	if (!isSafeNumber($number)) {
		return false
	}

	if ($number < 0) {
		return 'Âm ' + numberToWord(Math.abs($number))
	}

	return processNumber($number.toString())
}

function processNumber($number) {
	let fraction = '', string = ''
	if ($number.includes('.')) {
		[$number, fraction] = $number.split('.')
	}

	switch (true) {
		case $number < 21:
			string = DICTIONARY[$number]
			break
		case $number < 100:
			string = generateOnes($number)
			break
		case $number < 1000:
			string = generateHundred($number)
			break
		default:
			string = generateBeyondThoundsand($number)
			break
	}

	if (fraction) {
		string += ' phẩy '
		let words = []
		let fractions = fraction.split()
		for (const fractionElement of fractions) {
			words.push(DICTIONARY[fractionElement])
		}
		string += implode(' ', words)
	}

	return string
}

function generateOnes($number) {
	let tens = (+(Math.floor($number / 10))) * 10
	let units = $number % 10
	let string = DICTIONARY[tens]
	if (units) {
		let tmpText = `${seperator}${DICTIONARY[units]}`
		if (units === 1) {
			tmpText = `${seperator}mốt`
		} else if (units === 5) {
			tmpText = `${seperator}lăm`
		}
		string += tmpText
	}

	return string
}

function generateHundred($number) {
	let hundreds = Math.floor($number / 100)
	let remainder = $number % 100
	let string = `${DICTIONARY[hundreds]} ${DICTIONARY[100]}`
	if (remainder) {
		let tmpText = seperator + numberToWord(remainder)
		if (remainder < 10) {
			tmpText = seperator + 'lẻ ' + numberToWord(remainder)
		} else if (remainder % 10 === 5) {
			tmpText = seperator + numberToWord(remainder - 5) + ' lăm'
		}

		string += tmpText
	}

	return string
}

function generateBeyondThoundsand($number) {
	let $baseUnit = 1000 ** Math.floor(log($number, 1000))
	let $numBaseUnits = +(Math.floor($number / $baseUnit))
	let $remainder = $number % $baseUnit
	let $hundredRemainder = (Math.floor($remainder / $baseUnit)) * 1000

	let string = numberToWord($numBaseUnits) + ' ' + DICTIONARY[$baseUnit]
	if ($remainder < 100 && $remainder > 0) {
		string = numberToWord($numBaseUnits) + ' ' + DICTIONARY[$baseUnit] + ' không trăm'
		if ($remainder < 10) {
			string = numberToWord($numBaseUnits) + ' ' + DICTIONARY[$baseUnit] + ' không trăm lẻ'
		}
	} else if ($hundredRemainder > 0 && $hundredRemainder < 100) {
		string = numberToWord($numBaseUnits) + ' ' + DICTIONARY[$baseUnit] + ' không trăm'
		if ($hundredRemainder < 10) {
			string = numberToWord($numBaseUnits) + ' ' + DICTIONARY[$baseUnit] + ' không trăm lẻ'
		}
	}

	if ($remainder) {
		string += seperator + numberToWord($remainder)
	}

	return string
}

module.exports = numberToWord