@extends('admin.layout')
@section('title', 'ویرایش قبض')
@section('actions')
    <a href="{{ route('infobills.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @session('error')
        <div class="alert alert-danger" infobill="alert">
            {{ $value }}
        </div>
    @endsession
    
    <form action="{{ route('infobills.update', $infobill->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات شخصی</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">نام و نام خانوادگی</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $infobill->name) }}" required maxlength="50">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="job" class="form-label">سمت شما</label>
                                <input type="text" class="form-control" id="job" name="job"
                                    value="{{ old('job', $infobill->job) }}" maxlength="50">
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات تماس</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">شماره تماس</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $infobill->phone) }}" required maxlength="50">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="economic_unit" class="form-label">نام واحد اقتصادی</label>
                                <input type="text" class="form-control" id="economic_unit" name="economic_unit"
                                    value="{{ old('economic_unit', $infobill->economic_unit) }}" required maxlength="50">
                                @error('economic_unit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">مشخصات مدیرعامل و قرارداد</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Two_way_electricity_rate" class="form-label">نرخ خرید برق دو جانبه</label>
                                <input type="number" class="form-control" id="Two_way_electricity_rate"
                                    name="Two_way_electricity_rate"
                                    value="{{ old('Two_way_electricity_rate', $infobill->Two_way_electricity_rate) }}"
                                    maxlength="50" placeholder="به ریال وارد کنید">
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label for="ceo_name" class="form-label">نام مدیرعامل</label>
                                <input type="text" class="form-control" id="ceo_name" name="ceo_name"
                                    value="{{ old('ceo_name', $infobill->ceo_name) }}" maxlength="50">
                            </div> --}}

                            <div class="col-md-6 mb-3">
                                <label for="contractual_power" class="form-label">قدرت قراردادی</label>
                                <input type="text" class="form-control" id="contractual_power" name="contractual_power"
                                    value="{{ old('contractual_power', $infobill->contractual_power) }}" maxlength="50">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="made16_status" class="form-label">آیا مشمول ماده ۱۶ می شوید؟</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="made16_status" id="made16_yes"
                                        value="yes"
                                        {{ old('made16_status', $infobill->made16_status) == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="made16_yes">بله</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="made16_status" id="made16_no"
                                        value="no"
                                        {{ old('made16_status', $infobill->made16_status) == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="made16_no">خیر</label>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات قبض</h6>
                    </div>
                    <div class="card-body">
                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto">شرح مصارف</legend>

                            <fieldset class="border p-2 mb-3">
                                <legend class="w-auto">میان باری</legend>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="middle_load_meter_consumption" class="form-label">مصرف کنتور
                                            (کیلووات
                                            / ساعت)</label>
                                        <input type="number" class="form-control" id="middle_load_meter_consumption"
                                            name="middle_load_meter_consumption"
                                            value="{{ old('middle_load_meter_consumption', $infobill->middle_load_meter_consumption) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="middle_load_allocation_coefficient" class="form-label">ضریب تخصیص
                                            بار
                                            پایه
                                            (TOU)</label>
                                        <input type="number" class="form-control" id="middle_load_allocation_coefficient"
                                            name="middle_load_allocation_coefficient"
                                            value="{{ old('middle_load_allocation_coefficient', $infobill->middle_load_allocation_coefficient) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="middle_load_electricity_supply_rate" class="form-label">نرخ تامین
                                            برق
                                            پشتیبان</label>
                                        <input type="number" class="form-control" id="middle_load_electricity_supply_rate"
                                            name="middle_load_electricity_supply_rate"
                                            value="{{ old('middle_load_electricity_supply_rate', $infobill->middle_load_electricity_supply_rate) }}"
                                            maxlength="50">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="border p-2 mb-3">
                                <legend class="w-auto">اوج بار</legend>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="peak_load_meter_consumption" class="form-label">مصرف کنتور
                                            (کیلووات /
                                            ساعت)</label>
                                        <input type="number" class="form-control" id="peak_load_meter_consumption"
                                            name="peak_load_meter_consumption"
                                            value="{{ old('peak_load_meter_consumption', $infobill->peak_load_meter_consumption) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="peak_load_allocation_coefficient" class="form-label">ضریب تخصیص
                                            بار
                                            پایه (TOU)</label>
                                        <input type="number" class="form-control" id="peak_load_allocation_coefficient"
                                            name="peak_load_allocation_coefficient"
                                            value="{{ old('peak_load_allocation_coefficient', $infobill->peak_load_allocation_coefficient) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="peak_load_electricity_supply_rate" class="form-label">نرخ تامین
                                            برق
                                            پشتیبان</label>
                                        <input type="number" class="form-control" id="peak_load_electricity_supply_rate"
                                            name="peak_load_electricity_supply_rate"
                                            value="{{ old('peak_load_electricity_supply_rate', $infobill->peak_load_electricity_supply_rate) }}"
                                            maxlength="50">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="border p-2">
                                <legend class="w-auto">کم باری</legend>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="low_load_meter_consumption" class="form-label">مصرف کنتور (کیلووات
                                            /
                                            ساعت)</label>
                                        <input type="number" class="form-control" id="low_load_meter_consumption"
                                            name="low_load_meter_consumption"
                                            value="{{ old('low_load_meter_consumption', $infobill->low_load_meter_consumption) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="low_load_allocation_coefficient" class="form-label">ضریب تخصیص بار
                                            پایه (TOU)</label>
                                        <input type="number" class="form-control" id="low_load_allocation_coefficient"
                                            name="low_load_allocation_coefficient"
                                            value="{{ old('low_load_allocation_coefficient', $infobill->low_load_allocation_coefficient) }}"
                                            maxlength="50">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="low_load_electricity_supply_rate" class="form-label">نرخ تامین برق
                                            پشتیبان</label>
                                        <input type="number" class="form-control" id="low_load_electricity_supply_rate"
                                            name="low_load_electricity_supply_rate"
                                            value="{{ old('low_load_electricity_supply_rate', $infobill->low_load_electricity_supply_rate) }}"
                                            maxlength="50">
                                    </div>
                                </div>
                            </fieldset>
                        </fieldset>
                    </div>
                </div>
            </div>

            {{-- @can('change_status_infobill')
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select name="status" class="form-control">
                                <option value="pending"
                                    {{ old('status', $infobill->getRawOriginal('status')) == 'pending' ? 'selected' : '' }}>
                                    در حال
                                    بررسی</option>
                                <option value="confirm"
                                    {{ old('status', $infobill->getRawOriginal('status')) == 'confirm' ? 'selected' : '' }}>
                                    تایید شده
                                </option>
                                <option value="reject"
                                    {{ old('status', $infobill->getRawOriginal('status')) == 'reject' ? 'selected' : '' }}>رد
                                    شده
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endcan --}}


            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <button type="submit" class="btn btn-success">بروزرسانی</button>
            </div>
        </div>
    </form>
@endsection
