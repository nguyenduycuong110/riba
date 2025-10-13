@extends('frontend.homepage.layout')
@section('content')
    <div class="scholar-page major-page">
        <div class="page-header">
            <div class="uk-container uk-container-center">
                <h1 class="page-title">{{ $major->languages->first()->pivot->name }}</h1>
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
                                    {!! $major->languages->first()->pivot->description !!}
                                </div>
                            </div>

                            <div class="detail-admission-information page-h2 mt30 mb30">
                                <h2 class="heading-2"><span>Chi tiết chuyên ngành</span></h2>
                                <div class="widget-body">
                                    <div class="uk-grid uk-grid-collapse">
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Tên Tiếng Trung</div>
                                                <div class="value">{{ $major->cn_name ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Tên Tiếng Anh</div>
                                                <div class="value">{{ $major->en_name ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Ngành</div>
                                                <div class="value">{{ $major->major_groups->languages->first()->pivot->name }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Mã ngành</div>
                                                <div class="value">{{ $major->code  }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                            <div class="widget-body-item">
                                                <div class="label">Hệ đào tạo</div>
                                                <div class="value">{{ $major->major_trains->name ?? '-' }}</div>
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

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


