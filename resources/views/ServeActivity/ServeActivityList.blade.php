@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการบริการ</h2>
    <a href="{{ route('serve.create') }}" class="btn btn-primary mb-3">เพิ่มบริการ</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อกิจกรรม</th>
                <th>เครื่องมือ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
            
                    <td>{{ $row->service_name }}</td>
                    
                    <td>
                        <a href="{{ route('serve.edit', $row->service_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('serve.destroy', $row->service_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            <a href="{{ route('promotionactivityList', ['service_id' => $row->service_id, 'type_id' => $typeId]) }}" class="btn btn-success btn-sm">เพิ่มหมวดหมู่</a>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection