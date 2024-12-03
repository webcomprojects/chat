@extends('admin.layout')
@section('title', 'مدیریت کاربران')
@section('actions')
    @can('user-create')
        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">ایجاد کاربر جدید</span>
        </a>
    @endcan
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">لیست کاربران</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>شناسه</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>نقش ها</th>
                    <th width="300px">اقدامات</th>
                </tr>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @can('user-edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                    <span class="text">ویرایش</span>
                                </a>
                            @endcan

                            @can('user-delete')
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
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


    {!! $data->links('pagination::bootstrap-5') !!}


@endsection
