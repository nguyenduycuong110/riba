@extends('frontend.homepage.layout')
@section('content')
    <x-breadcrumb :breadcrumb="$breadcrumb" />
    <div class="school-catalogue-page">
        <div class="uk-container-1520 uk-container uk-container-center">
            <div class="search-container">
                <div class="uk-flex uk-flex-center">
                    <div class="school-filter-container">
                        <div class="search-heading">Tra cứu trường</div>
                        <form method="get" action="" class="uk-form mb20">
                            <div class="uk-flex uk-flex-middle">
                                <div class="form-row">
                                    <input 
                                        type="text"
                                        name="keyword"
                                        value="{{ request()->get('keyword') }}"
                                        class="input-text school-keyword"
                                        placeholder="Tìm kiếm"
                                    >
                                    <button class="btn-filter-search" name="" value="">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>
                        <div class="filter-result">
                            Chúng tôi tìm thấy <span class="filter-count">{{ $schools->count() }}</span> kết quả cho bộ lọc của bạn
                        </div>
                    </div>
                </div>
            </div>
            <div class="record-list">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="filter-result-list">
                            <div class="school-list filter-list">
                                @if(!is_null($schools) && count($schools))
                                    <div class="uk-grid uk-grid-medium">
                                        @foreach($schools as $item)
                                            <div class="uk-width-small-1-1 uk-width-medium-1-3 mb20">
                                                <x-school :item="$item" />
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
                                @include('frontend.component.pagination', ['model' => $schools])
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <div class="filter-box">
                            <div class="filter-heading">Tùy chọn tìm kiếm</div>
                            <div class="filter-body">
                                <div class="uk-accordion-1">
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Khu vực</h3>
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
                                            @if(!is_null($areas) && count($areas))
                                                <div class="collapse-filter">
                                                    @foreach($areas as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="school_areas[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="area_{{ $val->id }}"
                                                        >
                                                        <label for="area_{{ $val->id }}">{{ $val->name; }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Thành phố</h3>
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
                                            @if(!is_null($cities) && count($cities))
                                                <div class="collapse-filter">
                                                    @foreach($cities as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="school_cities[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="city_{{ $val->id }}"
                                                        >
                                                        <label for="city_{{ $val->id }}">{{ $val->name; }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Học bổng</h3>
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
                                            @if(!is_null($scholarCatalogues) && count($scholarCatalogues))
                                                <div class="collapse-filter">
                                                    @foreach($scholarCatalogues as $key => $val)
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
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Loại hình trường</h3>
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
                                            @if(!is_null($schoolCatalogueList) && count($schoolCatalogueList))
                                                <div class="collapse-filter">
                                                    @foreach($schoolCatalogueList as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="school_catalogues[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="school_catalogue_{{ $val->id }}"
                                                        >
                                                        <label for="school_catalogue_{{ $val->id }}">{{ $val->languages->first()->pivot->name; }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Dự án</h3>
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
                                            @if(!is_null($projects) && count($projects))
                                                <div class="collapse-filter">
                                                    @foreach($projects as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="school_projects[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="project_{{ $val->id }}"
                                                        >
                                                        <label for="project_{{ $val->id }}">{{ $val->name; }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Ngành</h3>
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
                                            @if(!is_null($majorCatalogues) && count($majorCatalogues))
                                                <div class="collapse-filter">
                                                    @foreach($majorCatalogues as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="major_catalogues[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="major_catalogue_{{ $val->id }}"
                                                        >
                                                        <label for="major_catalogue_{{ $val->id }}">{{ $val->languages->first()->pivot->name; }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter-content-item">
                                        <h3 class="uk-accordion-title">Chuyên ngành</h3>
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
                                            @if(!is_null($majors) && count($majors))
                                                <div class="collapse-filter">
                                                    @foreach($majors as $key => $val)
                                                    <div class="filter-item uk-flex uk-flex-middle">
                                                        <input 
                                                            type="checkbox"
                                                            name="majors[]"
                                                            value="{{ $val->id }}"
                                                            class="input-checkbox filter-value"
                                                            id="major_{{ $val->id }}"
                                                        >
                                                        <label for="major_{{ $val->id }}">{{ $val->languages->first()->pivot->name; }}</label>
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

