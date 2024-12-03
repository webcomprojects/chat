@extends('admin.layout')
@section('title', 'مدیریت قبض ها')
@section('actions')
    @can('infobill-create')
        <a href="{{ route('infobills.create') }}" class="btn btn-success btn-sm btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">ارسال قبض جدید</span>
        </a>
    @endcan
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success" infobill="alert">
            {{ $value }}
        </div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست قبض ها</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="100px">شناسه</th>
                    <th>نام کاربری</th>
                    <th>نام و نام خانوادگی</th>
                    <th>سمت</th>
                    <th>شماره تماس</th>
                    <th>نام واحد اقتصادی</th>
                    {{-- <th>وضعیت</th> --}}
                    <th width="300px">اقدامات</th>
                </tr>
                @foreach ($infobills as $key => $infobill)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $infobill->user->email }}</td>
                        <td>{{ $infobill->name }}</td>
                        <td>{{ $infobill->job }}</td>
                        <td>{{ $infobill->phone }}</td>
                        <td>{{ $infobill->economic_unit }}</td>
                        {{-- <td>{!! $infobill->status !!}</td> --}}
                        <td>
                            @can('infobill-show')
                                <a href="{{ route('infobills.bill', $infobill->id) }}"
                                    class="btn btn-info btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-list"></i>
                                    </span>
                                    <span class="text">نمایش</span>
                                </a>
                            @endcan
                            @can('infobill-edit')
                                <a href="{{ route('infobills.edit', $infobill->id) }}"
                                    class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                    <span class="text">ویرایش</span>
                                </a>
                            @endcan

                            @can('infobill-delete')
                                <form method="POST" action="{{ route('infobills.destroy', $infobill->id) }}"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button ype="submit" class="btn btn-danger btn-sm btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">حذف</span>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


    {!! $infobills->links('pagination::bootstrap-5') !!}


@endsection
