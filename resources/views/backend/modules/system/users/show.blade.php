@php /** @var \App\Models\User $user */
$breadcrumbs = ['breadcrumb' => 'users.show', 'model' => $user];
@endphp@extends("$layout.app")

@push('scripts')

@endpush

@section('title', __('action.View Model', ['model' => $user->classLabel(true)]))

@section('content')
	<div class="kt-content kt-form">
		<div class="kt-portlet kt-portlet--rounded">
			<div class="kt-portlet__body">
				<div class="form-group">
					<table class="table table-bordered table-striped">
						<tbody>
						<tr>
							<th class="w-25">{{ $user->label('username') }}</th>
							<td>{{ $user->username }} </td>
						</tr>
						<tr>
							<th>{{ $user->label('name') }}</th>
							<td>{{ $user->name }} </td>
						</tr>
						<tr>
							<th>{{ $user->label('email') }}</th>
							<td>{{ $user->email }} </td>
						</tr>
						<tr>
							<th>{{ $user->label('role') }}</th>
							<td> {{ $user->roles->isNotEmpty() ? $user->roles->implode('name') : '' }} </td>
						</tr>
						<tr>
							<th>{{ $user->label('state') }}</th>
							<td>{!! $user->state_text !!} </td>
						</tr>
						{{--                        <tr>--}}
						{{--                            <th> {{ $user->label('use_otp') }} </th>--}}
						{{--                            <td> {!! $user->is_use_otp_text !!} </td>--}}
						{{--                        </tr>--}}
						{{--                        @if ($user->is_use_otp)--}}
						{{--                            <tr>--}}
						{{--                                <th> {{ $user->label('otp_type') }} </th>--}}
						{{--                                <td> {!! $user->otp_type_text !!} </td>--}}
						{{--                            </tr>--}}
						{{--                        @endif--}}
						{{--                        <tr>--}}
						{{--                            <th> {{ $user->label('subscribe') }} </th>--}}
						{{--                            <td> {!! $user->is_subscribe_text !!} </td>--}}
						{{--                        </tr>--}}
						{{--                        @if ($user->is_subscribe)--}}
						{{--                            <tr>--}}
						{{--                                <th> {{ $user->label('subscribe_type') }} </th>--}}
						{{--                                <td> {!! $user->subscribe_type_text !!} </td>--}}
						{{--                            </tr>--}}
						{{--                        @endif--}}
						<tr>
							<th> {{ $user->label('created_at') }} </th>
							<td> {{ $user->created_at_text }} </td>
						</tr>
						<tr>
							<th> {{ $user->label('last_login_at') }} </th>
							<td> {{ optional($user->last_login_at)->format('d-m-Y H:i:s') }} </td>
						</tr>
						@if($user->avatar)
							<tr>
								<th> {{ $user->label('avatar') }} </th>
								<td>
									<img style="max-height: 300px; max-width: 600px" src="{{ $user->avatar_link }}" alt="Ảnh của bạn"/>
								</td>
							</tr>
						@endif
						</tbody>
					</table>
				</div>
				<div class="form-group">
					<div class="accordion accordion-solid accordion-toggle-svg" id="accordionExample8">
						<div class="card">
							<div class="card-header" id="headingTwo8">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo8" aria-expanded="false" aria-controls="collapseTwo8">
									{{ $user->label('All permissions which apply on the user') }}
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
							<div id="collapseTwo8" class="collapse" aria-labelledby="headingTwo8" data-parent="#accordionExample8" style="">
								<div class="card-body">
									@include('backend.modules.system.roles._permission_table', ['groups' => $groups, 'isCreate' => ! $user->exists, 'disabled' => true ])
								</div>
							</div>
						</div>
					</div>
				</div>
				@if (can('view-log'))
					<div class="form-group">
						<div class="accordion accordion-solid accordion-toggle-svg" id="accordion_log">
							<div class="card">
								<div class="card-header" id="heading_log">
									<div class="card-title collapsed" data-toggle="collapse" data-target="#collapse_log" aria-expanded="false" aria-controls="collapse_log">
										@lang('Activity log')
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
								<div id="collapse_log" class="collapse" aria-labelledby="heading_log" data-parent="#accordion_log" style="">
									<div class="card-body">
										<table class="table table-hovered datatables" id="table_orders_log">
											<thead class="">
											<tr>
												<th>{{ $user->label('description') }}</th>
												<th style="width: 5%">{{ $user->label('performed_at') }}</th>
											</tr>
											</thead>
											<tbody>
											@foreach ($logs as $key => $log)
												<tr>
													<td>{!! $log->description  !!}</td>
													<td>{{ $log->created_at->format('d-kt-Y H:i:s') }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			<div class="kt-portlet__foot kt-portlet__foot--solid">
				<div class="kt-form__actions kt-form__actions--right">
					@if($user->can_be_edited)
						<a href="{{ route('users.edit', $user) }}" class="btn-main btn-wide"><span><i class="far fa-edit"></i><span>@lang('Edit')</span></span></a>
					@endif
					<a href="{{ route('users.index') }}" class="btn-sub btn-wide"><span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span></a>
				</div>
			</div>
		</div>
	</div>
@endsection

