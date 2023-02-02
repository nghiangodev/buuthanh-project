let initSelect2 = function() {
	if (typeof $.fn.select2 === 'function') {
		let language = $('html').attr('lang')

		let viObj = {
			inputTooLong: function(args) {
				const overChars = args.input.length - args.maximum

				return 'Vui lòng xóa bớt ' + overChars + ' ký tự'
			},
			inputTooShort: function(args) {
				const remainingChars = args.minimum - args.input.length

				return 'Vui lòng nhập thêm từ ' + remainingChars +
					' ký tự trở lên'
			},
			loadingMore: function() {
				return 'Đang lấy thêm kết quả…'
			},
			maximumSelected: function(args) {
				return 'Chỉ có thể chọn được ' + args.maximum + ' lựa chọn'
			},
			noResults: function() {
				return 'Không tìm thấy kết quả'
			},
			searching: function() {
				return 'Đang tìm…'
			},
			removeAllItems: function() {
				return 'Xóa tất cả các mục'
			},
		}

		let enObj = {
			errorLoading: function() {
				return 'The results could not be loaded.'
			},
			inputTooLong: function(args) {
				const overChars = args.input.length - args.maximum

				let message = 'Please delete ' + overChars + ' character'

				if (overChars !== 1) {
					message += 's'
				}

				return message
			},
			inputTooShort: function(args) {
				const remainingChars = args.minimum - args.input.length

				return 'Please enter ' + remainingChars + ' or more characters'
			},
			loadingMore: function() {
				return 'Loading more results…'
			},
			maximumSelected: function(args) {
				let message = 'You can only select ' + args.maximum + ' item'

				if (args.maximum !== 1) {
					message += 's'
				}

				return message
			},
			noResults: function() {
				return 'No results found'
			},
			searching: function() {
				return 'Searching…'
			},
			removeAllItems: function() {
				return 'Remove all items'
			},
		}

		let chooseText = __('Choose')
		//Select2 default config
		$.extend(true, $.fn.select2.defaults.defaults, {
			width: '100%',
			allowClear: true,
			placeholder: chooseText,
			language: language === 'vi' ? viObj : enObj,
		})
		$('.select2').each(function() {
			let allowClear = $(this).data('allow-clear')

			if (allowClear !== undefined) {
				$(this).select2({
					allowClear,
				})
			} else {
				$(this).select2()
			}
		})

		/**
		 * Khai báo sử dụng select2 ajax
		 * @param options
		 * options: {
		 *     url: đường dẫn gọi ajax,
		 *     column: giá tri muốn hiển thị (default là name hoặc code),
		 *     allowClear: thuộc tính clear select (default là true),
		 *     data: function(q): hàm truyền tham số
		 * }
		 * @returns {*|void}
		 */
		$.fn.select2Ajax = function(options = {}) {
			let url = $(this).data('url')
			let col = $(this).data('column')

			let columnOpt = options.hasOwnProperty('column') ? options.column : ''

			let finalUrl = url || options.url
			let column = columnOpt || col

			let settings = {
				ajax: {
					url: finalUrl,
					dataType: 'json',
					delay: 50,
					data: function(params) {
						let paramFinal = {
							query: params.term, // search term
							page: params.page,
						}
						if (typeof options.data === 'function') {
							options.data(params)
							_.assign(paramFinal, params)
						}
						return paramFinal
					},
					transport: function(params, success, failure) {
						request.doGet({
							url: params.url,
							params: params.data,
						}).then(success).catch(failure)
					},
					processResults(data, params) {
						params.page = params.page || 1
						// noinspection JSUnresolvedVariable
						return {
							results: data.items,
							pagination: {
								more: (params.page * 10) <= data.total_count,
							},
						}
					},
					cache: true,
				},
				escapeMarkup: markup => markup,
				allowClear: options.allowClear !== undefined ? options.allowClear : true,
				minimumInputLength: options.hasOwnProperty('minimumInputLength') ? options.minimumInputLength : 0,
				maximumSelectionLength: options.hasOwnProperty('maximumSelectionLength') ? options.maximumSelectionLength : 0,
				templateResult: options.hasOwnProperty('templateResult') ? options.templateResult : function(repo) {
					if (repo.loading) {
						return repo.text
					}
					if (column !== '' && typeof repo[column] !== 'undefined') {
						return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo[column]} </div>`
					}
					if (typeof repo['name'] !== 'undefined') {
						return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo['name']} </div>`
					}
					if (typeof repo['code'] !== 'undefined') {
						return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo['code']} </div>`
					}
				},
				templateSelection: options.hasOwnProperty('templateSelection') ? options.templateSelection : function(repo) {
					let val = repo.text
					if (column !== '' && typeof repo[column] !== 'undefined') {
						val = repo[column]
					} else if (typeof repo.code !== 'undefined') {
						val = repo['code']
					} else if (typeof repo.name !== 'undefined') {
						val = repo['name']
					}
					return val
				},
			}

			if ($(this).prop('multiple')) {
				let tags = $(this).data('tags') || options.tags

				settings = {
					...settings, ...{
						tags: tags != null,
						tokenSeparators: [','],
						minimumInputLength: 1,
					},
				}
				// settings.createTag = function(params) {
				// 	let term = params.term
				// 	if (term.indexOf('%') === -1) {
				// 		term = `%${term}%`
				// 	}
				//
				// 	let values = $(this.$element).val()
				// 	if (values.includes(term)) {
				// 		return null
				// 	}
				//
				// 	return {
				// 		id: term,
				// 		text: term,
				// 	}
				// }
			}

			return this.select2(settings)
		}

		const $select2Ajax = $('.select2-ajax')
		if ($select2Ajax.length > 0) {
			$select2Ajax.each(function() {
				let isUnique = $(this).data('unique') || true
				if (isUnique || $(this).prop('multiple')) {
					$(this).select2Ajax({
						data: q => {
							q.excludeIds = $(this).val()
						},
					})
				} else {
					$(this).select2Ajax()
				}
			})
		}
	}
}

module.exports = initSelect2