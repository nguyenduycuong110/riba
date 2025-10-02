@extends('frontend.homepage.layout')
@section('content')
    <x-breadcrumb :breadcrumb="$breadcrumb" />
    <div class="admission-catalogue-page">
        <div class="uk-container-1520 uk-container uk-container-center">
            <div class="search-container">
                <div class="uk-flex uk-flex-center">
                    <div class="scholar-filter-container">
                        <div class="search-heading">Tra cứu thông tin tuyển sinh</div>
                        <form method="get" action="" class="uk-form mb20">
                            <div class="uk-flex uk-flex-middle">
                                <div class="form-row">
                                    <input 
                                        type="text"
                                        name="keyword"
                                        value="{{ request()->get('keyword') }}"
                                        class="input-text  admission-keyword"
                                        placeholder="Tìm kiếm"
                                    >
                                    <button class="btn-filter-search" name="" value="">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>
                        <div class="filter-result">
                            Chúng tôi tìm thấy <span class="filter-count">{{ $admissions->count() }}</span> kết quả cho bộ lọc của bạn
                        </div>
                    </div>
                </div>
            </div>
            <div class="record-list">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="filter-result-list">
                            <div class="scholar-list filter-list">
                                @if(!is_null($admissions) && count($admissions))
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-small-1-1">
                                        @foreach($admissions as $item)
                                        <x-admission-item :item="$item" />
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
                                @include('frontend.component.pagination', ['model' => $admissions])
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">

                        <div class="filter-box">
                            <div class="filter-heading">Tùy chọn tìm kiếm</div>
                            <div class="filter-body">
                                <div class="uk-accordion-1">
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Năm tuyển sinh</h3>
                                        <div class="uk-accordion-content">
                                           <div class="uk-grid uk-grid-medium">
                                                <div class="uk-width-small-1-2">
                                                    <div class="form-row uk-position-relative year-item">
                                                        <span>MIN</span>
                                                        <input 
                                                            type="text"
                                                            name="min_year"
                                                            value="2020"
                                                            min="2020"
                                                            max="2050"
                                                            class="input-text"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-2">
                                                    <div class="form-row uk-position-relative year-item">
                                                        <span>MAX</span>
                                                        <input 
                                                            type="text"
                                                            name="max_year"
                                                            value="2050"
                                                            min="2021"
                                                            max="2050"
                                                            class="input-text"
                                                        >
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Danh mục tuyển sinh</h3>
                                        <div class="uk-accordion-content">
                                            <div class="filter-search-content">
                                                <form class="uk-form form">
                                                    <div class="form-row">
                                                        <input 
                                                            type="text" 
                                                            class="form-item-search" 
                                                            value=""
                                                            placeholder="Nhập từ khóa tìm kiếm"
                                                        />
                                                        <button class="btn--search" value="" type="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(!is_null($admissionCatalogueList) && count($admissionCatalogueList))
                                            <div class="collapse-filter">
                                                @foreach($admissionCatalogueList as $key => $val)
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="admission_catalogues[]"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox filter-value"
                                                        id="admission_catalogue_{{ $val->id }}"
                                                    >
                                                    <label for="admission_catalogue_{{ $val->id }}">{{ $val->languages->first()->pivot->name; }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Hạn tuyển sinh</h3>
                                        <div class="uk-accordion-content">
                                            <div class="filter-search-content">
                                                <form class="uk-form form">
                                                    <div class="form-row">
                                                        <input 
                                                            type="text" 
                                                            class="form-item-search" 
                                                            value=""
                                                            placeholder="Nhập từ khóa tìm kiếm"
                                                        />
                                                        <button class="btn--search" value="" type="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="collapse-filter">
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="admission_deadline[]"
                                                        value="0"
                                                        class="input-checkbox filter-value"
                                                        id="admission_deadline_0"
                                                    >
                                                    <label for="admission_deadline_0">Còn hạn</label>
                                                </div>
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="admission_deadline[]"
                                                        value="1"
                                                        class="input-checkbox filter-value"
                                                        id="admission_deadline_1"
                                                    >
                                                    <label for="admission_deadline_1">Hết hạn</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Hệ đào tạo</h3>
                                        <div class="uk-accordion-content">
                                            <div class="filter-search-content">
                                                <form class="uk-form form">
                                                    <div class="form-row">
                                                        <input 
                                                            type="text" 
                                                            class="form-item-search" 
                                                            value=""
                                                            placeholder="Nhập từ khóa tìm kiếm"
                                                        />
                                                        <button class="btn--search" value="" type="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(!is_null($trains) && count($trains))
                                            <div class="collapse-filter">
                                                @foreach($trains as $key => $val)
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="scholar_trains[]"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox filter-value"
                                                        id="train_{{ $val->id }}"
                                                    >
                                                    <label for="train_{{ $val->id }}">{{ $val->name; }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Loại học bổng</h3>
                                        <div class="uk-accordion-content">
                                            <div class="filter-search-content">
                                                <form class="uk-form form">
                                                    <div class="form-row">
                                                        <input 
                                                            type="text" 
                                                            class="form-item-search" 
                                                            value=""
                                                            placeholder="Nhập từ khóa tìm kiếm"
                                                        />
                                                        <button class="btn--search" value="" type="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(!is_null($scholarCatalogueList) && count($scholarCatalogueList))
                                            <div class="collapse-filter">
                                                @foreach($scholarCatalogueList as $key => $val)
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="scholar_catalogues[]"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox filter-value"
                                                        id="scholar_catalogue_{{ $val->id }}"
                                                    >
                                                    <label for="scholar_catalogue_{{ $val->id }}">{{ $val->languages->first()->pivot->name; }}</label>
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
            </div>
        </div>
    </div>
@endsection


