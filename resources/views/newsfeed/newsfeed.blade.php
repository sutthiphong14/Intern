@extends('admins.index')
@section('title')
รายการข้อมูลข่าวสาร
@endsection
@section('header')
รายการข้อมูลข่าวสาร
@endsection

@section('css')
@endsection
@section('content')

<div class="card mt-3 mb-3">
  <div class="d-flex justify-content-between align-items-center gap-2">
    <!-- หัวข้อ -->
    <h3 class="card-header">รายการข่าว</h3>

    <div class="d-flex align-items-center gap-2 me-4">
      <!-- เพิ่มฟอร์มค้นหา -->
      <form method="GET" action="{{ route('newsfeed') }}">
        <div class="input-group">
          <input type="text" class="form-control" name="search" placeholder="ค้นหาข้อมูล..."
            value="{{ request('search') }}">
          <select class="form-control" name="category">
            <option value="">เลือกหมวดหมู่</option>
            <option value="ข่าว" {{ request('category') == 'ข่าว' ? 'selected' : '' }}>ข่าว</option>
            <option value="เอกสาร" {{ request('category') == 'เอกสาร' ? 'selected' : '' }}>เอกสาร</option>
            <option value="แบบฟอร์ม" {{ request('category') == 'แบบฟอร์ม' ? 'selected' : '' }}>แบบฟอร์ม</option>
          </select>
          <button class="btn btn-dark" type="submit">ค้นหา</button>
        </div>
      </form>


    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="example2" class="table table-hover align-items-center">
        <thead class="text-center bg-dark">
          <tr class="col-12">
            <th class="col-4">หัวข้อ</th>
            <th class="col-4">คำอธิบาย</th>
            <th class="col-2">วันที่อัพโหลด</th>
            <th class="col-1"> หมวดหมู่</th>
            <th class="col-1">Action</th>
          </tr>
        </thead>

        <tbody class="align-items-center">
          @foreach ($data_all as $item)
        <tr>
        <td class="ms-5 text-start">
          <div>
          {{ $item->name }}
          @if ($item->id == $latestNewsId) <!-- ตรวจสอบว่าเป็นข่าวล่าสุด -->
        <span class="badge bg-label-danger"> New</span>
      @endif
          </div>
        </td>
        <td class="ms-5 text-start">
          <div>{{ $item->description }}</div>
        </td>
        <td class="ms-5 text-center">
          <div>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</div>
        </td>
        <td class="ms-5 text-center">
          <div>
          {{ $item->categories }}
          </div>
        </td>
        <td class="ms-5 text-center">
          <div>
          @if ($item->content_type === 'file')
        @if(Storage::disk('public')->exists($item->file))
      <a href="{{ route('admin.download', $item->id) }}" class="btn btn-warning col-1" style="width: 130px;">
      Download <i class="fas fa-arrow-down"></i>
      </a>
    @else
    <span class="text-danger">ไฟล์ไม่พบ</span>
  @endif
      @elseif ($item->content_type === 'link')
      @if (!empty($item->link))
      <a href="{{ $item->link }}" target="_blank" class="btn btn-info col-1" style="width: 130px;">
      Link <i class="fas fa-external-link-alt"></i>
      </a>
    @else
      <span class="text-danger">ลิงก์ไม่พบ</span>
    @endif
    @elseif ($item->content_type === 'youtube')
      @if (!empty($item->youtube))
      <a href="{{ $item->youtube }}" target="_blank" class="btn btn-danger col-1" style="width: 130px;">
      Video <i class="fas fa-play-circle"></i>
      </a>
    @else
      <span class="text-danger">วิดีโอไม่พบ</span>
    @endif
    @else
      <span class="text-muted">ประเภทไม่ถูกต้อง</span>
    @endif
          </div>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      <!-- Pagination -->
      <div class="d-flex justify-content-center align-items-center me-4 mt-3">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            @if ($data_all->onFirstPage())
        <li class="page-item disabled">
          <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
        </li>
        <li class="page-item disabled">
          <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
        </li>
      @else
    <li class="page-item">
      <a class="page-link" href="{{ $data_all->appends(request()->query())->url(1) }}">
      <i class="tf-icon bx bx-chevrons-left"></i>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="{{ $data_all->appends(request()->query())->previousPageUrl() }}">
      <i class="tf-icon bx bx-chevron-left"></i>
      </a>
    </li>
  @endif

            @foreach ($data_all->appends(request()->query())->getUrlRange(1, $data_all->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $data_all->currentPage() ? 'active' : '' }}">
          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
      @endforeach

            @if ($data_all->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $data_all->appends(request()->query())->nextPageUrl() }}">
          <i class="tf-icon bx bx-chevron-right"></i>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="{{ $data_all->appends(request()->query())->url($data_all->lastPage()) }}">
          <i class="tf-icon bx bx-chevrons-right"></i>
          </a>
        </li>
      @else
    <li class="page-item disabled">
      <span class="page-link"><i class="tf-icon bx bx-chevron-right"></i></span>
    </li>
    <li class="page-item disabled">
      <span class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></span>
    </li>
  @endif



      </div>
    </div>

  </div>








  <script>
    // SweetAlert function for unauthorized access
    function showUnauthorizedAlert() {
      Swal.fire({
        icon: 'warning',
        title: 'ไม่มีสิทธิเข้าถึง',
        text: 'กรุณาเข้าสู่ระบบเพื่อใช้งานฟังก์ชันนี้',
        confirmButtonText: 'ตกลง',
      });
    }
  </script>

  @endsection

  @section('script')

  @endsection