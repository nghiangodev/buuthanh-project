<!--suppress ALL -->
<ul class="kt-menu__nav">
	@foreach ($menus as $menu)
		@if (isset($menu['menus']) && count($menu['menus']) > 1)
			<li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open-dropdown {{ $menu['activeClass'] }}" aria-haspopup="true" data-ktmenu-submenu-toggle="click">
				<a href="javascript:void(0)" class="kt-menu__link kt-menu__toggle">
					<i class="kt-menu__link-icon {{ $menu['icon'] }}"></i>
					<span class="kt-menu__link-text">
						{{ $menu['name'] }}
					</span>
					{{--                    <i class="kt-menu__hor-arrow far fa-angle-down"></i>--}}
					<i class="kt-menu__ver-arrow far fa-lg fa-angle-right"></i>
				</a>
				<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
					<span class="kt-menu__arrow kt-menu__arrow--adjust"></span>
					<ul class="kt-menu__subnav">
						@foreach ($menu['menus'] as $key => $subMenus)
							@if (is_string($key))
								@if (! is_array($subMenus))
									@continue
								@endif
								<li class="kt-menu__item kt-menu__item--submenu {{ \App\Entities\Core\Menu::getMenuActiveClass($subMenus) }}" data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<i class="kt-menu__link-icon fad fa-ellipsis-h"><span></span></i>
										<span class="kt-menu__link-text">{{ __(ucfirst($key)) }}</span>
										<i class="kt-menu__hor-arrow far fa-lg fa-angle-right"></i>
										<i class="kt-menu__ver-arrow far fa-lg fa-angle-right"></i>
									</a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right"><span class="kt-menu__arrow "></span>
										<ul class="kt-menu__subnav">
											@foreach ($subMenus as $subKey => $subMenu)
												@if (is_string($subKey))
													@continue
												@endif
												<li class="kt-menu__item {{ $subMenu['activeClass'] }}" aria-haspopup="true">
													<a href="{{ $subMenu['route'] }}" class="kt-menu__link" {{ $subMenu['downloadable'] ? 'download' : '' }}>
														@if ($subMenu['icon'])
															<i class="kt-menu__link-icon {{ $subMenu['icon'] }}"></i>
														@else
															<i class="kt-menu__link-icon far fa-dot-circle">
																<span></span>
															</i>
														@endif
														<span class="kt-menu__link-text font-weight-normal">
															{{ $subMenu['name'] }}
														</span>
													</a>
												</li>
											@endforeach
										</ul>
									</div>
								</li>
							@else
								@if (isset($subMenus['activeClass']))
									<li class="kt-menu__item {{ $subMenus['activeClass'] }}" aria-haspopup="true">
										<a href="{{ $subMenus['route'] }}" class="kt-menu__link" {{ $subMenus['downloadable'] ? 'download' : '' }}>
											@if ($subMenus['icon'])
												<i class="kt-menu__link-icon {{ $subMenus['icon'] }}"></i>
											@else
												<i class="kt-menu__link-icon fad fa-dot-circle">
													<span></span>
												</i>
											@endif
											<span class="kt-menu__link-text font-weight-normal">
												{{ $subMenus['name'] }}
											</span>
										</a>
									</li>
								@endif
							@endif
						@endforeach
					</ul>
				</div>
			</li>
		@elseif(isset($menu['route']))
			<li class="kt-menu__item {{ $menu['activeClass'] }}" aria-haspopup="true">
				<a href="{{ $menu['route'] }}" class="kt-menu__link" {{ $menu['downloadable'] ? 'download' : '' }}>
					@if ($menu['icon'])
						<i class="kt-menu__link-icon {{ $menu['icon'] }}"></i>
					@endif
					<span class="kt-menu__link-text">{{ $menu['name'] }}</span>
				</a>
			</li>
		@endif
	@endforeach
</ul>