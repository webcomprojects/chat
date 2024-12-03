@extends('admin.layout')
@section('title', 'ویرایش قبض')
@section('actions')
    <a href="{{ route('sendbills.index') }}" class="btn btn-primary btn-sm btn-icon-split">
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

    <form method="POST" action="{{ route('sendbills.update', $sendbill->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">اطلاعات قبض</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-lg-6 mb-4">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input type="text" name="name" placeholder="نام و نام خانوادگی"
                                        class="form-control" value="{{ old('name', $sendbill->name) }}" required>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="job">سمت شما</label>
                                    <input type="text" name="job" placeholder="سمت شما" class="form-control"
                                        value="{{ old('job', $sendbill->job) }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="phone">شماره تماس</label>
                                    <input type="text" name="phone" placeholder="شماره تماس" class="form-control"
                                        value="{{ old('phone', $sendbill->phone) }}" required>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="economic_unit">نام واحد اقتصادی</label>
                                    <input type="text" name="economic_unit" placeholder="نام واحد اقتصادی"
                                        class="form-control" value="{{ old('economic_unit', $sendbill->economic_unit) }}"
                                        required>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="ceo_name">نام مدیرعامل</label>
                                    <input type="text" name="ceo_name" placeholder="نام مدیرعامل" class="form-control"
                                        value="{{ old('ceo_name', $sendbill->ceo_name) }}">
                                </div> --}}
                                <div class="col-lg-6 mb-4">
                                    <label for="contractual_power">قدرت قراردادی</label>
                                    <input type="text" name="contractual_power" placeholder="قدرت قراردادی"
                                        class="form-control"
                                        value="{{ old('contractual_power', $sendbill->contractual_power) }}">
                                </div>
                                @can('change_status_sendbill')
                                    <div class="col-lg-6 mb-4">
                                        <label for="status">وضعیت</label>
                                        <select name="status" class="form-control">
                                            <option value="pending"
                                                {{ old('status', $sendbill->getRawOriginal('status')) == 'pending' ? 'selected' : '' }}>در حال
                                                بررسی</option>
                                            <option value="confirm"
                                                {{ old('status', $sendbill->getRawOriginal('status')) == 'confirm' ? 'selected' : '' }}>تایید شده
                                            </option>
                                            <option value="reject"
                                                {{ old('status', $sendbill->getRawOriginal('status')) == 'reject' ? 'selected' : '' }}>رد شده
                                            </option>
                                        </select>
                                    </div>
                                @endcan
                                <div class="col-lg-6 mb-4">
                                    <label for="file">بارگذاری تصویر</label>
                                    <div class="custom-file-upload">
                                        <button type="button" id="uploadButton" class="btn btn-primary">انتخاب
                                            فایل</button>
                                        <input type="file" name="file" id="fileInput" class="form-control"
                                            accept="image/*" onchange="previewImage(event)" style="display: none;">
                                    </div>
                                    <div class="mt-3">
                                        @if ($sendbill->file)
                                            <img id="imagePreview" src="{{ Storage::url($sendbill->file) }}"
                                                alt="تصویر فعلی" style="max-width: 200px; max-height: 200px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="پیش‌نمایش تصویر"
                                                style="display: none; max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $sendbill->user_id }}">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                    <span class="icon text-white-50">
                        <svg fill="#ffffff" height="16px" width="16px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" stroke="#ffffff">
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
