@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการกิจกรรม</h2>
        <a href="{{ route('type_create') }}" class="btn btn-primary mb-3">เพิ่มกิจกรรม</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อกิจกรรม</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td class="col-5">{{ $row->type_name }}</td>
                            <td>
                                <a href="{{ route('type_edit', $row->type_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('type_delete', $row->type_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลกิจกรรม</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
