<div id="kt_quick_panel" class="kt-quick-panel">
    <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
    <div class="kt-quick-panel__nav">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_tab_settings" role="tab">@lang('Setting')</a>
            </li>
        </ul>
    </div>
    <div class="kt-quick-panel__content">
        <div class="tab-content">
            <div class="tab-pane kt-quick-panel__content-padding-x show fade kt-scroll active" id="kt_quick_panel_tab_settings" role="tabpanel">
                <form class="kt-form">
                    @if (config('app.env') === 'local')
                        <div class="form-group form-group-last form-group-xs row">
                            <label class="col-6 col-form-label">
                                <a href="javascript:(function(){var h,a,f;a=document.getElementsByTagName('link');for(h=0;h<a.length;h++){f=a[h];if(f.rel.toLowerCase().match(/stylesheet/)&amp;&amp;f.href){var g=f.href.replace(/(&amp;|%5C?)forceReload=\d+/,'');f.href=g+(g.match(/\?/)?'&amp;':'?')+'forceReload='+(new Date().valueOf())}}})()">
                                    Refresh CSS
                                </a>
                            </label>
                        </div>
                    @endif
                    <div class="kt-separator kt-separator--space-md kt-separator--border-dashed"></div>
                </form>
            </div>
        </div>
    </div>
</div>