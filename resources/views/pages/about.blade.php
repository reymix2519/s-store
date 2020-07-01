@extends('layouts.master')

@section('title', 'Giới Thiệu')

@section('content')

  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('header.Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giới Thiệu</li>
      </ol>
    </nav>
  </section>

  <div class="site-about">
    <section class="section-advertise">
      <div class="content-advertise">
        <div id="slide-advertise" class="owl-carousel">
          @foreach($advertises as $advertise)
            <div class="slide-advertise-inner" style="background-image: url('{{ Helper::get_image_advertise_url($advertise->image) }}');" data-dot="<button>{{ $advertise->title }}</button>"></div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-about">
      <div class="section-header">
        <h2 class="section-title">Giới Thiệu Nhóm 2</h2>
      </div>
      <div class="section-content">
        <div class="row">
          <div class="col-md-9 col-sm-8">
            <div class="content-left">
              <div class="note">
                <div class="note-icon"><i class="fas fa-info-circle"></i></div>
                <div class="note-content">
                  <p>Website <strong>S-Store</strong> là một sản phẩm của nhóm 2. Được lên ý tưởng, thức hiện và hoàn thiện bởi tất cả mọi thành viên của nhóm 2 cùng với một số nguồn đáng tin cậy từ trường <i>Đại học Bách khoa, Cao đẳng nghề FPT và <strong>Google</strong></i>.</p>
                </div>
              </div>
              <div class="content">

                <p><strong>Đinh Quang Anh (CEO)</strong>
                <p>MSV: 17104091_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/QuangAnh2519"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Trịnh Tứ Kiệt </strong>
                <p>MSV: 17100220_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/kaku.mun"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Cồ Thị Thanh </strong>
                <p>MSV: 17100291_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/cothithanh9999"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Trần Thị Nguyệt Quế </strong>
                <p>MSV: 17105565_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/nguyetque1999"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Hoàng Anh Tú </strong>
                <p>MSV: 17100271_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/tu.degea"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Trần Huy Tuấn </strong>
                <p>MSV: 17100271_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/profile.php?id=100052294313450"> <u><i>Link Facebook</u></i></a></p>

                <p><strong>Trần Tiến Tùng </strong>
                <p>MSV: 17100271_TH22.04_HUBT</p>
                <p>More Information:
                <a href = "https://www.facebook.com/mousekillerr"> <u><i>Link Facebook</u></i></a></p>
                
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            <div class="content-right">
              <div class="online_support">
                <h2 class="title">CHÚNG TÔI LUÔN SẴN SÀNG<br>ĐỂ GIÚP ĐỠ BẠN</h2>
                <img src="{{ asset('images/support_online.jpg') }}">
                <h3 class="sub_title">Để được hỗ trợ tốt nhất. Hãy gọi</h3>
                <div class="phone">
                  <a href="tel:18002508" title="1800 2508">1800 2508</a>
                </div>
                <div class="or"><span>HOẶC</span></div>
                <h3 class="title">Chat hỗ trợ trực tuyến</h3>
                <h3 class="sub_title">Alo nếu cần người tư vẫn hay tâm sự :))</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

@endsection

@section('css')
  <style>
    .slide-advertise-inner {
      background-repeat: no-repeat;
      background-size: cover;
      padding-top: 21.25%;
    }
    #slide-advertise.owl-carousel .owl-item.active {
      -webkit-animation-name: zoomIn;
      animation-name: zoomIn;
      -webkit-animation-duration: .6s;
      animation-duration: .6s;
    }
  </style>
@endsection

@section('js')
  <script>
    $(document).ready(function(){

      $("#slide-advertise").owlCarousel({
        items: 2,
        autoplay: true,
        loop: true,
        margin: 10,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        responsive:{
          0:{
            items: 1,
          },
          992:{
            items: 2,
            animateOut: 'zoomInRight',
            animateIn: 'zoomOutLeft',
          }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
      });
    });
  </script>
@endsection
