@extends('admins.index')
@section('title')
  หน้าแรก
@endsection
@section('header')
  หน้าแรก
@endsection
@section('content')
  <div class="content-wrapper">
    <div class="card ">
    <div class="slide">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-interval="500">
      <div class="carousel-indicators">
        @if($banners->isNotEmpty())
      @foreach($banners as $key => $banner)
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}"
      class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
      aria-label="Slide {{ $key + 1 }}"></button>
    @endforeach
    @endif
      </div>
      <div class="carousel-inner">
        @if($banners->isNotEmpty())
      @foreach($banners as $key => $banner)
      <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
      @if($banner->slideshow_link)
      <a href="{{ $banner->slideshow_link }}" target="_blank">
      <img src="{{ asset('storage/' . $banner->slideshow_image) }}" class="d-block w-100 rounded"
      alt="Banner {{ $key + 1 }}">
      </a>
    @else
      <img src="{{ asset('storage/' . $banner->slideshow_image) }}" class="d-block w-100 rounded"
      alt="Banner {{ $key + 1 }}">
    @endif
      </div>
    @endforeach
    @else
    <div class="carousel-item active">
    <img src="{{ asset('storage/banner/none.png') }}" class="d-block w-100 rounded" alt="Default Banner">
    </div>
  @endif
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
      </div>
    </div>




    </div>


    <div class="nav-align-top mt-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
      <li class="nav-item ">
      <button type="button" class="nav-link active text-dark" role="tab" data-bs-toggle="tab"
        data-bs-target="#navs-justified-announce" aria-controls="navs-justified-announce" aria-selected="true">
        <i class="fas fa-bullhorn"> ประกาศ</i>
        <!-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span> -->
      </button>
      </li>
      <li class="nav-item">
      <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
        data-bs-target="#navs-justified-document" aria-controls="navs-justified-document" aria-selected="false">
        <i class="fas fa-file"> เอกสาร</i>
      </button>
      </li>
      <li class="nav-item">
      <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
        data-bs-target="#navs-justified-form" aria-controls="navs-justified-form" aria-selected="false">
        <i class="fas fa-sticky-note"> แบบฟอร์ม</i>
      </button>
      </li>

    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="navs-justified-announce" role="tabpanel">
      <table id="example2" class="table table-hover align-items-center">
        <thead class="text-center bg-dark">
        <tr class="col-12">
          <th class="col-4">หัวข้อ</th>
          <th class="col-5">คำอธิบาย</th>
          <th class="col-2">วันที่อัพโหลด</th>
          <th class="col-1">Action</th>
        </tr>
        </thead>

        <tbody class="align-items-center">
        @foreach ($data_announce as $item)
      <tr>
        <td class="ms-5 text-start">
        <div>
        {{ $item->name }}
        @if ($item->id == $latestNewsId) <!-- ตรวจสอบว่าเป็นข่าวล่าสุด -->
      <span class="badge bg-label-danger"> New</span>
    @endif
        </div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ $item->description }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>
        @if ($item->content_type === 'file')
      @if(Storage::disk('public')->exists($item->file))
      <a href="{{ route('admin.download', $item->id) }}" class="btn btn-warning col-1"
      style="width: 130px;">
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
      <div class="d-flex justify-content-center align-items-center me-4">
        <nav aria-label="Page navigation">
        <ul class="pagination">
          @if ($data_announce->onFirstPage())
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
        </li>
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
        </li>
      @else
      <li class="page-item">
      <a class="page-link" href="{{ $data_announce->appends(request()->query())->url(1) }}">
      <i class="tf-icon bx bx-chevrons-left"></i>
      </a>
      </li>
      <li class="page-item">
      <a class="page-link" href="{{ $data_announce->appends(request()->query())->previousPageUrl() }}">
      <i class="tf-icon bx bx-chevron-left"></i>
      </a>
      </li>
    @endif

          @foreach ($data_announce->appends(request()->query())->getUrlRange(1, $data_announce->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $data_announce->currentPage() ? 'active' : '' }}">
        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
      @endforeach

          @if ($data_announce->hasMorePages())
        <li class="page-item">
        <a class="page-link" href="{{ $data_announce->appends(request()->query())->nextPageUrl() }}">
        <i class="tf-icon bx bx-chevron-right"></i>
        </a>
        </li>
        <li class="page-item">
        <a class="page-link"
        href="{{ $data_announce->appends(request()->query())->url($data_announce->lastPage()) }}">
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
        </ul>
        </nav>
      </div>

      <div class="">
        <a href="newsfeed" class="text-warning">แสดงเพิ่มเติม</a>
      </div>
      </div>

      <div class="tab-pane fade " id="navs-justified-document" role="tabpanel">
      <table id="example2" class="table table-hover align-items-center">
        <thead class="text-center bg-dark">
        <tr class="col-12">
          <th class="col-4">หัวข้อ</th>
          <th class="col-5">คำอธิบาย</th>
          <th class="col-2">วันที่อัพโหลด</th>
          <th class="col-1">Action</th>
        </tr>
        </thead>

        <tbody class="align-items-center">
        @foreach ($data_document as $item)
      <tr>
        <td class="ms-5 text-start">
        <div>
        {{ $item->name }}
        @if ($loop->index < 2)
      <span class="badge bg-label-danger"> New</span>
    @endif
        </div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ $item->description }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>
        @if ($item->content_type === 'file')
      @if (Storage::disk('public')->exists($item->file))
      <a href="{{ auth()->check() ? route('admin.download', $item->id) : 'javascript:void(0)' }}"
      class="btn btn-warning col-1 download-btn" style="width: 130px;" @if (!auth()->check())
    onclick="showUnauthorizedAlert()" @endif>
      Download <i class="fas fa-arrow-down"></i>
      </a>
    @else
      <span class="text-danger">ไฟล์ไม่พบ</span>
    @endif
    @elseif ($item->content_type === 'link')
    @if (!empty($item->link))
    <a href="{{ auth()->check() ? $item->link : 'javascript:void(0)' }}"
    class="btn btn-info col-1 link-btn" style="width: 130px;" @if (!auth()->check())
  onclick="showUnauthorizedAlert()" @endif>
    Link <i class="fas fa-external-link-alt"></i>
    </a>
  @else
  <span class="text-danger">ลิงก์ไม่พบ</span>
