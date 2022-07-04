<style>
    .img_1 {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
  height: 150px;
    }

  .curveBG {
  background: -moz-linear-gradient(top, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  background: -webkit-linear-gradient(top, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  background: linear-gradient(to bottom, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4debebeb', endColorstr='#768693',GradientType=0 );
  padding: 90px 0 140px 0;
  position: relative;
  z-index: 0; }
  .curveBG:before {
    content: '';
    width: 100%;
    height: 100%;
    background-image: url(../images/product/curveBG.jpg);
    background-repeat: no-repeat;
    background-position: bottom center;
    background-size: cover;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    mix-blend-mode: luminosity;
    opacity: 0.6;
    z-index: -1; }

.gal-txt-section {
  width: 30%;
  position: absolute;
  bottom: 30%; }
  .gal-txt-section h3.BK-BG {
    float: left;
    font-size: 24px;
    letter-spacing: 0.06rem;
    padding: 5px 22px;
    margin: 0 0 25px 0;
    display: block; }
  .gal-txt-section .txt-content {
    margin-bottom: 0; }
    .gal-txt-section .txt-content p {
      color: #253746; }

.partnerGal-slide {
  background-color: white;
  padding: 10px;
  z-index: 99; }
  .partnerGal-slide .owl-theme .owl-nav {
    margin-top: 0; }
    .partnerGal-slide .owl-theme .owl-nav [class*='owl-'] {
      -webkit-transition: all .3s ease;
      transition: all .3s ease; }
      .partnerGal-slide .owl-theme .owl-nav [class*='owl-'].disabled:hover {
        background-color: #D6D6D6; }
  .partnerGal-slide .big-img.owl-theme {
    margin-bottom: 12px; }
    .partnerGal-slide .big-img.owl-theme .owl-prev, .partnerGal-slide .big-img.owl-theme .owl-next {
      width: 40px;
      height: 40px;
      background: rgba(19, 30, 41, 0.6);
      border: 1px solid white;
      border-radius: 50%;
      margin: 0;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      outline: none; }
      .partnerGal-slide .big-img.owl-theme .owl-prev:hover, .partnerGal-slide .big-img.owl-theme .owl-next:hover {
        background-color: #253746; }
    .partnerGal-slide .big-img.owl-theme i {
      font-size: 15px;
      color: white;
      line-height: 38px; }
    .partnerGal-slide .big-img.owl-theme .owl-prev {
      left: 15px; }
    .partnerGal-slide .big-img.owl-theme .owl-next {
      right: 15px; }
  .partnerGal-slide #thumbs .owl-nav {
    display: none; }
  .partnerGal-slide .owl-theme.navigation-thumbs .item {
    background-color: white;
    border: 1px solid white;
    cursor: pointer; }
    .partnerGal-slide .owl-theme.navigation-thumbs .item img {
      opacity: 0.6; }
  .partnerGal-slide .owl-theme.navigation-thumbs .owl-item.synced .item {
    border-color: #032033;
    z-index: 999; }
    .partnerGal-slide .owl-theme.navigation-thumbs .owl-item.synced .item img {
      opacity: 1; }

      .slide-navButton .owl-carousel .owl-nav .owl-prev, .slide-navButton .owl-carousel .owl-nav .owl-next {
    width: 36px;
    height: 36px; }
  .slide-navButton .owl-carousel .owl-nav i {
    font-size: 14px;
    line-height: 36px; }
  .slide-navButton .owl-carousel .owl-dots .owl-dot span {
    width: 9px;
    height: 9px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-prev, .slide-navButton.nav-out .owl-carousel .owl-nav .owl-next {
    width: 40px;
    height: 45px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-prev {
    left: -18px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-next {
    right: -18px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav i {
    font-size: 14px;
    line-height: 43px; }

</style>

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการรูปภาพการสั่งงาน</div>
                <div class="row">
                    @foreach ($gallerys as $value)
                        <div class="col-lg-2 col-md-4 col-sm-4 col-6 mb-10">
                            <div class="partnerGal-slide detail_slide" style="border: 1px solid #ddd;">
                                <div id="big" class="owl-carousel owl-theme big-img slider">
                                    <a class="item" data-fancybox="gallery" href="{{ isset($value->image) ? asset('public/upload/AssignmentFile/' . $value->image) : '' }}"><img src="{{ isset($value->image) ? asset('public/upload/AssignmentFile/' . $value->image) : '' }}"></a>
                                </div>
                            </div>
                            {{-- <img class="card-img img_1" src="{{ isset($value->image) ? asset('public/upload/ProductNewGallery/' . $value->image) : '' }}" alt="" style="max-width:100%;"> --}}
                        </div>
                    @endforeach
                </div>
            </section>

