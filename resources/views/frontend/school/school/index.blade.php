@extends('frontend.homepage.layout')
@section('content')

    @php
        $schoolInfo = $school->information;
        $information = [
            'Tiếng Việt' => $schoolInfo['name_vi'] ?? '--',
            'Tiếng Anh' => $schoolInfo['name_en'] ?? '--',
            'Tiếng Trung' => $schoolInfo['name_cn'] ?? '--',
            'Loại Hình' => $schoolInfo['type'] ?? '--',
            'Năm Thành Lập' => $schoolInfo['founded_year'] ?? '--',
            'Cơ sở trường' => $schoolInfo['campuses'] ?? '--',
            'Khu Vực' => $schoolInfo['area'] ?? '--',
            'Tỉnh' => $schoolInfo['province'] ?? '--',
            'Thành phố' => $schoolInfo['city'] ?? '--',
            'Xếp hạng quốc gia' => $schoolInfo['national_rank'] ?? '--',
            'Học phí 1 năm tiếng' => $schoolInfo['language_fee'] ?? '--',
            'Cấp thành phố' => $schoolInfo['city_level'] ?? '--',
            'Xếp hạng thế giới' => $schoolInfo['world_rank'] ?? '--',
            'Học phí hệ đại học (Tệ/năm)' => $schoolInfo['bachelor_fee'] ?? '--',
            'Quy mô thành phố' => $schoolInfo['city_scale'] ?? '--',
            'Số lượng sinh viên' => $schoolInfo['total_students'] ?? '--',
            'Học phí hệ Thạc Sĩ (Tệ/năm)' => $schoolInfo['master_fee'] ?? '--',
            'Xếp loại thành phố' => $schoolInfo['city_rank'] ?? '--',
            'Số lượng sinh viên quốc tế' => $schoolInfo['international_students'] ?? '--',
            'Học phí hệ Tiến Sĩ (Tệ/năm)' => $schoolInfo['phd_fee'] ?? '--',
            'Diện tích (m2)' => $schoolInfo['acreage'] ?? '--',
            'Số lượng giảng viên' => $schoolInfo['faculty_count'] ?? '--',
            'Phí kí túc xã (Tệ/tháng)' => $schoolInfo['dormitory_fee'] ?? '--',
            'Sách thư viện' => $schoolInfo['library_books'] ?? '--',
            'Số lượng chuyên ngành' => $schoolInfo['majors_count'] ?? '--',
            'Sinh hoạt phí (Tệ/tháng)' => $schoolInfo['living_fee'] ?? '--',
            'Phòng thí nghiệm' => $schoolInfo['labs_count'] ?? '--',
            'Số lượng ngành học' => $schoolInfo['programs_count'] ?? '--',
            'Ngành trọng điểm' => $schoolInfo['key_subjects'] ?? '--',
            'Số nhà ăn' => $schoolInfo['canteens'] ?? '--',
            'Chuyên ngành tiến sĩ' => $schoolInfo['phd_programs'] ?? '--',
            'Số loại học bổng' => $schoolInfo['scholarship_types'] ?? '--',
            'Chuyên ngành thạc sĩ' => $schoolInfo['master_programs'] ?? '--',
        ];
    @endphp

    <div class="scholar-page admission-page">
        <div class="page-body mt30">
            <div class="uk-container uk-container-1520 uk-container-center">
                @php
                    $banner = $school->album[0] ?? ''
                @endphp
                <div class="page-banner school-banner">
                    <span class="image img-cover"><img src="{{ $banner }}" alt="Banner"></span>
                </div>
                <div class="school-info">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <div class="uk-flex uk-flex-middle">
                            <div class="school-logo"><img src="{{ $school->logo }}" alt=""></div>
                            <h1 class="school-name">{{ $school->languages->first()->pivot->name }}</h1>
                        </div>
                        <div class="school-tool uk-flex uk-flex-middle">
                            <div class="tool-icon">
                                <div class="heart">
                                    <span class="icon"><i class="bi-heart-fill"></i></span>
                                    <span class="number">0</span>
                                </div>
                            </div>
                            <div class="tool-icon">
                                <div class="heart">
                                    <span class="icon"><i class="bi-hand-thumbs-up-fill cursor-pointer"></i></span>
                                    <span class="number">0</span>
                                </div>
                            </div>
                            <div class="tool-icon">
                                <div class="heart">
                                    <span class="icon"><i class="bi-arrow-left-right"></i></span>
                                    <span class="number">PK</span>
                                </div>
                            </div>
                            <div class="tool-icon">
                                <div class="heart">
                                    <span class="icon"><i class="bi-eye-fill"></i></span>
                                    <span class="number">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-grid uk-grid-large">
                    <div class="uk-width-large-2-3">
                        <div class="school-page-container">
                            <div class="school-content">
                               <div class="school-overview page-h2 mb30">
                                    <h2 class="heading-7"><span>Toàn cảnh trường</span></h2>
                                    <div class="school-over-content">
                                        {!! $school->panorama !!}
                                    </div>
                               </div>
                                <div class="school-information page-h2">
                                        <h2 class="heading-7"><span>Thông tin trường</span></h2>
                                        <div class="info">
                                            @if(isset($information) && count($information))
                                            <div class="uk-grid uk-grid-collapse">
                                                @foreach($information as $b => $a)
                                                <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3">
                                                    <div class="school-row">
                                                        <div class="uk-grid uk-grid-collapse">
                                                            <div class="uk-width-1-2">
                                                                <div class="label">{{ $b }}</div>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <div class="value">{{ $a }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                </div>
                                <div class="school-gallery page-h2">
                                    <h2 class="heading-7"><span>Hình Ảnh</span></h2>
                                    <div class="body">
                                        @if(isset($school->album) && count($school->album))
                                        <div class="uk-grid uk-grid-medium">
                                            @foreach($school->album as $key => $val)
                                            <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 mb20">
                                                <a href="{{ $val }}" data-uk-lightbox="{group:'school-gallery'}" title="image" class="image img-cover"><img src="{{ $val }}" alt="{{ $val }}"></a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                               </div>
                                @php
                                    $schoolVideos = explode(',', $school->video);
                                @endphp
                                 <div class="school-gallery school-video page-h2">
                                    <h2 class="heading-7"><span>Video</span></h2>
                                    <div class="body">
                                        @if(isset($schoolVideos) && count($schoolVideos))
                                        <div class="uk-grid uk-grid-medium">
                                            @foreach($schoolVideos as $key => $val)
                                            <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-3 mb20">
                                                {!! $val !!}
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="school-post page-h2 mt50">
                                    <h2 class="heading-7"><span>Giới thiệu</span></h2 >
                                    <div class="description article-content">
                                        {!! $school->languages->first()->pivot->description !!}
                                    </div>
                                    <div class="content article-content">
                                        {!! $school->languages->first()->pivot->content !!}
                                    </div>
                                </div>

                                
                                @php
                                   $school->school_scholars->load(['languages', 'scholar_catalogues.languages']);
                                @endphp
                                <div class="school-scholars page-h2 mt50 mb30">
                                    <h2 class="heading-7"><span>Các loại học bổng của trường</span></h2>
                                    <div class="info">
                                        <table class="table scholarship">
                                            <thead>
                                                <tr>
                                                <th>#</th>
                                                <th class="text-start">Loại học bổng</th>
                                                <th class="text-start">Tên học bổng</th>
                                                <th>Hệ tuyển sinh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!is_null($school->school_scholars) && $school->school_scholars->count() > 0)
                                                @foreach($school->school_scholars as $key => $val)
                                                <tr>
                                                    <td>{{ $key+1 }}.</td>
                                                    <td class="text-start">{{ $val->scholar_catalogues->first()->languages->first()->pivot->name }}</td>
                                                    <td class="text-start">
                                                        <a href="{{ write_url($val->languages->first()->pivot->canonical) }}" target="_blank" title="{{ $val->languages->first()->pivot->name }}">
                                                            {{ $val->languages->first()->pivot->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $val->scholar_trains->name }}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4">Không tìm thấy dữ liệu hợp lệ</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- @dd($school->training_major); --}}
                                <div class="school-major page-h2 mt50">
                                    <h2 class="heading-7 mb30"><span>Chuyên Ngành Đào Tạo</span></h2>
                                    @if(isset($school->training_major) && count($school->training_major))
                                    @foreach($school->training_major as $key => $val)
                                    <div class="info mb30">
                                        <h3 class="heading-2"><span>{{ $val['train_name'] }}</span></h3>
                                        @if(isset($val['major']) && is_array($val['major']) && count($val['major']))
                                        <table class="table scholarship">
                                            <thead>
                                                <tr>
                                                <th>#</th>
                                                <th class="text-start">Mã ngành</th>
                                                <th class="text-start">Tên ngành</th>
                                                <th>Xếp loại</th>
                                                <th>Xếp hạng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($val['major']))
                                                @foreach($val['major'] as $keyM => $major)
                                                <tr>
                                                    <td>{{ $keyM+1 }}.</td>
                                                    <td class="text-start">{{ $major['code'] }}</td>
                                                    <td class="text-start">{{ $major['name'] }}</td>
                                                    <td class="text-start uk-text-center">{{ $major['grade'] }}</td>
                                                    <td class="text-start uk-text-center">{{ $major['rank'] }}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">Không tìm thấy dữ liệu hợp lệ</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                              

                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <div class="scholar-aside uk-height-1-1">
                            <div  data-uk-sticky="{boundary: true}">
                                <div class="school-address">
                                    <div class="heading">Thông tin liên hệ</div>
                                    <div class="info">
                                        <div class="uk-flex uk-flex-middle">
                                            <span class="image img-cover"><img src="{{ $school->logo }}" alt="logo trường"></span>
                                            <div class="a">
                                                <div class="title">{{ $school->languages->first()->pivot->name }}</div>
                                                <div class="code">Mã Trường: <strong>{{ $school->code }}</strong></div>
                                            </div>
                                        </div>
                                        <div class="address">
                                            <div class="address-item"><i class="bi-pin-map"></i> {{ $school->address }}</div>
                                            <div class="address-item"><i class="bi-telephone"></i> {{ $school->phone }}</div>
                                            <div class="address-item"><i class="bi-envelope"></i> {{ $school->email }}</div>
                                            <div class="address-item"><i class="bi-globe"></i> {{ $school->link_website }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="school-address school-map mt30 mb30">
                                    <div class="heading">Bản đồ</div>
                                    <div class="info map">
                                        {!! $school->map !!}
                                    </div>
                                </div>

                                <div class="register-scholar-form mt50">
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


