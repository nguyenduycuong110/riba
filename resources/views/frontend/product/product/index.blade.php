@php
    $name = $product->name;
    $canonical = write_url($product->canonical);
    $image = image($product->image);
    $price = getPrice($product);
    $catName = $productCatalogue->name;
    $review = getReview($product);
    $description = $product->description;
    $attributeCatalogue = $product->attributeCatalogue;
    $gallery = json_decode($product->album);
    $iframe = $product->iframe;
    $total_lesson = $product->total_lesson;
    $lessionContent = explode(',', $product->lession_content);
    // dd($price);
@endphp
@extends('frontend.homepage.layout')
@section('content')
 @php
    $breadcrumbImage = !empty($productCatalogue->album) ? json_decode($productCatalogue->album, true)[0] : asset('userfiles/image/system/breadcrumb.png');
    @endphp
<div class="product-container">
    <div class="cources-info">
        <div class="uk-container uk-container-center uk-container-1260">
            <div class="panel-body">
                @include('frontend.product.product.component.detail', ['product' => $product, 'productCatalogue' => $productCatalogue])
            </div>
        </div>
    </div>
    <div class="uk-container uk-container-center">
        <div class="main-content product-main-content mt30">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-medium-3-4">
                    <div class="tabs-content">
                        <ul data-uk-switcher="{connect:'#my-id'}" class="nab-tavs uk-grid uk-grid-collapse uk-width-small-1-2 uk-grid-width-medium-1-4">
                            <li  class="uk-active"><a href="">Tổng Quan</a></li>
                            <li><a href="">Chương trình</a></li>
                            <li><a href="">Giảng Viên</a></li>
                            <li ><a href="">Đánh Giá</a></li>
                        </ul>

                        <ul id="my-id" class="uk-switcher">
                            <li>
                                <div class="product-tabs-content">
                                    {!! $product->content !!}
                                </div>
                            </li>
                            <li >
                                <div class="product-tabs-content">

                                    <div class="uk-accordion" data-uk-accordion>
                                        @if(!is_null($product->chapter) && count($product->chapter) && is_array($product->chapter) )
                                        @foreach($product->chapter as $key => $chapter)
                                        @php
                                            $chapterName = explode('-', $chapter['title']);
                                        @endphp
                                        <div class="chapter uk-accordion-title">
                                            <div class="chapter-item">
                                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                    <div class="chapter-content">
                                                        <div class="chapter-title">{{ $chapterName[0] }}</div>
                                                        <div class="chapter-description">{{ $chapterName[1] ?? '-' }}</div>
                                                    </div>
                                                    <div class="chapter-action">
                                                        <span class="unlock">Mở khóa</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($chapter['content']) && count($chapter['content']))
                                            <div class="uk-accordion-content">
                                                <div class="chapter-lession">
                                                    @foreach($chapter['content'] as $index => $chapterContent)
                                                    <div class="lesstion-item">
                                                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                            <div class="lesstion-content uk-flex uk-flex-middle">
                                                                <div class="number">{{ $index + 1 }}</div>
                                                                <div>
                                                                    <div class="title">{{ $chapterContent['title'] }}</div>
                                                                    <div class="description">{{ $chapterContent['description'] }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="lession-info">
                                                                <div class="uk-flex uk-flex-middle">
                                                                    <span class="time">{{ $chapterContent['time'] }}</span>
                                                                    <span class="lession-type">{{ $chapterContent['type'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                         @endforeach
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li >
                                <div class="product-tabs-content">
                                    <div class="teacher-head uk-text-center">
                                        <span class="image"><img src="{{ $product->lecturers->image }}" alt=""></span>
                                        <div class="teacher-name text-bold">{{ $product->lecturers->name }}</div>
                                        <div class="teacher-position">{{ $product->lecturers->position }}</div>
                                    </div>
                                    <div class="teacher-description">
                                        {!! $product->lecturers->description !!}
                                    </div>
                                </div>
                            </li>
                            <li>
                                @include('frontend.product.product.component.review', ['model' => $product, 'reviewable' => 'App\Models\Product'])
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="uk-width-medium-1-4">
                    <div>
                        <div class="product-price-box">
                            <div class="price-content">
                                @if($price['percent'] > 0)
                                <div class="price-old">{{ convert_price($price['price'], true) }}đ</div>
                                @endif
                                <div class="price-new">
                                    {{ $price['percent'] > 0 ? convert_price($price['priceSale'], true) : convert_price($price['price'], true) }}
                                </div>
                                @if($price['percent'] > 0)
                                <div class="price-save">Tiết kiệm: {{ convert_price($price['price'] - $price['priceSale'], true) }}đ</div>
                                @endif
                            </div>
                            <div class="cart-button">
                                <button class="addToCart" data-id="{{ $product->id }}">Thêm vào giỏ hàng</button>
                                <button class="addToCart" data-redirect="1" data-id="{{ $product->id }}">Mua ngay</button>
                            </div>
                            @if($price['percent'] > 0)
                                <div class="discount-time">⏰ Ưu đãi kết thúc sau {{ $promotionLeft }} ngày</div>
                            @endif
                        </div>
                        
                        <div class="course-content">
                            <div class="title">Khóa học bao gồm:</div>
                            @if(is_array($lessionContent) && count($lessionContent))
                            <ul class="uk-list uk-clearfix">
                                @foreach($lessionContent as $key => $val)
                                <li><span>{{ $val }}</span></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="uk-container uk-container-center">
            <div class="product-related mt30 mb30">
                <div class="uk-container uk-container-center">
                    <div class="panel-product">
                        <div class="main-heading">
                            <div class="panel-head">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <h2 class="heading-2" style="text-transform:uppercase"><span>Khóa học tương tự</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body list-product">
                            @if(count($productCatalogue->products))
                                 <div class="product-related-wrapper uk-grid uk-grid-medium">
                                    @foreach($productCatalogue->products as $index => $product)
                                        <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                                            @include('frontend.component.p-item', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
