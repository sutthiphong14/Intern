@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการความเร็ว</h2>
    <a href="{{ route('speedactivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มความเร็ว</a>
    <table class="table table-bordered">
        <thead>
            <tr>
            
                <th>ชื่อความเร็ว</th>             
                
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    <td>{{ $row->speed_name }}</td>                    
                    


                    <td>
                        <a href="{{ route('speedactivityedit', $row->speed_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('speedactivitydelete', $row->speed_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>

                            <a href="{{ route('priceactivityList', ['speed_id' => $row->speed_id, 'promotion_id' => $promotion_id]) }}" class="btn btn-success btn-sm">เพิ่มหมวดหมู่</a>
                        </td>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection