@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการข้อมูลจังหวัด</h2>
    <a href="{{ route('provinceactivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มกิจกรรม</a>
    <table class="table table-bordered">
        <thead>
            <tr>
            
                <th>ชื่อจังหวัด</th>             
                
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    <td>{{ $row->province_name }}</td>                    
                    


                    <td>
                        <a href="{{ route('provinceactivityedit', $row->province_id) }}" class="btn btn-warning btn-sm">Edit</a>
                         <form action="{{ route('provinceactivitydelete', $row->province_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            <a href="{{ route('servicecenteractivityList', $row->province_id) }}" class="btn btn-success btn-sm">เพิ่มศูนย์บริการ</a> 
                        </td>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection