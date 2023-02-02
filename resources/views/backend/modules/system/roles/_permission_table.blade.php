@foreach ($groups as $group)
	<div class="accordion accordion-solid accordion-toggle-svg accordion-permission-table" id="accordion_{{ $loop->index }}">
		<div class="card">
			<div class="card-header">
				<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne{{ $loop->index }}" aria-expanded="false"
					 aria-controls="collapseOne{{ $loop->index }}">
					<i class="{{ $group['icon'] }}"></i> <span class="text-capitalize">{{ $group['name'] }}</span>
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
			<div id="collapseOne{{ $loop->index }}" class="collapse" aria-labelledby="headingOne{{ $loop->index }}" data-parent="#accordion_{{ $loop->index }}" style="">
				<div class="card-body">
					@if (!$disabled)
						<span class="p-1 float-right">
							<a href="javascript:void(0)" class="kt-link link-check-all">@lang('Check all')</a> |
							<a href="javascript:void(0)" class="kt-link link-uncheck-all">@lang('Uncheck all')</a>
						</span>
					@endif
					<table class="table table-inverse table-borderless table-responsive" style="width: 100%">
						<tbody>
						@foreach ($group['modules'] as $module)
							<tr>
								<td style="width: 200px; white-space: nowrap"><span class="font-weight-bold">{{ $module['name'] }}</span></td>
								@if (!$disabled)
									<td style="width: 200px; white-space: nowrap">
										<label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
											<input type="checkbox" class="chk-all-permission"> @lang('All')
											<span></span>
										</label>
									</td>
								@endif
								@foreach ($module['permissionNames'] as $role)
									@if ($role !== null)
										@if(! empty($isCreate))
											<td style="width: 200px; white-space: nowrap">
												<label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
													<input type="checkbox" class="chk-permission" name="permissions[]"
														   value="{{ $role }}"> {{ __(ucfirst($module['permissions'][$loop->index])) }}
													<span></span>
												</label>
											</td>
										@else
											@php
												$checked = in_array($role, $permissions, true) ? 'checked' : '';
											@endphp
											<td style="width: 200px; white-space: nowrap">
												<label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
													<input type="checkbox" class="chk-permission" name="permissions[]"
														   {{ $disabled ? 'disabled' : '' }} value="{{ $role }}" {{ $checked }}> {{ __(ucfirst($module['permissions'][$loop->index])) }}
													<span></span>
												</label>
											</td>
										@endif
									@else
										<td></td>
									@endif
								@endforeach
								@php
									$totalPermission = count($module['permissionNames']);
									$offset = 4 - $totalPermission;
								@endphp
								@if ($offset)
									@for ($i = 0; $i < $offset; $i++)
										<td style="width: 200px"></td>
									@endfor
								@endif
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endforeach
