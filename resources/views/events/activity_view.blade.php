@extends('admins.index')
@section('css')
@endsection

@section('content')

<div class="container">
  
    <table class="table table-bordered ">
        <thead>
            <tr class="bg-dark text-light">
                <th>ชื่อกิจกรรม</th>
                <th>เครื่องมือ</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->count() > 0)
                @foreach ($data as $row)
                    <tr>
                        <td >{{ $row->type_name }}</td>
                        <td>
                           <a href="#" class="btn btn-primary">เลือก</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่มีข้อมูลกิจกรรม</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection

@section('script')
   



@endsection
