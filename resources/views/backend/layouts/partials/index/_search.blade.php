<div class="accordion accordion-solid accordion-toggle-svg" id="accordion_search">
	<div class="card">
		<div class="card-header" id="heading_search">
			<div class="card-title collapsed p-0" data-toggle="collapse" data-target="#collapse_search" aria-expanded="false" aria-controls="collapse_search">
				<div class="kt-portlet kt-portlet--rounded kt-portlet--collapse shadow-none" data-portlet="true">
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<span class="kt-portlet__head-icon">
								<i class="far fa-search"></i>
							</span>
							<h3 class="kt-portlet__head-title">@lang('Search')</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
							<div class="kt-portlet__head-group">
								<button class="btn btn-outline-hover-brand btn-refresh-table d-none d-sm-inline-block">
									<i class="far fa-undo-alt"></i>
									<span>@lang('Reset')</span>
								</button>
								<button class="btn btn-icon btn-refresh-table d-sm-none">
									<i class="far fa-undo-alt font-weight-bold"></i>
								</button>
								<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" class="kt-svg-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
										<path
											d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
											id="Path-94" fill="#000000" fill-rule="nonzero"></path>
										<path
											d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
											id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
											transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
									</g>
								</svg>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="collapse_search" class="collapse" aria-labelledby="heading_search" data-parent="#accordion_search" style="">
			<div class="card-body">
				{!! $form !!}
			</div>
		</div>
	</div>
</div>