@endif
  @elseif ($item->content_type === 'youtube')
  @if (!empty($item->youtube))
    <a href="{{ auth()->check() ? $item->youtube : 'javascript:void(0)' }}"
    class="btn btn-danger col-1 video-btn" style="width: 130px;" @if (!auth()->check())
  onclick="showUnauthorizedAlert()" @endif>
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
      <div class="d-flex justify-content-center align-items-center me-4">

        <nav aria-label="Page navigation">
        <ul class="pagination">
          @if ($data_document->onFirstPage())
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
        </li>
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
        </li>
      @else
      <li class="page-item">
      <a class="page-link" href="{{ $data_document->appends(request()->query())->url(1) }}">
      <i class="tf-icon bx bx-chevrons-left"></i>
      </a>
      </li>
      <li class="page-item">
      <a class="page-link" href="{{ $data_document->appends(request()->query())->previousPageUrl() }}">
      <i class="tf-icon bx bx-chevron-left"></i>
      </a>
      </li>
    @endif

          @foreach ($data_document->appends(request()->query())->getUrlRange(1, $data_document->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $data_document->currentPage() ? 'active' : '' }}">
        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
      @endforeach

          @if ($data_document->hasMorePages())
        <li class="page-item">
        <a class="page-link" href="{{ $data_document->appends(request()->query())->nextPageUrl() }}">
        <i class="tf-icon bx bx-chevron-right"></i>
        </a>
        </li>
        <li class="page-item">
        <a class="page-link"
        href="{{ $data_document->appends(request()->query())->url($data_document->lastPage()) }}">
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
        </ul>
        </nav>
      </div>

      <div class="">
        <a href="newsfeed" class="text-warning">แสดงเพิ่มเติม</a>
      </div>
      </div>



      <div class="tab-pane fade" id="navs-justified-form" role="tabpanel">
      <table id="example2" class="table table-hover align-items-center">
        <thead class="text-center bg-dark">
        <tr class="col-12">
          <th class="col-4">หัวข้อ</th>
          <th class="col-5">คำอธิบาย</th>
          <th class="col-2">วันที่อัพโหลด</th>
          <th class="col-1">Action</th>
        </tr>
        </thead>

        <tbody class="align-items-center">
        @foreach ($data_form as $item)
      <tr>
        <td class="ms-5 text-start">
        <div>
        {{ $item->name }}
        @if ($loop->index < 2)
      <span class="badge bg-label-danger"> New</span>
    @endif
        </div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ $item->description }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</div>
        </td>
        <td class="ms-5 text-center">
        <div>
        @if ($item->content_type === 'file')
      @if(Storage::disk('public')->exists($item->file))
      <a href="{{ route('admin.download', $item->id) }}" class="btn btn-warning col-1"
      style="width: 130px;">
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
      <div class="d-flex justify-content-center align-items-center me-4">
        <nav aria-label="Page navigation">
        <ul class="pagination">
          @if ($data_form->onFirstPage())
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
        </li>
        <li class="page-item disabled">
        <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
        </li>
      @else
      <li class="page-item">
      <a class="page-link" href="{{ $data_form->appends(request()->query())->url(1) }}">
      <i class="tf-icon bx bx-chevrons-left"></i>
      </a>
      </li>
      <li class="page-item">
      <a class="page-link" href="{{ $data_form->appends(request()->query())->previousPageUrl() }}">
      <i class="tf-icon bx bx-chevron-left"></i>
      </a>
      </li>
    @endif

          @foreach ($data_form->appends(request()->query())->getUrlRange(1, $data_form->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $data_form->currentPage() ? 'active' : '' }}">
        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
      @endforeach

          @if ($data_form->hasMorePages())
        <li class="page-item">
        <a class="page-link" href="{{ $data_form->appends(request()->query())->nextPageUrl() }}">
        <i class="tf-icon bx bx-chevron-right"></i>
        </a>
        </li>
        <li class="page-item">
        <a class="page-link" href="{{ $data_form->appends(request()->query())->url($data_form->lastPage()) }}">
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
        </ul>
        </nav>
      </div>

      <div class="">
        <a href="newsfeed" class="text-warning">แสดงเพิ่มเติม</a>
      </div>
      </div>



    </div>


    <div class="card mt-4">

      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($album_event as $event)
      @foreach($image_events->where('event_id', $event->event_id) as $key => $image)
      <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
      <div class="carousel-image-container">
      <!-- ลิงก์ไปยังหน้ากิจกรรมที่เกี่ยวข้อง -->
      <a href="{{ route('events.list') }}">
      <img src="{{ asset('storage/' . $image->image_event) }}" class="d-block w-100" alt="Image">
      </a>
      <h3 class="carousel-caption text-start ms-3">{{ $event->nameevent }}</h3>
      </div>
      </div>
    @endforeach
    @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
      </div>

    </div>

    </div>
  </div>


  <style>
    #carouselExampleControls {
    width: 100%;
    height: 1080;
    overflow: hidden;
    }

    /* เอฟเฟกต์พื้นหลังดำเมื่อ hover ทั้ง Carousel */
    #carouselExampleControls:hover::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 1080px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(255, 255, 255, 0));
    z-index: 1;
    animation: fadeIn 0.4s ease-in-out forwards;
    }

    /* Animation สำหรับพื้นหลัง fade-in */
    @keyframes fadeIn {
    0% {
      opacity: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0), rgba(255, 255, 255, 0));
    }

    100% {
      opacity: 1;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(255, 255, 255, 0));
    }
    }

    /* ทำให้ชื่ออัลบั้มแสดงขึ้นเมื่อ hover ทั้ง carousel */
    #carouselExampleControls:hover .carousel-caption {
    opacity: 1;
    transform: translateY(0);
    }

    /* ปรับแต่งชื่อกิจกรรม */
    .carousel-caption {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
    padding: 10px;
    font-size: 3em;
    z-index: 2;
    opacity: 0;
    /* ซ่อนเริ่มต้น */
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
    }
  </style>


 <!-- เพิ่ม SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // เช็คว่ามี session success หรือ error หรือไม่
        @if(session('success'))
            Swal.fire({
                title: "สำเร็จ!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "ตกลง"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน",
                text: "{{ session('error') }}",
                confirmButtonText: "ตกลง"
            });
        @endif
    });
</script>


  
@endsection