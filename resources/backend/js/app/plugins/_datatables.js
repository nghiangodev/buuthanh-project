let initDatatable = function() {
	if (typeof $.fn.dataTable === 'function') {
		let language = $('html').attr('lang')
		let optionLang = {
			'sLengthMenu': `
				<select class="kt_selectpicker" data-width="85px">
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
				</select>`,
			'sSearch': 'Search:',
			'oPaginate': {
				'sFirst': '<i class="far fa-angle-double-left"></i>',
				'sPrevious': '<i class="far fa-angle-left"></i>',
				'sNext': '<i class="far fa-angle-right"></i>',
				'sLast': '<i class="far fa-angle-double-right"></i>',
			},
			'sEmptyTable': 'No data available',
			'sProcessing': 'Loading...',
			'sZeroRecords': 'No matching records found',
			'sInfo': 'Showing _START_ to _END_ of _TOTAL_ entries',
			'sInfoEmpty': 'Showing 0 to 0 of 0 entries',
			'sInfoFiltered': '(filtered from _MAX_ total entries)',
			'sInfoPostFix': '',
			'sUrl': '',
		}
		if (language === 'vi') {
			optionLang = {
				'sEmptyTable': 'Không có dữ liệu',
				'sProcessing': 'Đang xử lý...',
				sLengthMenu: `
					<select class="kt_selectpicker" data-width="85px">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
					</select>`,
				'sZeroRecords': 'Không tìm thấy dữ liệu phù hợp',
				'sInfo': 'Đang xem _START_ đến _END_ trên _TOTAL_ mục',
				'sInfoEmpty': 'Đang xem 0 đến 0 trong tổng số 0 mục',
				'sInfoFiltered': '(được lọc từ _MAX_ dòng)',
				'sInfoPostFix': '',
				'sSearch': 'Tìm:',
				'sUrl': '',
				'oPaginate': {
					'sFirst': '<i class="far fa-angle-double-left"></i>',
					'sPrevious': '<i class="far fa-angle-left"></i>',
					'sNext': '<i class="far fa-angle-right"></i>',
					'sLast': '<i class="far fa-angle-double-right"></i>',
				},
			}
		}
		$.extend(true, $.fn.dataTable.defaults, {
			'oLanguage': optionLang,
			'info': true,
			'searching': false,
			'columnDefs': [
				{
					'targets': [0],
					'width': '5%',
					'className': 'dt-center all',
				},
				{
					'targets': [-1],
					'className': 'dt-right all nowrap-col',
				},
			],
			'dom': 'rt<"bottom"ilp>',
			'order': [],
			'ordering': false,
			'iDisplayLength': 10,
			'autoWidth': true,
			'processing': false,
			'paging': false,
			'searchDelay': 500,
			'pagingType': KTUtil.isMobileDevice() ? 'simple_numbers' : 'full_numbers',
			'responsive': true,
			'lengthChange': true,
			'conditionalPaging': true,
			buttons: ['excelHtml5', 'pdfHtml5'],
		})

		$.fn.dataTable.pipeline = function(opts) {
			// Configuration options
			const conf = $.extend({
				pages: 5, // number of pages to cache
				url: '', // script url
				data: null, // function or object with parameters to send to the server
				// matching how `ajax.data` works in DataTables
				method: 'POST', // Ajax HTTP method
			}, opts)
			// Private variables for storing the cache
			let cacheLower = -1
			let cacheUpper = null
			let cacheLastRequest = null
			let cacheLastJson = null
			return function(request, drawCallback, settings) {
				let ajax = false
				let requestStart = request.start
				const drawStart = request.start
				let requestLength = request.length
				if (requestLength < 0) {
					requestLength = 50
				}
				const requestEnd = requestStart + requestLength
				if (settings.clearCache) {
					// API requested that the cache be cleared
					ajax = true
					settings.clearCache = false
				} else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
					// outside cached data - need to make a request
					ajax = true
				} else if (JSON.stringify(request.order) !==
					JSON.stringify(cacheLastRequest.order) || JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
					JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
				) {
					// properties changed (ordering, columns, searching)
					ajax = true
				}
				// Store the request for checking next time around
				cacheLastRequest = _.merge({}, request)
				if (ajax) {
					// Need data from the server
					if (requestStart < cacheLower) {
						requestStart = requestStart - (requestLength * (conf.pages - 1))
						if (requestStart < 0) {
							requestStart = 0
						}
					}
					cacheLower = requestStart
					cacheUpper = requestStart + (requestLength * conf.pages)
					request.start = requestStart
					request.length = requestLength * conf.pages
					// Provide the same `data` options as DataTables.
					if (typeof conf.data === 'function') {
						// As a function it is executed with the data object as an arg
						// for manipulation. If an object is returned, it is used as the
						// data object to submit
						const d = conf.data(request)
						if (d) {
							_.assign(request, d)
						}
					} else if (isPlainObject(conf.data)) {
						// As an object, the data given extends the default
						_.assign(request, conf.data)
					}
					settings.jqXHR = $.ajax({
						'type': conf.method,
						'url': conf.url,
						'data': request,
						'dataType': 'json',
						'cache': false,
						'success': function(json) {
							cacheLastJson = _.merge({}, json)
							// noinspection EqualityComparisonWithCoercionJS
							if (cacheLower != drawStart) {
								json.data.splice(0, drawStart - cacheLower)
							}
							if (requestLength > -1) {
								json.data.splice(requestLength, json.data.length)
							}
							drawCallback(json)
						},
						'error': function(jqXHR) {
							let status = jqXHR.status
							if (status === 419 || status === 401) {
								window.error({text: __('Login session has expired. Please log in again.'), callback: () => location.reload()})
							}
							if (status === 500) {
								window.error({text: __('Whoops, something went wrong on our servers.'), callback: () => {}})
							}
						},
					})
				} else {
					// let json = $.extend(true, {}, cacheLastJson)
					let json = _.merge({}, cacheLastJson)
					json.draw = request.draw // Update the echo for each response
					json.data.splice(0, requestStart - cacheLower)
					json.data.splice(requestLength, json.data.length)
					drawCallback(json)
				}
			}
		}

		/**
		 * @memberOf $.fn.dataTable.Api
		 */
		const clearPipline = function() {
			return this.iterator('table', function(settings) {
				settings.clearCache = true
			})
		}
		$.fn.dataTable.Api.register('clearPipeline()', clearPipline)

		/**
		 * @memberOf $.fn.dataTable.Api
		 */
		const reloadTable = function() {
			return this.clearPipeline().draw()
		}
		$.fn.dataTable.Api.register('reloadTable()', reloadTable)

		/**
		 * @memberOf $.fn.dataTable.Api
		 */
		const exportExcel = function() {
			return this.buttons(0).trigger()
		}
		$.fn.dataTable.Api.register('exportExcel()', exportExcel)

		/**
		 * @memberOf $.fn.dataTable.Api
		 */
		const exportPdf = function() {
			return this.buttons(1).trigger()
		}
		$.fn.dataTable.Api.register('exportPdf()', exportPdf)

		/**
		 * @method
		 * @memberOf $.fn.dataTable.Api
		 * @param btnDelete
		 * @param message
		 * @param title
		 * @param params
		 */
		const actionDelete = function actionDelete({btnDelete, message = __('Do you want to continue?'), title = __('Delete data !!!'), params = {}} = {}) {
			let table = this
			let url = btnDelete.data('url')
			if (url !== '' && url !== undefined) {
				let checkbox = btnDelete.parents('tr').find('.kt-checkbox--single > [type="checkbox"]')
				let deleteTitle = btnDelete.data('title')
				if (deleteTitle === undefined) {
					deleteTitle = title
				}

				checkbox.prop('checked', 'checked')
				btnDelete.swal(result => {
					if (result.value) {
						request.doDelete({
							url: url, params, callback: data => {
								flash({message: data.message})
								table.reloadTable()
							},
						})
					}
					checkbox.prop('checked', '')
				}, {title: deleteTitle, type: 'error', text: message})
			}
		}
		$.fn.dataTable.Api.register('actionDelete()', actionDelete)

		/**
		 * @method
		 * @memberOf $.fn.dataTable.Api
		 * @param btnEdit
		 * @param redirectTo
		 * @param params
		 * @param message
		 * @param title
		 */
		const actionEdit = function({btnEdit, redirectTo, params = {}, message = __('Do you want to continue?'), title = __('Edit data !!!')} = {}) {
			let table = this
			let url = btnEdit.data('url')
			if (url !== '' && url !== undefined) {
				let checkbox = btnEdit.parents('tr').find('.kt-checkbox--single > [type="checkbox"]')
				let editTitle = btnEdit.data('title')
				if (editTitle === undefined) {
					editTitle = title
				}

				checkbox.prop('checked', 'checked')
				btnEdit.swal(result => {
					if (result.value) {
						request.doPost({
							url, params, callback: data => {
								flash({message: data.message, level: data.level !== undefined ? data.level : 'success'})
								if (redirectTo !== undefined && redirectTo !== '') {
									location.href = redirectTo
								}
								table.reloadTable()
							},
						})
					} else {
						unblock()
					}
					checkbox.prop('checked', '')
				}, {title: editTitle, type: 'warning', text: message})
			}
		}
		$.fn.dataTable.Api.register('actionEdit()', actionEdit)

		/**
		 * Update original input/select on change in child row
		 */
		$.fn.dataTable.Api.register('updateChildRow()', function() {
			let self = this
			const tableSelector = self.context[0].sTableId
			// Update original input/select on change in child row
			$(`#${tableSelector} tbody`).on('keyup change', '.child input, .child select, .child textarea', function() {
				const $el = $(this)
				const rowIdx = $el.closest('ul').data('dtr-index')
				const colIdx = $el.closest('li').data('dtr-index')
				const cell = self.cell({row: rowIdx, column: colIdx}).node()

				$('input, select, textarea', cell).val($el.val())
				if ($el.is(':checked')) {
					$('input', cell).prop('checked', true)
				} else {
					$('input', cell).removeProp('checked')
				}
			})
		})

		$.fn.dataTable.Api.register('removeRow()', function(idx, title) {
			let table = this
			let isHidden = table.responsive.hasHidden()

			window.warning({
				callback: result => {
					if (result.value) {
						table.row(isHidden ? --idx : idx).remove().draw(false)
					} else {
						window.unblock()
					}
				},
				title,
			})
		})

		//conditionalPaging
		$(document).on('init.dt', function(e, dtSettings) {
			$('.kt_selectpicker').selectpicker({
				style: 'btn-light btn-sm',
				width: '65px',
			})

			if (e.namespace !== 'dt') {
				return
			}

			const options = dtSettings.oInit.conditionalPaging

			if (options === true) {
				const api = new $.fn.dataTable.Api(dtSettings)
				const conditionalPaging = function(e) {
					const $pagingContainer = $(api.table().container())
					const $paging = $pagingContainer.find('div.dataTables_paginate'),
						$pagingLength = $pagingContainer.find('div.dataTables_length'),
						pages = api.page.info().pages

					if (e instanceof $.Event) {
						if (pages <= 1) {
							$paging.css('display', 'none')
						} else {
							$paging.css('display', 'block')
							$pagingLength.css('display', 'block')
						}
					} else if (pages <= 1) {
						$paging.css('display', 'none')

						$pagingLength.css('display', 'none')
					}
				}

				conditionalPaging()

				api.on('draw.dt', conditionalPaging)
			}
		})

		$(document).on('preXhr.dt', function() {
			blockPage()
		})

		$(document).on('xhr.dt', function() {
			unblock()
		})

		const $datatables = $('.datatables')
		if ($datatables.length > 0) {
			$datatables.DataTable({
				paging: true,
				conditionalPaging: true,
				'columnDefs': [
					{
						'targets': '_all',
						'searchable': true,
						'orderable': true,
						'visible': true,
					}, {
						'targets': [-1],
						'searchable': false,
						'orderable': false,
						'visible': true,
					},
				],
			})
		}
	}
}

module.exports = initDatatable