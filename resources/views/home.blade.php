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
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
            aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
            aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('/img/banner_images/1.png') }}" class="d-block w-100 rounded" alt="Banner 1">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('/img/banner_images/2.png') }}" class="d-block w-100 rounded" alt="Banner 2">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('/img/banner_images/3.png') }}" class="d-block w-100 rounded" alt="Banner 3">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('/img/banner_images/4.png') }}" class="d-block w-100 rounded" alt="Banner 4">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('/img/banner_images/5.png') }}" class="d-block w-100 rounded" alt="Banner 5">
          </div>
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
          data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
          <i class="tf-icons bx bx-home"></i> ประกาศ
          <!-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span> -->
        </button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
          data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
          <i class="tf-icons bx bx-user"></i> เอกสาร
        </button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
          data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
          <i class="tf-icons bx bx-message-square"></i> แบบฟอร์ม
        </button>
      </li>

    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
        <table id="example2" class="table table-hover align-items-center">
          <thead class='text-center bg-dark'>
            <tr class="col-12">

              <th class='col-3'>หัวข้อ</th>
              <th class='col-6'>คำอธิบาย</th>
              <th class='col-2'>วันที่อัพโหลด</th>
              <th class='col-1'>Action</th>


            </tr>
          </thead>

          <tbody class='align-items-center '>
            <tr>
              @foreach ($data->take(10) as $item1)
          <td class='ms-5 text-center'>
          <div>
            {{ $item1->name }}
            @if ($loop->index < 2)
        <!-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">New</span> -->
      @endif
          </div>
          </td>
          <td class='ms-5 text-center'>
          <div>
            {{ $item1->description }}

          </div>
          </td>

          <td class='ms-5 text-center'>
          <div>
            {{ \Carbon\Carbon::parse($item1->created_at)->format('Y-m-d') }}
          </div>
          </td>
          <td class='ms-5 text-center'>
          @if(Storage::disk('public')->exists($item1->file))
        <a href="{{ route('admin.download', $item1->id) }}" class="btn btn-warning col-1" style="width: 130px;">
        Download <i class="fas fa-arrow-down"></i>
        </a>
      @else
      <span class="text-danger">ไฟล์ไม่พบ</span>
    @endif
          </td>
        </tr>

      @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
        <p>
          --------
        </p>
      </div>
      <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
        <p>
          --------
        </p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <div class="card mt-4 text-center">
        <br>
        <br>
        <br>
        <h1>Content</h1>
        <br>
        <br>
        <br>

      </div>
    </div>
    <div class="col-9">
      <div class="card mt-4 text-center">
        <br>
        <br>
        <br>
        <h1>Content</h1>
        <br>
        <br>
        <br>
      </div>
    </div>

    <div class="card mt-4 text-center">
      <br>
      <br>
      <br>
      <h1>Content</h1>
      <br>
      <br>
      <br>

    </div>

  </div>









</div>
@endsection