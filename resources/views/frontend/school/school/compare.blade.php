@extends('frontend.homepage.layout')

@section('content')
    
    <div class="compare-page">
        <div class="page-header">
            <div class="uk-container uk-container-center">
                <h1 class="page-title">So sánh trường</h1>
                <nav class="nav-breadcrumb uk-flex uk-flex-center">
                    <ol class="uk-list uk-clearflix">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="{{ write_url('so-sanh-truong') }}" title="So sánh trường">So sánh trường</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="page-body">
            <div class="uk-container uk-container-center">
                <div class="section-header">
                    <h2 class="section-title">Bảng so sánh trường Đại học Trung Quốc</h2>
                    <h3 class="section-subtitle">Ấn Ctrl + P để in bảng so sánh này sang File PDF nếu muốn</h3>
                </div>
                <div class="section-body">
                    <div class="sst-box">
                        <div class="sst-row">
                        <div class="sst-col label justify-content-center">
                            <svg class="text-primary me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path></svg> 
                            Chọn trường
                        </div>
                        <div class="sst-col" style="min-height: 112px;">
                            <button data-row="1"  type="button" class="p-2 btn-raised btn btn-primary uk-button choose-school" data-uk-modal="{target:'#school-list'}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="sst-col" style="min-height: 112px;">
                            <button data-row="2" type="button" class="p-2 btn-raised btn btn-primary uk-button choose-school" data-uk-modal="{target:'#school-list'}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="sst-col" style="min-height: 112px;">
                            <button data-row="3" type="button" class="p-2 btn-raised btn btn-primary uk-button choose-school" data-uk-modal="{target:'#school-list'}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="sst-col" style="min-height: 112px;">
                            <button data-row="4" type="button" class="p-2 btn-raised btn btn-primary uk-button choose-school" data-uk-modal="{target:'#school-list'}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Thông tin trường</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Mã trường</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Năm thành lập</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Loại hình trường</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Dự án</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Trực thuộc trung ương</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Khu Vực</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Thành phố</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Cấp thành phố</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Cấp tỉnh</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Đặc khu kinh tế</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Xếp hạng</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Xếp hạng quốc gia</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Xếp hạng thế giới</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Cơ sở vật chất</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Diện tích (m2)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Cơ sở trường</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Số nhà ăn</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Sân tập thể dục</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Phòng thí nghiệm</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Sách thư viện (cuốn)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Đào tạo</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Số giảng viên</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Tổng sinh viên</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Sinh viên đại học</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Nghiên cứu sinh</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Sinh viên quốc tế</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Số chuyên ngành đại học</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Chuyên ngành thạc sĩ</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Chuyên ngành tiến sĩ</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Ngành trọng điểm quốc gia</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Học Bổng</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Số lượng học bổng</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học bổng chính phủ</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học bổng khổng tử</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học bổng Tỉnh</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học bổng Thành phố</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học bổng Trường</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">CHI PHÍ</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Học phí 1 năm tiếng</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học phí hệ Đại học (Tệ/năm)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học phí hệ Thạc sĩ (Tệ/năm)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Học phí hệ Tiến sĩ (Tệ/năm)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Phí ký túc xá (Tệ/tháng)</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Sinhhoạt phí (Tệ/tháng) </div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sst-box">
                        <div class="sst-header">Dữ liệu</div>
                        <div class="sst-body">
                            <div class="sst-row">
                                <div class="sst-col label">Số người đã Apply</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Lượt xem</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                            <div class="sst-row">
                                <div class="sst-col label">Bài viết liên quan</div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                                <div class="sst-col"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="school-list" class="uk-modal">
        <input type="hidden" value="" id="school-index">
        <div class="uk-modal-dialog">
            {{-- <a class="uk-modal-close uk-close"></a> --}}
            <div class="modal-content">
                <h2 class="heading-2 mb20">Chọn trường</h2>
                <form action="" class="uk-form search-school-form">
                    <input type="text" class="input-text" value="" name="" placeholder="Nhập tên trường">
                    <button class="form-button"><img src="/vendor/frontend/img/search.svg" alt=""></button>
                </form>
                <div class="schools ajax-schools">
                    @if(!is_null($schools) && $schools->count() > 0)
                    @foreach($schools as $school)
                    @php
                        $name = $school->languages->first()->pivot->name;
                        $image = $school->logo;
                        $code = $school->code;
                    @endphp
                    <div class="compare-school-item" data-json="{{ json_encode($school) }}">
                        <div class="uk-flex uk-flex-middle">
                            <img src="{{ $image }}" width="48" height="48" alt="{{ $name }}">
                            <div><div class="fw-medium ">{{ $name }}</div><div class="small text-secondary">Mã: {{ $code }}</div></div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection