@extends('frontend.homepage.layout')
@section('content')
    <x-breadcrumb :breadcrumb="$breadcrumb" />
    <div class="post-catalogue page">
        <div class="page-catalogue-container">
            <div class="uk-container uk-container-center">
                <div class="panel-head">
                    <h1 class="heading-10"><span>{{ $postCatalogue->name }}</span></h1>
                    <div class="description">{!! $postCatalogue->description !!}</div>
                    @if($postCatalogue->direct_children && count($postCatalogue->direct_children))
                    <div class="catalogue-children">
                        <div class="uk-grid uk-grid-medium">
                            @foreach($postCatalogue->direct_children as $key => $val)
                            @php
                                $name = $val->languages->first()->pivot->name;
                                $description = $val->languages->first()->pivot->description;
                                $canonical = write_url($val->languages->first()->pivot->canonical);
                            @endphp
                            <div class="uk-width-small-1-2 uk-width-medium-1-3 mb30">
                                <div class="catalogue-children__item">
                                    <h2 class="name"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h2>
                                    <div class="description">{!! $description !!}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-large-2-3">
                            <div class="featured-container">
                                <div class="featured-post">
                                    <h2 class="heading-7"><span>Bài viết nổi bật</span></h2>
                                    @foreach($posts as $key => $val)
                                    @if($val->recommend != 2) @continue @endif
                                    @if($key > 0) @break @endif
                                    @php
                                        $name = $val->languages->first()->pivot->name;
                                        $description = $val->languages->first()->pivot->description;
                                        $canonical = write_url($val->languages->first()->pivot->canonical);
                                        $image = $val->image;
                                    @endphp
                                    <div class="featured-post-item">
                                        <a href="{{ $canonical }}" class="image img-cover img-zoomin"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                        <div class="overlay">
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                            <div class="uk-flex uk-flex-middle uk-flex-center mt20 created">
                                                <span class="mr10">Đăng ngày: </span>
                                                <span>{{ $val->created_at }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if($posts)
                                <div class="uk-grid uk-grid-medium mt30">
                                    @foreach($posts as $key => $val)
                                    @if($val->recommend != 2) @continue @endif
                                    @if($key == 0) @continue @endif
                                    @php
                                        $name = $val->languages->first()->pivot->name;
                                        $description = $val->languages->first()->pivot->description;
                                        $canonical = write_url($val->languages->first()->pivot->canonical);
                                        $image = $val->image;
                                    @endphp
                                    <div class="uk-width-medium-1-2 mb20">
                                        <div class="suggest-post-item">
                                            <a href="{{ $canonical }}" class="image img-cover img-zoomin"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                            <div class="info">
                                                <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                <div class="uk-flex uk-flex-middle">
                                                    <span class="mr10">Đăng lúc: </span>
                                                    <span class="created_at">{{ $val->created_at }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="uk-width-large-1-3">
                            <div class="aside">
                                <x-new-post :data="$lastestNews" />
                                <x-aside-social :system="$system" />
                                <x-facebook-page :system="$system" />
                            </div>
                        </div>
                    </div>

                    @if(!is_null($postCatalogue->direct_children) && count($postCatalogue->direct_children))
                    <div class="children-list-post mt50">
                        @foreach($postCatalogue->direct_children as $key => $children)
                            <div class="list-post-item featured-post mb50">
                                <div class="uk-position-relative">
                                    <h2 class="heading-7">
                                        <a href="{{ write_url($children->languages->first()->pivot->canonical) }}">
                                            {{ $children->languages->first()->pivot->name }}
                                        </a>
                                    </h2>
                                    <a href="{{ write_url($children->languages->first()->pivot->canonical) }}" class="post-read-more">
                                        Xem toàn bộ
                                    </a>
                                </div>
                                <div class="panel-body">
                                    @if($key % 2 === 0)
                                        @if(isset($children->posts) && count($children->posts))
                                            <div class="uk-grid uk-grid-medium">
                                                <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2">
                                                    @foreach($children->posts as $item)
                                                        @if($loop->first)
                                                            <x-article-overlay-card 
                                                                :class="'overlay'" 
                                                                :name="$item->languages->first()->pivot->name"
                                                                :canonical="write_url($item->languages->first()->pivot->canonical)"
                                                                description="{!! $item->languages->first()->pivot->description !!}"
                                                                :image="$item->image"
                                                                :created="$item->created_at"
                                                            />
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2">
                                                    <div class="list-posts">
                                                        @foreach($children->posts as $keyItem => $item)
                                                            @if($loop->first) @continue @endif
                                                            @if($keyItem > 3) @break @endif
                                                            <x-article-left-image-card 
                                                                :class="'article-custom mb25'"
                                                                :name="$item->languages->first()->pivot->name"
                                                                description="{!! $item->languages->first()->pivot->description !!}"
                                                                :created="$item->created_at"
                                                                :image="$item->image"
                                                                :canonical="write_url($item->languages->first()->pivot->canonical)"
                                                            />
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if(isset($children->posts) && count($children->posts))
                                        <div class="uk-grid uk-grid-medium">
                                            @foreach($children->posts as $key => $val)
                                            @php
                                                $name = $val->languages->first()->pivot->name;
                                                $description = $val->languages->first()->pivot->description;
                                                $canonical = write_url($val->languages->first()->pivot->canonical);
                                                $image = $val->image;
                                            @endphp
                                            <div class="uk-width-medium-1-4 mb20">
                                                <div class="suggest-post-item">
                                                    <a href="{{ $canonical }}" class="image img-cover img-zoomin"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                                    <div class="info">
                                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                        <div class="uk-flex uk-flex-middle">
                                                            <span class="mr10">Đăng lúc: </span>
                                                            <span class="created_at">{{ $val->created_at }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="chilren-list-post mt50 featured-post">
                        <h2 class="heading-7">
                            <span>
                                Tất cả bài viết
                            </span>
                        </h2>
                        <div class="panel-body">
                           
                            @php
                                $posts = $posts->filter(fn($q) => $q->recommend != 2);
                            @endphp
                            @if(!is_null($posts) && count($posts))
                                <div class="uk-grid uk-grid-medium">
                                    @foreach($posts as $key => $val)
                                    @php
                                        $name = $val->languages->first()->pivot->name;
                                        $description = $val->languages->first()->pivot->description;
                                        $canonical = write_url($val->languages->first()->pivot->canonical);
                                        $image = $val->image;
                                    @endphp
                                    <div class="uk-width-medium-1-4 mb20">
                                        <div class="suggest-post-item">
                                            <a href="{{ $canonical }}" class="image img-cover img-zoomin"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                            <div class="info">
                                                <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                <div class="uk-flex uk-flex-middle">
                                                    <span class="mr10">Đăng lúc: </span>
                                                    <span class="created_at">{{ $val->created_at }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                            <div class="not-found">Không tìm thấy dữ liệu</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

