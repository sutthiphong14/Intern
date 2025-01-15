@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการความเร็ว</h2>
    <a href="{{ route('speed_create',['service_id' => $service_id, 'promotion_id' => $promotion_id]) }}" class="btn btn-primary mb-3">เพิ่มความเร็ว</a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-dark text-light">
            
                <th >ชื่อความเร็ว</th>             
                <th>เครื่องมือ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    <td>{{ $row->speed_name }}</td>                    
                    
                    <td>
                        <a href="{{ route('speed_edit',['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id,'service_id' => $service_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('speed_delete', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id,'service_id' => $service_id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>

                            <a href="{{route('price_list',$row->speed_id)}}" class="btn btn-success btn-sm">เพิ่มราคา</a>
                        </td>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection