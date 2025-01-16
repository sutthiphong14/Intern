@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการโปรโมชัน</h2>
        <a href="{{ route('promotion_create', $service_id) }}" class="btn btn-primary mb-3">เพิ่มโปรโมชัน</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อโปรโมชัน</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td class="col-5">{{ $row->promotion_name }}</td>
                        <td>
                            <a href="{{ route('promotion_edit', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form
                                action="{{ route('promotion_delete', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('speed_list', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                class="btn btn-success btn-sm">เพิ่มความเร็ว</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
