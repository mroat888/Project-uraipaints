@extends('layouts.masterLead')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item">ข้อมูลข่าวสาร</li>
            <li class="breadcrumb-item active">รายละเอียดข่าวสาร</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-wifi"></i></span>รายละเอียดข่าวสาร</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('lead/news')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>

        @include('news_main_detail')

    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection


<script type="text/javascript">
    $('.detail_slide').each(function(){
        (function(_e){
    var sync1 = $(_e).find(".slider");
    var sync2 = $(_e).find(".navigation-thumbs");

    var thumbnailItemClass = '.owl-item';

    var slides = sync1.owlCarousel({
        video: true,
        startPosition: 0,
        items: 1,
        animateOut: 'fadeOut',
        loop: false,
        rewind: true,
        margin: 0,
        autoplay: false,
        autoplayHoverPause: true,
        autoplayTimeout: 7000,
        smartSpeed: 500,
        autoplayHoverPause: true,
        navText: [
            '<span><i class="fas fa-chevron-left"></i></span>',
            '<span><i class="fas fa-chevron-right"></i></span>'
        ],
        nav: true,
        dots: false
    }).on('changed.owl.carousel', syncPosition);

    function syncPosition(el) {
        $owl_slider = $(this).data('owl.carousel');
        var loop = $owl_slider.options.loop;

        if(loop){
        var count = el.item.count-1;
        var current = Math.round(el.item.index - (el.item.count/2) - .5);
        if(current < 0) {
            current = count;
        }
        if(current > count) {
            current = 0;
        }
        }else{
        var current = el.item.index;

        }
        console.log(current);

        var owl_thumbnail = sync2.data('owl.carousel');
        var itemClass = "." + owl_thumbnail.options.itemClass;


        var thumbnailCurrentItem = sync2
        .find(itemClass)
        .removeClass("synced")
        .eq(current);

        thumbnailCurrentItem.addClass('synced');

        //if (!thumbnailCurrentItem.hasClass('active')) {
        var duration = 300;
        sync2.trigger('to.owl.carousel',[current-2, duration, true]);
        //}
    }
    var thumbs = sync2.owlCarousel({
        startPosition: 0,
        items: 4,
        loop: false,
        margin: 10,
        autoplay: false,
        autoplayHoverPause: true,
        nav: true,
        navText: false,
        dots: false,
        responsive:{
            0:{
                items: 3,
                margin: 5
            },
            500:{
                margin: 5
            },
            768:{
                margin: 5
            },
            1201:{
                margin: 10
            }
        },
        onInitialized: function (e) {
        var thumbnailCurrentItem =  $(e.target).find(thumbnailItemClass).eq(this._current);
        thumbnailCurrentItem.addClass('synced');
        },
    })

    .on('click', thumbnailItemClass, function(e) {
        e.preventDefault();
        var duration = 300;
        var itemIndex =  $(e.target).parents(thumbnailItemClass).index();
        sync1.trigger('to.owl.carousel',[itemIndex, duration, true]);
    }).on("changed.owl.carousel", function (el) {
        //var number = el.item.index;
        //$owl_slider = sync1.data('owl.carousel');
        //$owl_slider.to(number, 100, true);
    });
    })(this);
    });

</script>
