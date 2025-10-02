@extends('frontend.homepage.layout')
@section('content')
    <div class="scholar-page admission-page">
        <div class="page-header">
            <div class="uk-container uk-container-center">
                <h1 class="page-title">{{ $admission->languages->first()->pivot->name }}</h1>
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
                            <div class="scholar-content">
                                <div class="description">
                                    {!! $admission->languages->first()->pivot->description !!}
                                </div>
                            </div>

                            @php
                                $info = $admission->admissions_info;
                                // dd($info);
                            @endphp
                            <div class="detail-admission-information page-h2 mt30 mb30">
                                <h2 class="heading-2"><span>Thông tin chi tiết tuyển sinh</span></h2>
                                <div class="widget-body">
                                    <div class="uk-grid uk-grid-collapse">
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Mùa học bổng</div>
                                                <div class="value">{{ $info['season'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Thời gian nhập học</div>
                                                <div class="value">{{ $info['admission_time'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Hạn nộp hồ sơ</div>
                                                <div class="value">{{ $info['apply_deadline'] ? Carbon\Carbon::parse($info['apply_deadline'])->format('d-m-Y') : '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Địa điểm</div>
                                                <div class="value">{{ $info['location'] ?? '--' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Lệ phí</div>
                                                <div class="value">{{ $info['application_fee'] ?? '--' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Hình thức đào tạo</div>
                                                <div class="value">{{ $info['education_mode'] ?? 'Offline' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Loại tuyển sinh</div>
                                                <div class="value">{{ $admissionCatalogue->languages->first()->pivot->name }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Hệ thống giáo dục</div>
                                                <div class="value">{{ $admission->scholars->scholar_catalogues->first()->languages->first()->pivot->name ?? '' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Hệ thống giáo dục</div>
                                                <div class="value">
                                                     @foreach($admission->admission_trains as $train)
                                                        {{ $train->name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="scholar-content page-h2 mt30">
                                <div class="content">
                                    <x-table-of-contents :content="$contentWithToc" />
                                    <div class="detail-content">
                                        {!! $contentWithToc !!}
                                    </div>
                                </div>
                            </div>

                            @if(!is_null($relateds) && $relateds->count() > 0)
                            <div class="scholar-admission page-h2">
                                <h2 class="page-title">Thông tin tuyển sinh liên quan</h2>
                                <div class="panel-body">
                                    @foreach($relateds as $item)
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


