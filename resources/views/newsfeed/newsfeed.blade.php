@extends('admins.index')
@section('title')
รายการข้อมูลข่าวสาร
@endsection
@section('header')
รายการข้อมูลข่าวสาร
@endsection

@section('css')
@endsection @section('content')



    <div class="card card-warning mt-3 mb-3 ">

        <div class="card-header d-flex justify-content-between align-items-center ">
            <h3 class="card-title col-5">ข่าวประชาสัมพันธ์ </h3>

        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <table id="example2" class="table table-hover ">
                <thead class='text-center col-12 bg-dark'>
                    <tr>

                        <th class='col-3'>หัวข้อ</th>
                        <th class='col-6'>คำอธิบาย</th>
                        <th class='col-2'>วันที่อัพโหลด</th>
                        <th class='col-1'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="text-center">
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                            <td class='ms-5 text-center'>
                                @if(Storage::disk('public')->exists($item->file))
                                    <a href="{{ route('admin.download', $item->id) }}" class="btn btn-warning col-1"
                                        style="width: 130px;">
                                        Download <i class="fas fa-arrow-down"></i>
                                    </a>
                                @else
                                    <span class="text-danger">ไฟล์ไม่พบ</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No results found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>







        </div>
        <!-- /.card-body -->


        <!-- Pagination -->
        <div class="d-flex justify-content-center align-items-center me-4">
            <nav aria-label="Page navigation ">
                <ul class="pagination">
                    <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}"><i
                                class="tf-icon bx bx-chevrons-left"></i></a>
                    </li>
                    <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}"><i
                                class="tf-icon bx bx-chevron-left"></i></a>
                    </li>
                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}"><i
                                class="tf-icon bx bx-chevron-right"></i></a>
                    </li>
                    <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}"><i
                                class="tf-icon bx bx-chevrons-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>


    </div>


    @endsection

    @section('script')

    @endsection