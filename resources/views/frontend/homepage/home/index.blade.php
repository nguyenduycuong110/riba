@extends('frontend.homepage.layout')
@section('content')
    <div id="homepage" class="homepage">
        @include('frontend.component.slide')
        <div class="panel-commit">
            <div class="uk-container uk-container-center">
                @php
                    $commit = collect(json_decode(file_get_contents(resource_path('json/mock.json'))))['commit'];
                @endphp
                @if(isset($commit) && !is_null($commit) && count($commit))
                <div class="uk-grid uk-grid-medium">
                    @foreach($commit as $key => $val)
                    @php
                        $name = $val->languages->name;
                        $image = $val->image;
                        $description = $val->languages->description;
                    @endphp
                    <div class="uk-width-1-1 uk-width-small-1-2 uk-width-medium-1-3">
                        <div class="commit-item">
                            <div class="icon">
                                <img src="{{ $image }}" alt="{{ $name }}">
                            </div>
                            <div class="info">
                                <div class="title">{{ $name }}</div>
                                <div class="description">
                                    {{ $description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div><!-- .commit -->
        @php
            $intro = collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['intro'];
        @endphp
        @if(isset($intro) && !is_null($intro)  && count($intro))
        @foreach($intro as $key => $val)
        @php
            // dd($val);
            $name = $val->languages->name;
            $description = $val->languages->description;
            $content = $val->languages->content;
            $canonical = write_url($val->languages->canonical);
            $catName = $val->category;
            $image = $val->image;
        @endphp
        <div class="panel-intro">
            <div class="uk-container uk-container-center">
                <div class="panel-body">
                    <div class="panel-intro__image">
                        <span class="image img"><img src="{{ $image }}" alt="{{ $name }}"></span>
                    </div>
                    <div class="panel-intro__info">
                        <div class="category-name">{{ $catName }}</div>
                        <div class="name">{!! $name !!}</div>
                        <div class="description">{!! $description !!}</div>
                        <div class="content">{!! $content !!}</div>
                        <x-button-hotline 
                            name="Xem thêm" 
                            class="button-style-2" 
                            number="{{ $system['contact_hotline'] }}" 
                            canonical="{{ $canonical }}"
                        />
                    </div> 
                    
                </div>
            </div>
        </div>
        @endforeach
        @endif
         @php
            $marquee = collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['marquee'];
        @endphp
        @if(isset($marquee) && !is_null($marquee) && count($marquee))
        <div class="panel-marquee">
            <div class="marquee__inner">
                <!-- group 1 (thực tế) -->
                <div class="marquee__group">
                    @foreach($marquee as $key => $val)
                    @php
                        $name = $val->languages->name;
                        $canonical = write_url($val->languages->canonical);
                    @endphp
                    <a class="marquee__item" href="{{ $canonical }}">{{ $name }}</a>
                    @endforeach
                </div>

                <div class="marquee__group" aria-hidden="true">
                    @foreach($marquee as $key => $val)
                    @php
                        $name = $val->languages->name;
                        $canonical = write_url($val->languages->canonical);
                    @endphp
                    <a class="marquee__item" href="{{ $canonical }}">{{ $name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @php
            $event = collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['event'];
            // dd($event);
        @endphp
        @if(isset($event) && !is_null($event) && count($event))
            @foreach($event as $key => $val)
            @php
                $name = $val->languages->name;
                $canonical = write_url($val->languages->canonical);
                $description = $val->languages->description;
                $album = $val->album;
            @endphp
            <div class="panel-service">
                <div class="uk-container uk-container-center">
                    <div class="panel-body">
                        @foreach(collect($album)->slice(0, 2) as $keyA => $a)
                            <div class="image img-zoomin img-cover img-{{ $keyA }}">
                                <img src="{{ $a }}" alt="image">
                            </div>
                        @endforeach
                        <div class="event-container">
                            <div class="special-text">Event</div>
                            <h2 class="heading-1"><span>{{ $name }}</span></h2>
                            <div class="description">
                                {!! $description !!}
                            </div>
                            <div class="read-more"><a href="{{ $canonical }}" title="Readmore">Xem tất cả sự kiện</a></div>
                        </div>
                        @foreach(collect($album)->slice(2, 2) as $keyA => $a)
                            <div class="image img-zoomin img-cover img-{{ $keyA }}">
                                <img src="{{ $a }}" alt="image">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        
        @php
            $schoolarship =  collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['schoolarship'];
        @endphp

        @if(isset($schoolarship) && !is_null($schoolarship) && count($schoolarship))
            @foreach($schoolarship as $key => $val)
            @php
                $catName = $val->languages->name;
                $catCanonical = write_url($val->languages->canonical);
                $children = $val->children;
            @endphp
            <div class="panel-scholarship">
                <div class="uk-container uk-container-center">
                    <div class="panel-head uk-text-center">
                        <div class="heading-2"><span>{{ $catName }}</span></div>
                        @if(is_array($children) && count($children))
                        <div class="sub-category uk-flex uk-flex-middle uk-flex-center">
                            @foreach($children as $keyChild => $valChild)
                            @php
                                $childName = $valChild->languages->name;
                                $childCanonical = write_url($valChild->languages->canonical);
                            @endphp
                            <a class="{{ ($keyChild === 0) ? 'active' : '' }}"  href="{{ $childCanonical }}" title="{{ $childName }}">{{ $childName }}</a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="panel-body">
                        @if(isset($val->items) && is_array($val->items) && count($val->items))
                        <div class="uk-grid uk-grid-medium">
                            @foreach($val->items as $item)
                            @php
                                $name = $item->languages->name;
                                $canonical = write_url($item->languages->canonical);
                                $image = $item->image;
                                $rate = $item->rate;
                            @endphp
                            <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 mb25">
                                <div class="scholarship-item">
                                    <a href="{{ $canonical }}" class="image img-cover img-zoomin">
                                        <img src="{{ $image }}" alt="{{ $name }}">
                                    </a>
                                    <div class="overlay-top">
                                        <div class="uk-flex uk-flex-middle uk-flex-right">
                                            <div class="uk-flex uk-flex-middle">
                                                <span>Đánh Giá</span>
                                                <div class="star-rating">
                                                    <div class="stars" style="--star-width: {{ $rate }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overlay-bottom">
                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                    </div>
                                    <span class="badge">Hot</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="panel-foot">
                        <div class="uk-flex uk-flex-center">
                            <a href="{{ $catCanonical }}" title="Xem toàn bộ" class="show-more">Xem tất cả học bổng</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        
        @php
            $schoolarshipType =  collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['schoolarshipType'];
        @endphp
        @if(isset($schoolarshipType) && !is_null($schoolarshipType) && count($schoolarshipType))
            @foreach($schoolarshipType as $key => $val)
            @php
                $nameC = $val->languages->name;
                $descriptionC = $val->languages->description;
                $canonicalC = write_url($val->languages->canonical);
            @endphp
            <div class="panel-shoolarship-type">
                <div class="uk-container uk-container-center">
                    <div class="panel-head uk-text-left">
                        <h2 class="heading-2"><span>{{ $nameC }}</span></h2>
                        <div class="description">{!! $descriptionC !!}</div>
                    </div>
                    <div class="panel-body">
                        @if(isset($val->items) && is_array($val->items) && count($val->items))
                        <div class="uk-grid uk-grid-medium ">
                            @foreach($val->items as $item)
                            @php
                                $name = $item->languages->name;
                                $canonical = write_url($item->languages->canonical);
                                $image = $item->image;
                                $description = $item->languages->description;
                            @endphp
                                <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 uk-width-xlarge-1-4 mb25">
                                    <div class="type-item">
                                        <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                        <div class="info">
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                            <div class="description">
                                                {!! $description !!}
                                            </div>
                                        </div>
                                        <a href="{{ $canonical }}" class="show-more-2" title="Xem ngay">Xem Ngay</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="panel-foot">
                        <div class="uk-flex uk-flex-center">
                            <a href="{{ $canonicalC }}" title="Xem toàn bộ" class="show-more">Xem tất cả học bổng</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @php
            $major =  collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['major'];
        @endphp
        @if(isset($major) && !is_null($major) && count($major))
            @foreach($major as $key => $val)
            @php
                $imageC = $val->image;
                $nameC = $val->languages->name;
                $descriptionC = $val->languages->description;
                $canonicalC = write_url($val->languages->canonical);
            @endphp
            <div class="panel-major">
                <div class="uk-container uk-container-center">
                    <div class="panel-head">
                        <h2 class="heading-2"><span>{{ $nameC }}</span></h2>
                        <div class="description">{!! $descriptionC !!}</div>
                    </div>
                    <div class="panel-body">
                        @if(isset($val->items) && count($val->items))
                        <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-3-5">
                                <div class="major-container">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                           @foreach($val->items as $keyItem => $item)
                                                @if($keyItem % 2 === 0)
                                                    <div class="swiper-slide">
                                                @endif

                                                <x-major-item :item="$item" />

                                                @if($keyItem % 2 === 1 || $loop->last)
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-2-5">
                                <div class="major-image img-zoomin">
                                    <img src="{{ $imageC }}" alt="{{ $name }}">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        <x-card-form />

        @php
            $review =  collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['review'];
        @endphp
        @if(isset($review) && !is_null($review) && count($review))
            @foreach($review as $key => $val)
            @php
                $name = $val->languages->name;
                $canonical = write_url($val->languages->canonical);
                $description = $val->languages->description;
            @endphp
            <div class="panel-review">
                <div class="uk-container uk-container-center">
                    <div class="panel-head">
                        <div class="special-violet">Review</div>
                        <h2 class="heading-2"><span>{{ $name }}</span></h2>
                        <div class="description">
                            {!! $description !!}
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(isset($val->items) && count($val->items))
                        <div class="uk-grid uk-grid-medium">
                            @foreach($val->items as $item)
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-3 uk-width-large-1-4 uk-width-xlarge-1-4 mb25">
                                <x-review :item="$item" />
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif


        @php
            $news =  collect(
                json_decode(file_get_contents(resource_path('json/mock.json')))
            )['news'];
        @endphp
        @if(isset($news) && !is_null($news) && count($news))
            @foreach($news as $key => $val)
            @php
                $catName = $val->languages->name;
                $catDes = $val->languages->description;
            @endphp
            <div class="panel-news">
                <div class="uk-container uk-container-center">
                    <div class="panel-head">
                        <h2 class="heading-2"><span>{{ $catName }}</span></h2>
                        <div class="description">{!! $catDes !!}</div>
                    </div>
                    <div class="panel-body">
                        @if(isset($val->items) && count($val->items))
                        <div class="uk-grid uk-grid-medium">
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2">
                                @foreach($val->items as $item)
                                    @if($loop->first)
                                        <x-article-overlay-card 
                                            :class="'overlay'" 
                                            :name="$item->languages->name"
                                            :canonical="write_url($item->languages->canonical)"
                                            :description="$item->languages->description"
                                            :image="$item->image"
                                            :created="$item->created_at"
                                        />
                                    @endif
                                @endforeach
                            </div> 
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2">
                                <div class="list-posts">
                                    @foreach($val->items as $keyItem => $item)
                                    @if($keyItem === 0) @continue @endif
                                    @if($keyItem > 3) @break @endif
                                    
                                    <x-article-left-image-card 
                                        :class="'article-custom mb25'"
                                        :name="$item->languages->name"
                                        :description="$item->languages->description"
                                        :created="$item->created_at"
                                        :image="$item->image"
                                        :canonical="write_url($item->languages->canonical)"
                                    />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        <x-partner-card 
            :data="$slides['partner']"
        />
            
    </div>
@endsection
