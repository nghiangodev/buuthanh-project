<style>
    table, td {
        border: 0.25 solid;
    }

    p, h3, h4 {
        margin: 5px;
    }

    .th-border {
        border: 0.25 solid;
        padding: 5px;
    }

    .td-custom-top-center {
        word-wrap: break-word;
        vertical-align: top;
        font-size: 13px;
        text-align: center;
        width: 100%;
        margin-left: 20px;
        padding: 5px;
    }

    .th-custom-break-word {
        vertical-align: center;
        text-align: center;
        word-wrap: break-word;
        font-weight: bold;
        font-size: 16px;
    }

</style>
<table cellspacing=0 cellpadding=0>
    <thead>
    <tr>
        <th class="th-custom-break-word th-border"><b>@lang('Số TT')</b></th>
        <th class="th-border" style="text-align: center"><b>@lang('Họ và tên')</b></th>
        <th class="th-border" style="text-align: center"><b>@lang('Tuổi')</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($itemCats as $itemCat)
        <tr>
            <td class="td-custom-top-center">{{$loop->index+1}}</td>
            <td class="td-custom-top-center">{{$itemCat->full_name}}</td>
            <td class="td-custom-top-center">{{$itemCat->age}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
