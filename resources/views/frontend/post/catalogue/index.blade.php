@extends('frontend.homepage.layout')
@section('content')
    @php
        $breadcrumbImage = !empty($postCatalogue->album) ? json_decode($postCatalogue->album, true)[0] : asset('userfiles/image/system/breadcrumb.png');
    @endphp
    <div class="post-catalogue page-wrapper intro-wrapper">
        <div class="uk-container uk-container-center">
            <div class="mt40 mb40 banner">
                <a href="" class="image img-cover">
                    <img src="{{ $system['background_1'] }}" alt="">
                </a>
                <div class="text-overlay">
                    @include('frontend.component.breadcrumb', [
                        'model' => $postCatalogue,
                        'breadcrumb' => $breadcrumb,
                    ])
                    <h1 class="heading-1"><span>{{ $postCatalogue->name }}</span></h1>
                    <div class="description">
                        {!! $postCatalogue->description !!}
                    </div>
                </div>
            </div>
            <div class="wrapper-bl">
                <div class="product-catalogue-wrapper">
                    <div class="uk-container uk-container-center">
                        @if(isset($postCatalogue->children) && !is_null($postCatalogue->children) )
                            <ul class="children">
                                @foreach($postCatalogue->children as $key => $item)
                                    @php
                                        $name = $item->short_name;
                                        $canonical = write_url($item->languages->first()->pivot->canonical);
                                    @endphp
                                    <li>
                                        <a href="{{ $canonical }}" title="{{ $name }}" class="{{ $item->languages->first()->pivot->canonical == $postCatalogue->canonical ? 'active' : '' }}">{{ $name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="post-container">
                    <div class="uk-container uk-container-center" style="padding-top:20px;padding-bottom:20px;">
                        <div class="uk-grid uk-grid-medium">
                            <div class="uk-width-large-3-4">
                                <div class="wrapper-1">
                                    <div class="uk-grid uk-grid-medium">
                                        @foreach($posts as $keyPost => $post)
                                        @php
                                            $name = $post->languages->first()->pivot->name;
                                            $canonical = write_url($post->languages->first()->pivot->canonical);
                                            $image = thumb($post->image, 600, 400);
                                            $description = cutnchar(strip_tags($post['description']), 150);
                                            $cat = $post->post_catalogues[0]->languages->first()->pivot->name;
                                        @endphp
                                        <div class="uk-width-medium-1-3 mb25">
                                            <div class="news-item">
                                                <a href="{{ $canonical }}" title="{{ $name }}" class="image img-cover img-zoomin">
                                                    <div class="skeleton-loading"></div>
                                                    <img class="lazy-image" data-src="{{ $image }}" alt="{{ $name }}">
                                                </a>
                                                <div class="info">
                                                    <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="uk-text-center">
                                        @include('frontend.component.pagination', ['model' => $posts])
                                    </div>    
                                </div>
                            </div>
                            <div class="uk-width-large-1-4">
                                <div class="post-aside">
                                    <div class="aside-form panel-contact aside-panel style-2">
                                        <div class="aside-heading">Đăng ký tư vấn</div>
                                        <div class="aside-body">
                                            <form action="" method="POST" class="register-form">
                                                <div class="form-group" bis_skin_checked="1">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="text" name="email" value="" class="form-input" id="reg_email" placeholder="Nhập vào email của bạn *" required="">
                                                </div>
                                                <div class="form-group" bis_skin_checked="1">
                                                    <label class="form-label" for="name">Họ tên</label>
                                                    <input type="text" name="name" value="" class="form-input" id="reg_name" placeholder="Nhập vào họ tên của bạn *" required="">
                                                </div>
                                                <div class="form-group" bis_skin_checked="1">
                                                    <label class="form-label" for="phone">Số điện thoại</label>
                                                    <input type="text" name="phone" value="" class="form-input" id="reg_phone" placeholder="Nhập vào số điện thoại của bạn *" required="">
                                                </div>
                                                <div class="form-group" bis_skin_checked="1">
                                                    <label class="form-label" for="product_id">Khóa học quan tâm</label>
                                                    <input type="text" name="product_id" value="" class="form-input" id="reg_product_name" placeholder="Nhập vào tên khóa học bạn quan tâm *" required="">
                                                </div>
                                                <div class="form-group" bis_skin_checked="1">
                                                    <label class="form-label" for="message">Lời nhắn</label>
                                                    <textarea name="message" class="form-input" id="reg_message" cols="30" rows="10" placeholder="Lời nhắn của bạn *"></textarea>
                                                </div>
                                                
                                                <button type="submit" class="register-btn" id="">
                                                    Đăng ký ngay
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @if(count($widgets['product-catalogue']->object))
                                
                                    <div class="aside-product-category aside-panel style-2">
                                        <div class="aside-heading">Danh mục khóa học</div>
                                        <div class="aside-body">
                                            @foreach($widgets['product-catalogue']->object as $key => $val)
                                            @php
                                                $image = $val->image;
                                                $name = $val->languages->name;
                                                $canonical = write_url($val->languages->canonical);
                                                $description = $val->languages->description;
                                            @endphp
                                            <div class="category-item uk-flex uk-flex-middle">
                                                <span class="icon"><img src="{{ $image }}" alt="{{ $name }}"></span>
                                                <a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

