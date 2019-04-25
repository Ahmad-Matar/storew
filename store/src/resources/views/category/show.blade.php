@extends('app')


@section('content')
@include('pages.partials.side-nav')
    <div id="">

    


        <div class="container-fluid">

            <h3 class="text-center">
                @foreach($categories as $category)
                    {{ $category->category }}
                @endforeach
            </h3>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort By
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('category.newest', $category->id) }}">Newest</a></li>
                    <li><a href="{{ route('category.lowest', $category->id) }}">Price Lowest</a></li>
                    <li><a href="{{ route('category.highest', $category->id) }}"> Price Highest</a></li>
                    <li><a href="{{ route('category.alpha.lowest', $category->id) }}">Product A-Z</a></li>
                    <li><a href="{{ route('category.alpha.highest', $category->id) }}">Product Z-A</a></li>
                </ul>
            </div>


            <br>
            <p>{{ $count }} {{ str_plural('product', $count) }}</p>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-12 wow slideInLeft" id="product-sub-container">
                        <div class="col-md-4 text-center hoverable">
                            <a href="{{ route('show.product', $product->product_name) }}">
                            @if ($product->photos->count() === 0)
                                    <img src="/store/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="Product-similar-Image">
                            @else
                                @if ($product->featuredPhoto)
                                    <img src="/store/{{ $product->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $product->featuredPhoto->id }}" />
                                @elseif(!$product->featuredPhoto)
                                    <img src="/store/{{ $product->photos->first()->thumbnail_path}}" alt="Photo" />
                                @else
                                    N/A
                                @endif
                            @endif
                            </a>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ route('show.product', $product->product_name) }}">
                            <h5 class="center-on-small-only">{{ $product->product_name }}</h5>
                            <h6 class="center-on-small-only">Brand: {{ $product->brand->brand_name }}</h6>
                            <p style="font-size: .9em;">{!! nl2br(str_limit($product->description, $limit = 200, $end = '...')) !!}</p>
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            @if($product->reduced_price == 0)
                                $ {{  $product->price }}
                                <br>
                            @else
                                <div class="text-danger list-price"><s>$ {{ $product->price }}</s></div>
                                $ {{ $product->reduced_price }}
                            @endif
                            <br><br><br>
                                <form action="/store/cart/add" method="post" name="add_to_cart">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="product" value="{{$product->id}}" />
                                    <input type="hidden" name="qty" value="1" />
                                    <button class="btn btn-default waves-effect waves-light">ADD TO CART</button>
                                </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>  <!-- close container-fluid-->

    </div> <!-- close wrapper -->

@endsection

@section('footer')

@endsection