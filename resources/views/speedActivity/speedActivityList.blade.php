@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการความเร็ว</h2>
        <a href="{{ route('speed_create', ['service_id' => $service_id, 'promotion_id' => $promotion_id]) }}"
            class="btn btn-primary mb-3">เพิ่มความเร็ว</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อความเร็ว</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->speed_name }}</td>
                            <td>
                                <a href="{{ route('speed_edit', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form
                                    action="{{ route('speed_delete', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                    <a href="{{ route('price_list', $row->speed_id) }}"
                                        class="btn btn-info btn-sm">ดูราคา</a>
                            </td>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลความเร็ว</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
