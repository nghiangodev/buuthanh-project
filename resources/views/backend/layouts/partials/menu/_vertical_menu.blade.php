<!--suppress HtmlUnknownAttribute -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
	<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1">
		<ul class="kt-menu__nav">
			@foreach ($menus as $menu)
				@if (isset($menu['menus']) && count($menu['menus']) > 1)
					<li class="kt-menu__item kt-menu__item--submenu {{ $menu['activeClass'] }}" aria-haspopup="true" kt-menu-submenu-toggle="hover">
						<a href="javascript:void(0)" class="kt-menu__link kt-menu__toggle">
							<i class="kt-menu__link-icon {{ $menu['icon'] }}"></i>
							<span class="kt-menu__link-text">{{ $menu['name'] }}</span>
							<i class="kt-menu__ver-arrow far fa-lg fa-angle-right"></i>
						</a>
						<div class="kt-menu__submenu ">
							<span class="kt-menu__arrow"></span>
							<ul class="kt-menu__subnav">
								<li class="kt-menu__item kt-menu__item--parent {{ $menu['activeClass'] }}" aria-haspopup="true">
									<span class="kt-menu__link">
										<span class="kt-menu__link-text">{{ $menu['name'] }}</span>
									</span>
								</li>
								@foreach ($menu['menus'] as $key => $subMenus)
									@if (is_string($key))
										@if (! is_array($subMenus))
											@continue
										@endif
										<li class="kt-menu__item kt-menu__item--submenu {{ \App\Entities\Core\Menu::getMenuActiveClass($subMenus) }}" aria-haspopup="true"
											kt-menu-submenu-toggle="hover">
											<a href="javascript:void(0)" class="kt-menu__link kt-menu__link kt-menu__toggle">
												<i class="kt-menu__link-icon fad fa-lg fa-ellipsis-h"><span></span></i>
												<span class="kt-menu__link-text">{{ __(ucfirst($key)) }}</span>
												<i class="kt-menu__ver-arrow far fa-lg fa-angle-right"></i>
											</a>
											<div class="kt-menu__submenu">
												<span class="kt-menu__arrow"></span>
												<ul class="kt-menu__subnav">
													@foreach ($subMenus as $subKey => $subMenuItem)
														@if (is_string($subKey))
															@continue
														@endif
														<li class="kt-menu__item {{ $subMenuItem['activeClass'] }}" aria-haspopup="true">
															<a href="{{ $subMenuItem['route'] }}" class="kt-menu__link" {{ $subMenuItem['downloadable'] ? 'download' : '' }}>
																@if ($subMenuItem['icon'])
																	<i class="kt-menu__link-icon {{ $subMenuItem['icon'] }}"></i>
																@else
																	<i class="kt-menu__link-icon far fa-dot-circle"><span></span></i>
																@endif
																<span class="kt-menu__link-text">{{ $subMenuItem['name'] }}</span>
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
														<i class="kt-menu__link-icon fad fa-dot-circle"><span></span></i>
													@endif
													<span class="kt-menu__link-text">{{ $subMenus['name'] }}</span>
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
	</div>
</div>