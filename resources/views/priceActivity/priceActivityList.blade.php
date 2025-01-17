@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการราคา</h2>
        <a href="{{ route('price_create', $speed_id) }}" class="btn btn-primary mb-3">เพิ่มราคา</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อราคา</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                @foreach ($data as $row)
                    <tr>

                        <td>{{ $row->price_name }}</td>
                        <td>
                            <a href="{{ route('price_edit', ['speed_id' => $speed_id, 'price_id' => $row->price_id]) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form
                                action="{{ route('price_delete', ['speed_id' => $speed_id, 'price_id' => $row->price_id]) }}"
                                method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                        </form>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2" class="text-center">ไม่มีข้อมูลราคา</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
