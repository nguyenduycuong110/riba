@extends('frontend.homepage.layout')
@section('content')
    <div class="scholar-page">
        <div class="page-header">
            <div class="uk-container uk-container-center">
                <h1 class="page-title">{{ $scholar->languages->first()->pivot->name }}</h1>
                <nav class="nav-breadcrumb uk-flex uk-flex-center">
                    <ol class="uk-list uk-clearflix">
                        <li><a href="/">Trang chủ</a></li>
                        @foreach($breadcrumb as $key => $val)
                        @php
                            $name = $val->languages->first()->pivot->name;
                            $canonical = write_url($val->languages->first()->pivot->canonical);

                        @endphp
                        <li><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        <div class="page-body mt30">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-large">
                    <div class="uk-width-large-2-3">
                        <div class="scholar-page-container">
                            @if(isset($scholar->scholar_policy) && count($scholar->scholar_policy))
                            <div class="scholar-policy page-h2">
                                <h2 class="title"><span>Chính sách học bổng</span></h2>
                                <div class="uk-grid uk-grid-medium">
                                    @foreach($scholar->scholar_policy as $policy)
                                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-2 uk-width-large-1-3">
                                        <div class="policy-item">
                                            <div class="title">{{ $policy['title'] }}</div>
                                            <div class="description">
                                                {!! $policy['description'] !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="scholar-content page-h2 mt30">
                                <h2 class="title"><span>Giới thiệu về học bổng</span></h2>
                                <div class="description">
                                    {!! $scholar->languages->first()->pivot->description !!}
                                </div>
                                <div class="content">
                                    <x-table-of-contents :content="$contentWithToc" />
                                    {!! $contentWithToc !!}
                                </div>
                            </div>

                            @if(!is_null($scholar->scholar_admissions) && $scholar->scholar_admissions->count() > 0)
                            <div class="scholar-admission page-h2">
                                <h2 class="page-title">Thông tin tuyển sinh liên quan</h2>
                                <div class="panel-body">
                                    @foreach($scholar->scholar_admissions as $item)
                                        <x-admission-item :item="$item" />
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <div class="scholar-aside uk-height-1-1">
                            <div  data-uk-sticky="{boundary: true}">
                                <div class="fanpage-facebook">
                                <a href="{{ $system['social_facebook'] }}" target="_blank"><img src="{{ asset('userfiles/image/hoi-tu-apply-hoc-bong-trung-quoc-6.jpeg') }}" alt=""></a>
                                </div>

                                <div class="register-scholar-form">
                                    <div class="page-h2">
                                        <h2 class="title"><span>Tư vấn đăng ký</span></h2>
                                        <form action="" class="uk-form scholar-form">
                                            <div class="form-row">
                                                <label for="name">Họ Tên</label>
                                                <input type="text"  class="input-b name" value="" placeholder="">
                                            </div>
                                            <div class="form-row">
                                                <label for="name">Email</label>
                                                <input type="text"  class="input-b email" value="" placeholder="">
                                            </div>
                                            <div class="form-row">
                                                <label for="name">Số điện thoại</label>
                                                <input type="text"  class="input-b phone" value="" placeholder="">
                                            </div>
                                            <div class="form-row">
                                                <label for="name">Khu vực du học mong muốn</label>
                                                <input type="text"  class="input-b destination_area" value="" placeholder="">
                                            </div>
                                            <div class="form-row">
                                                <label for="name">Loại học bổng muốn đăng ký</label>
                                                <input type="text"  class="input-b apply_for" value="" placeholder="">
                                            </div>
                                            <button type="submit" name="submit" value="">
                                                Đăng ký tư vấn
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if(isset($relatedScholars) && $relatedScholars->count())
                                    <div class="scholar-related page-h2">
                                        <h2 class="page-title mb30">Các loại học bổng khác</h2>
                                        <ul class="related-list">
                                            @foreach($relatedScholars as $item)
                                                @php
                                                    $name = $item->languages->first()->pivot->name ?? '';
                                                    $canonical = $item->languages->first()->pivot->canonical ?? '#';
                                                    $image = $item->image ?? '/images/no-image.png';
                                                @endphp
                                                <li class="related-item">
                                                    <a href="{{ $canonical }}" class="image">
                                                        <img src="{{ $image }}" alt="{{ $name }}">
                                                    </a>
                                                    <div class="info">
                                                        <h3 class="title">
                                                            <a href="{{ $canonical }}">{{ $name }}</a>
                                                        </h3>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
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


