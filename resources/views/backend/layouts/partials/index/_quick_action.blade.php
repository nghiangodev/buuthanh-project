<!--suppress HtmlUnknownAttribute -->
<div class="dropdown dropdown-inline ml-2">
    <a href="#" class="btn btn-default btn-sm btn-circle btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="flaticon2-soft-icons"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
        <ul class="kt-nav">
            @if (can('delete_'. lcfirst($model)) || ($editUrl && can('update_'. lcfirst($model))))
                <li class="kt-nav__item kt-nav__section kt-nav__section--first mb-1">
                    <span class="kt-nav__section-text">@lang('Quick actions')</span>
                </li>
                @if(can('delete_'. lcfirst($model)))
                    <li class="kt-nav__item">
                        <a href="javascript:void(0)" data-url="{{ route(\Illuminate\Support\Str::snake(\Illuminate\Support\Str::plural($model)) . '.destroys') }}" class="kt-nav__link" id="link_delete_selected_rows">
                            <i class="kt-nav__link-icon far fa-trash"></i>
                            <span class="kt-nav__link-text">@lang('Delete selected rows')</span>
                        </a>
                    </li>
                @endif
                @if($editUrl && can('update_'. lcfirst($model)))
                    <li class="kt-nav__item">
                        <a href="javascript:void(0)" data-url="{{ $editUrl }}" class="kt-nav__link" id="link_edit_selected_rows">
                            <i class="kt-nav__link-icon far fa-edit"></i>
                            <span class="kt-nav__link-text">@lang('Edit selected rows')</span>
                        </a>
                    </li>
                @endif
            @endunless
        </ul>
    </div>
</div>