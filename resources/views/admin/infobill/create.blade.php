@extends('admin.layout')
@section('title', 'ارسال قبض جدید')
@section('actions')
    <a href="{{ route('infobills.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection


@if (isCompletedInfo())
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

        <form action="{{ route('infobills.store') }}" method="POST">
            @csrf

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
                                    value="{{ old('name') }}" required maxlength="50">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="job" class="form-label">سمت شما</label>
                                <input type="text" class="form-control" id="job" name="job"
                                    value="{{ old('job') }}" maxlength="50">
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
                                    value="{{ old('phone') }}" required maxlength="50">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="economic_unit" class="form-label">نام واحد اقتصادی</label>
                                <input type="text" class="form-control" id="economic_unit" name="economic_unit"
                                    value="{{ old('economic_unit') }}" required maxlength="50">
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
                                        name="Two_way_electricity_rate" value="{{ old('Two_way_electricity_rate') }}"
                                        maxlength="50" placeholder="به ریال وارد کنید">
                                </div>
                                {{-- <div class="col-md-6 mb-3">
                                <label for="ceo_name" class="form-label">نام مدیرعامل</label>
                                <input type="text" class="form-control" id="ceo_name" name="ceo_name"
                                    value="{{ old('ceo_name') }}" maxlength="50">
                            </div> --}}

                                <div class="col-md-6 mb-3">
                                    <label for="contractual_power" class="form-label">قدرت قراردادی</label>
                                    <input type="text" class="form-control" id="contractual_power"
                                        name="contractual_power" value="{{ old('contractual_power') }}" maxlength="50">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="made16_status" class="form-label">آیا مشمول ماده ۱۶ می شوید؟</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="made16_status" id="made16_yes"
                                            value="yes" {{ old('made16_status', 'yes') == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label px-2" for="made16_yes"> بله </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="made16_status" id="made16_no"
                                            value="no" {{ old('made16_status') == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label px-2" for="made16_no"> خیر </label>
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
                                                value="{{ old('middle_load_meter_consumption') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="middle_load_allocation_coefficient" class="form-label">ضریب تخصیص
                                                بار
                                                پایه
                                                (TOU)</label>
                                            <input type="number" class="form-control"
                                                id="middle_load_allocation_coefficient"
                                                name="middle_load_allocation_coefficient"
                                                value="{{ old('middle_load_allocation_coefficient', get_setting_collection($settings, 'middle_load_allocation_coefficient')) }}"
                                                maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="middle_load_electricity_supply_rate" class="form-label">نرخ تامین
                                                برق
                                                پشتیبان</label>
                                            <input type="number" class="form-control"
                                                id="middle_load_electricity_supply_rate"
                                                name="middle_load_electricity_supply_rate"
                                                value="{{ old('middle_load_electricity_supply_rate', get_setting_collection($settings, 'middle_load_electricity_supply_rate')) }}"
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
                                                value="{{ old('peak_load_meter_consumption') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="peak_load_allocation_coefficient" class="form-label">ضریب تخصیص
                                                بار
                                                پایه (TOU)</label>
                                            <input type="number" class="form-control"
                                                id="peak_load_allocation_coefficient"
                                                name="peak_load_allocation_coefficient"
                                                value="{{ old('peak_load_allocation_coefficient', get_setting_collection($settings, 'peak_load_allocation_coefficient')) }}"
                                                maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="peak_load_electricity_supply_rate" class="form-label">نرخ تامین
                                                برق
                                                پشتیبان</label>
                                            <input type="number" class="form-control"
                                                id="peak_load_electricity_supply_rate"
                                                name="peak_load_electricity_supply_rate"
                                                value="{{ old('peak_load_electricity_supply_rate', get_setting_collection($settings, 'peak_load_electricity_supply_rate')) }}"
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
                                                value="{{ old('low_load_meter_consumption') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="low_load_allocation_coefficient" class="form-label">ضریب تخصیص بار
                                                پایه (TOU)</label>
                                            <input type="number" class="form-control"
                                                id="low_load_allocation_coefficient"
                                                name="low_load_allocation_coefficient"
                                                value="{{ old('low_load_allocation_coefficient', get_setting_collection($settings, 'low_load_allocation_coefficient')) }}"
                                                maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="low_load_electricity_supply_rate" class="form-label">نرخ تامین برق
                                                پشتیبان</label>
                                            <input type="number" class="form-control"
                                                id="low_load_electricity_supply_rate"
                                                name="low_load_electricity_supply_rate"
                                                value="{{ old('low_load_electricity_supply_rate', get_setting_collection($settings, 'low_load_electricity_supply_rate')) }}"
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
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در حال
                                        بررسی</option>
                                    <option value="confirm" {{ old('status') == 'confirm' ? 'selected' : '' }}>
                                        تایید شده</option>
                                    <option value="reject" {{ old('status') == 'reject' ? 'selected' : '' }}>رد شده
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan --}}
                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                    <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                        <span class="icon text-white-50">
                            <svg fill="#ffffff" height="16px" width="16px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"
                                stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Floppy-disk">
                                        <path
                                            d="M35.2673988,6.0411h-7.9999981v10h7.9999981V6.0411z M33.3697014,14.1434002h-4.2046013V7.9387999h4.2046013V14.1434002z">
                                        </path>
                                        <path
                                            d="M41,47.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,47.4883003,41.5527,47.0410995,41,47.0410995z">
                                        </path>
                                        <path
                                            d="M41,39.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,39.4883003,41.5527,39.0410995,41,39.0410995z">
                                        </path>
                                        <path d="M12,56.0410995h38v-26H12V56.0410995z M14,32.0410995h34v22H14V32.0410995z">
                                        </path>
                                        <path
                                            d="M49.3811989,0.0411L49.3610992,0H7C4.7908001,0,3,1.7909,3,4v56c0,2.2092018,1.7908001,4,4,4h50 c2.2090988,0,4-1.7907982,4-4V11.6962996L49.3811989,0.0411z M39.9604988,2.0804999v17.9211006H14.0394001V2.0804999H39.9604988z M59,60c0,1.1027985-0.8972015,2-2,2H7c-1.1027999,0-2-0.8972015-2-2V4c0-1.1027999,0.8972001-2,2-2h5v20.0410995h30V2h6.5099983 L59,12.5228996V60z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text">ذخیره</span>
                    </button>
                </div>
            </div>
        </form>

    @endsection


    @section('js')
        <script>
            document.getElementById('uploadButton').addEventListener('click', function() {
                document.getElementById('fileInput').click();
            });

            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            }
        </script>
    @endsection
@else
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    برای ارسال قبض نیاز است ابتدا اطلاعات تکمیلی خود را کامل کنید
                </div>
            </div>
        </div>
    @endsection
@endif
