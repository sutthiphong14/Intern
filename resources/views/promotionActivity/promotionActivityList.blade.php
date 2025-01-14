@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการโปรโมชัน</h2>
    <a href="{{ route('promotionactivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มกิจกรรม</a>
    <table class="table table-bordered">
        <thead>
            <tr>
            
                <th>ชื่อโปรโมชัน</th>             
                
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    <td>{{ $row->promotion_name }}</td>                    
                    


                    <td>
                        <a href="{{ route('promotionactivityedit', $row->promotion_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('promotionactivitydelete', $row->promotion_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            <a href="{{ route('speedactivityList', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}" class="btn btn-success btn-sm">เพิ่มหมวดหมู่</a>
                        </td>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection