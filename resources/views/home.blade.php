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
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src={{ asset('/img/banner_images/ceo_intranet.jpg') }} class="d-block w-100 rounded"
                            alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/nt_net_ban.jpg') }} class="d-block w-100 rounded"
                            alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/nt_sta-66.jpg') }} class="d-block w-100 rounded"
                            alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/S__31670320.jpg') }} class="d-block w-100 rounded"
                            alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/S__68780184V2.jpg') }} class="d-block w-100 rounded"
                            alt="Banner 3">
                    </div>
                </div>
                <a class="carousel-control-prev custom-control-prev" href="#carouselExampleIndicators" role="button"
                    data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next custom-control-next" href="#carouselExampleIndicators" role="button"
                    data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        
</div>


<div class="nav-align-top mt-4">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active "
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-home"
                          aria-controls="navs-justified-home"
                          aria-selected="true"
                        >
                          <i class="tf-icons bx bx-home"></i> ประกาศ
                          <!-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span> -->
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-profile"
                          aria-controls="navs-justified-profile"
                          aria-selected="false"
                        >
                          <i class="tf-icons bx bx-user"></i> เอกสาร
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-messages"
                          aria-controls="navs-justified-messages"
                          aria-selected="false"
                        >
                          <i class="tf-icons bx bx-message-square"></i> แบบฟอร์ม
                        </button>
                      </li>
                     
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                      <table id="example2" class="table table-hover align-items-center">

<tbody class='align-items-center '>
    @foreach ($data->take(10) as $item1)
        <tr class=>
            <td class='ms-5 text-center col-4'>
                <div>
                    {{ $item1->name }}
                    @if ($loop->index < 2)
                    <!-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">New</span> -->
                    @endif
                </div>
            </td>
            <td class='ms-5 text-center col-4'>
                <div>
                    {{ $item1->created_at }}
                   
                </div>
            </td>
            <td class='ms-5 text-center col-4'>
                @if(Storage::disk('public')->exists($item1->file))
                    <a href="{{ asset('storage/' . $item1->file) }}" class="btn btn-warning" download
                        target="_blank">
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
                          Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                          cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                          cheesecake fruitcake.
                        </p>
                        <p class="mb-0">
                          Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                          cotton candy liquorice caramels.
                        </p>
                      </div>
                      <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <p>
                          Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                          cupcake gummi bears cake chocolate.
                        </p>
                        <p class="mb-0">
                          Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                          roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                          jelly-o tart brownie jelly.
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
</div>

                

   
   
             
</div>
</div>
</div>
</div>
@endsection