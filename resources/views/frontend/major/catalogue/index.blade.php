@extends('frontend.homepage.layout')
@section('content')
    <x-breadcrumb :breadcrumb="$breadcrumb" />
    <div class="major-catalogue-page">
        <div class="uk-container-1520 uk-container uk-container-center">
            <div class="search-container">
                <div class="uk-flex uk-flex-center">
                    <div class="scholar-filter-container">
                        <div class="search-heading">Tra cứu chuyên ngành</div>
                        <form method="get" action="" class="uk-form mb20">
                            <div class="uk-flex uk-flex-middle">
                                <div class="form-row">
                                    <input 
                                        type="text"
                                        name="keyword"
                                        value="{{ request()->get('keyword') }}"
                                        class="input-text  major-keyword"
                                        placeholder="Tìm kiếm"
                                    >
                                    <button class="btn-filter-search" name="" value="">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>
                        <div class="filter-result">
                            Chúng tôi tìm thấy <span class="filter-count">{{ $majors->count() }}</span> kết quả cho bộ lọc của bạn
                        </div>
                    </div>
                </div>
            </div>
            <div class="record-list">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="filter-result-list">
                            <div class="major-list panel-major filter-list">
                                @if(!is_null($majors) && count($majors))
                                <div class="uk-grid uk-grid-medium">
                                    @foreach($majors as $item)
                                    @php
                                        $name = $item->languages->first()->pivot->name;
                                        $canonical = write_url($item->languages->first()->pivot->canonical);
                                        $description = $item->languages->first()->pivot->description;
                                        $image = $item->image;
                                        $rate = rand(75, 100);
                                    @endphp
                                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-4 mb20">
                                        <div class="major-item">
                                            <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                            <div class="info">
                                                <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                <div class="description">
                                                    {!! $description !!}
                                                </div>
                                            </div>
                                            <div class="overlay">
                                                <div class="uk-flex uk-flex-middle">
                                                    <span>Đánh giá: </span>
                                                    <div class="star-rating uk-flex uk-flex-right">
                                                        <div class="stars" style="--star-width: {{ $rate }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
                                @include('frontend.component.pagination', ['model' => $majors])
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <div class="filter-box">
                            <div class="filter-heading">Tùy chọn tìm kiếm</div>
                            <div class="filter-body">
                                <div class="uk-accordion-1">
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
                                            @if(!is_null($majorCatalogueList) && count($majorCatalogueList))
                                            <div class="collapse-filter">
                                                @foreach($majorCatalogueList as $key => $val)
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="major_groups[]"
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
                                                        name="major_trains[]"
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


