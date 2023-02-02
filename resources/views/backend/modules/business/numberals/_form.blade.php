@php /** @var \App\Models\Numberal $numberal */ @endphp
<form id="numberals_form" class="kt-form" method="post" action="{{ $action }}" autocomplete="off" data-confirm="false" data-ajax="true">
    @csrf
    @isset($method)
        @method('put')
    @endisset
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-title text-capitalize">{{ $numberal->getFormTitle() }}</span>
        </div>
    </div>
    <div class="kt-portlet__body">
        <x-accordion-section :icon="'fa fad-info'" :title="$numberal->label('info_owner')" is-show="true">
            <div class="form-group row">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                    <label for="txt_name">{{ $numberal->label('name') }} </label>
                    <input class="form-control text-string" name="name" type="text" id="txt_name" value="{{ $numberal->name ?? old('name')}}" required>
                    <span class="form-text text-danger">{!! $errors->first('name') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('dob') ? 'has-danger' : ''}}">
                    <label for="txt_dob_cus">{{ $numberal->label('dob') }}</label>
                    <input class="form-control text-datepicker" name="dob" type="text" id="txt_dob_cus" value="{{ $numberal->customer->dob ?? old('dob')}}" required>
                    <span class="form-text text-danger">{!! $errors->first('dob') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('phone') ? 'has-danger' : ''}}">
                    <label for="txt_phone">{{ $numberal->label('phone') }}</label>
                    <input class="form-control text-phone" name="phone" type="phone" id="txt_phone" value="{{ $numberal->customer->phone ?? old('phone')}}" required>
                    <span class="form-text text-danger">{!! $errors->first('phone') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('address') ? 'has-danger' : ''}}">
                    <label for="txt_address">{{ $numberal->label('address') }}</label>
                    <input class="form-control" name="address" type="text" id="txt_address" value="{{ $numberal->customer->address ?? old('address')}}" required>
                    <span class="form-text text-danger">{!! $errors->first('address') !!}</span>
                </div>
            </div>
        </x-accordion-section>
        <x-accordion-section :icon="'fa fad-info'" :title="$numberal->label('info_detail')" is-show="true">
            <div class="form-group row" id="form_detail">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('full_name') ? 'has-danger' : ''}}">
                    <label for="txt_full_name">{{ $numberal->label('full_name') }}</label>
                    <input class="form-control text-string" type="text" id="txt_full_name" value="{{ $numberal->full_name ?? old('full_name')}}">
                    <span class="form-text text-danger">{!! $errors->first('full_name') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('dob') ? 'has-danger' : ''}}">
                    <label for="txt_dob">{{ $numberal->label('dob') }}</label>
                    <input class="form-control text-datepicker-dob" type="text" id="txt_dob" >
                    <span class="form-text text-danger">{!! $errors->first('dob') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group {{ $errors->has('age') ? 'has-danger' : ''}}">
                    <label for="txt_age">{{ $numberal->label('age') }}</label>
                    <input class="form-control text-right" type="number" id="txt_age" value="{{ $numberal->age ?? old('age')}}" disabled>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
                    <label for="select_star_resolution">{{ $numberal->label('star_resolution') }}</label>
                    <select class="form-control select2-ajax" id="select_star_resolution" data-column="name" data-url="{{ route('numberals.star_resolution_list') }}">
                    </select>
                    <span class="form-text text-danger">{!! $errors->first('name') !!}</span>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
                    <label for="select_gender">{{ $numberal->label('gender') }}</label>
                    <select class="form-control select2" id="select_gender">
                        @foreach ($numberal->genders as $key => $gender)
                            <option value="{{ $key }}">{{ $gender }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 form-group"><p class="text-danger mb-0"><strong>* Số dòng hiển thị tối đa trên một tờ sớ sao là 20 dòng</strong></p></div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 form-group">
                    <div class="kt-form__actions kt-form__actions--left">
                        <button class="btn-main btn-wide" type=button id=btn_add_item><span><i class="far fa-plus"></i><span>@lang('Add')</span></span></button>
                    </div>
                </div>
                <input class="form-control" type="hidden" value="{{$numberal->customer->id}}" name="customer_id">
                <div class="col-12 form-group">
                    <h3>@lang('List')</h3>
                    <table class="table table-hover" id="table_item_cat">
                        <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>{{ $numberal->label('full_name') }}</th>
                            <th>{{ $numberal->label('dob') }}</th>
                            <th>{{ $numberal->label('age') }}</th>
                            <th>{{ $numberal->label('star_resolution') }}</th>
                            <th>{{ $numberal->label('gender') }}</th>
                            <th>@lang('Actions')</th>
                        </tr>
                        </thead>
                        @if ($numberal->id)
                            @foreach ($itemCats as $itemCat)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <span>{{$itemCat->full_name}}</span>
                                        <input class="form-control" type="hidden" value="{{$itemCat->full_name}}" name="itemCats[{{$loop->index}}][full_name]">
                                    </td>
                                    <td>
                                        <span>{{$itemCat->dob}}</span>
                                        <input class="form-control text-datepicker edit-dob" type="hidden" value="{{$itemCat->dob}}" name="itemCats[{{$loop->index}}][dob]">
                                    </td>
                                    <td>
                                        <span class="edit-age-span">{{$itemCat->age}}</span>
                                        <input class="form-control edit-age" type="hidden" value="{{$itemCat->age}}" name="itemCats[{{$loop->index}}][age]">
                                    </td>
                                    <td>
                                        <select class="form-control select2-ajax select-row-unit" data-column="name" data-url="{{route('numberals.star_resolution_list')}}"
                                                 name="itemCats[{{$loop->index}}][star_resolution_id]">
                                            <option value="{{$itemCat->starResolution->id}}">{{$itemCat->starResolution->name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <span>{{$itemCat->gender_name}}</span>
                                        <input class="form-control" type="hidden" value="{{$itemCat->gender}}" name="itemCats[{{$loop->index}}][gender]">
                                    </td>
                                    <td>
                                        <input class="form-control" type="hidden" value="{{$itemCat->id}}" name="itemCats[{{$loop->index}}][id]">
                                        <button class="btn-action-edit btn-primary btn-edit-item" type="button"><i class="far fa-edit"></i></button>
                                        <button class="btn-action-delete btn-danger btn-delete-item" data-id="{{$itemCat->id}}" type="button"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </x-accordion-section>
    </div>
    <div class="kt-portlet__foot kt-portlet__foot--solid">
        <div class="kt-form__actions kt-form__actions--right">
            @if ($numberal->canBeSaved())
                <button class="btn-main btn-wide"><span><i class="far fa-save"></i>
                        <span>@lang('Save')</span></span>
                </button>
            @endif
            <a href="{{ route('numberals.index') }}" class="btn-sub btn-wide" id="link_back" data-should-confirm="{{ ! $numberal->exists }}">
                <span><i class="far fa-arrow-left"></i><span>@lang('Back')</span></span>
            </a>
        </div>
    </div>
</form>
