@extends('admin.layout')
@section('title', 'اطلاعات قبض')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">اطلاعات قبض</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>نام کاربری</th>
                    <th>نام و نام خانوادگی</th>
                    <th>سمت</th>
                    <th>شماره تماس</th>
                    <th>نام واحد اقتصادی</th>
                    <th>قدرت قراردادی</th>
                    <th>تصویر</th>
                    <th>وضعیت</th>
                </tr>
                    <tr>
                        <td>{{ $sendbill->user->email }}</td>
                        <td>{{ $sendbill->name }}</td>
                        <td>{{ $sendbill->job }}</td>
                        <td>{{ $sendbill->phone }}</td>
                        <td>{{ $sendbill->economic_unit }}</td>
                        <td>{{ $sendbill->contractual_power }}</td>
                        <td>
                            <div class="d-flex flex-column align-items-center">
                                <img id="imagePreview" src="{{ Storage::url($sendbill->file) }}"
                            alt="تصویر فعلی" style="max-width: 100px; max-height: 60px;">
                            <a class="mt-2" href="{{ Storage::url($sendbill->file) }}" download="">دانلود</a>
                            </div>
                        </td>
                        <td>{!! $sendbill->status !!}</td>
                    </tr>
            </table>
        </div>
    </div>
@endsection
