


<div class="item" id="tf-home-parallax">
    <div class="view overlay hm-blue-slight">
        <a><img src="/store/src/public/images/slider/main_4.jpg" alt="Welcome To Our Humble Watches Store">
            <div class="mask waves-effect waves-light"></div>
        </a>
        <div class="carousel-caption">
            <div class="animated fadeInDown">
                <h3><strong><span class="color">Shop By Brands</span></strong></h3>
                @foreach($rand_brands as $rand)
                    <h6 class="text-center" id="random_brands"><a href="{{ url('brand', $rand->id) }}">{{ $rand->brand_name }}</a></h6>
                @endforeach
            </div>
        </div>
    </div>
</div>