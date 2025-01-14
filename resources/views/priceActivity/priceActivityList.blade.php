@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการราคา</h2>
    <a href="{{ route('priceactivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มราคา</a>
    <table class="table table-bordered">
        <thead>
            <tr>
            
                <th>ชื่อราคา</th>             
                
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    <td>{{ $row->price_name }}</td>                    
                    


                    <td>
                        <a href="{{ route('priceactivityedit', $row->price_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('priceactivitydelete', $row->price_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            {{-- <a href="{{ route('promotionactivityList') }}" class="btn btn-success btn-sm">เพิ่มหมวดหมู่</a> --}}
                        </td>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection