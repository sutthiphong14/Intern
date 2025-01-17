@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการกิจกรรม</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">
            เพิ่มกิจกรรม
        </button>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
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
                            <td class="col-5">{{ $row->type_name }}</td>
                            <td>
                                <a href="{{ route('type_edit', $row->type_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('type_delete', $row->type_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
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


        {{-- modal --}}
        <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTypeModalLabel">เพิ่มกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTypeForm" action="{{ route('type_insert') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
                                <input type="text" class="form-control" id="type_name" name="type_name" required>
                                <input type="hidden" name="created_at" value="{{ \Carbon\Carbon::now() }}">
                                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('script')

@endsection
