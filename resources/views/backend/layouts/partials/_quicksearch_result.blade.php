<div class="kt-list-search__results">
    @if ($results)
        <span class="kt-list-search__result-category kt-list-search__result-category--first">
            @lang('Search result')
        </span>

        @foreach ($results as $result)
            @if($result)
                <a href="{{ $result['url'] }}" class="kt-list-search__result-item">
                    {{--<span class="kt-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-warning"></i></span>--}}
                    <span class="kt-list-search__result-item-text">{{ $result['text'] }}</span>
                </a>
            @endif
        @endforeach
    @else
        <span class="kt-list-search__result-message">
            @lang('No search result found')
        </span>
    @endif
</div>