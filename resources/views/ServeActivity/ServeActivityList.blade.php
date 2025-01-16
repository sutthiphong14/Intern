@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการบริการ</h2>
        <a href="{{ route('service_create') }}" class="btn btn-primary mb-3">เพิ่มบริการ</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อบริการ</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>

                        <td class="col-5">{{ $row->service_name }}</td>

                        <td>
                            <a href="{{ route('service_edit', $row->service_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('service_delete', $row->service_id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('promotion_list', $row->service_id) }}"
                                class="btn btn-success btn-sm">เพิ่มโปรโมชั่น</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
