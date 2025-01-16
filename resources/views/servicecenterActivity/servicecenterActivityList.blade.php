@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการข้อมูลศูนย์บริการ</h2>
        <a href="{{ route('servicecenteractivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มศูนย์บริการ</a>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อศูนย์บริการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $row->center_name }}</td>
                        <td>
                            <a href="{{ route('servicecenteractivityedit', $row->center_id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('servicecenteractivitydelete', $row->center_id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                        </td>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
