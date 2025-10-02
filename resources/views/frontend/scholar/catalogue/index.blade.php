@extends('frontend.homepage.layout')
@section('content')
    <x-breadcrumb :breadcrumb="$breadcrumb" />
    <div class="scholar-catalogue-page">
        <div class="uk-container-1520 uk-container uk-container-center">
            <div class="search-container">
                <div class="uk-flex uk-flex-center">
                    <div class="scholar-filter-container">
                        <div class="search-heading">Tra cứu học bổng</div>
                        <form method="get" action="" class="uk-form mb20">
                            <div class="uk-flex uk-flex-middle">
                                <div class="form-row">
                                    <input 
                                        type="text"
                                        name="keyword"
                                        value="{{ request()->get('keyword') }}"
                                        class="input-text"
                                        placeholder="Tìm kiếm"
                                    >
                                    <button class="btn-filter-search" name="" value="">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>
                        <div class="filter-result">
                            Chúng tôi tìm thấy <span class="filter-count">{{ $scholars->count() }}</span> kết quả cho bộ lọc của bạn
                        </div>
                    </div>
                </div>
            </div>
            <div class="record-list">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="scholar-list filter-list">
                            @if(!is_null($scholars) && count($scholars))
                            <div class="uk-grid uk-grid-medium">
                                @foreach($scholars as $item)
                                @php
                                    $name = $item->languages->first()->pivot->name;
                                    $canonical = $item->languages->first()->pivot->canonical;
                                    $catName = $item->scholar_catalogues->first()->languages->first()->pivot->name;
                                    $image = $item->image;
                                @endphp
                                <div class="uk-width-small-1-1 uk-width-medium-1-3 mb20">
                                    <div class="scholar-item">
                                        <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}" class="img-zoomin"></a>
                                        <div class="info">
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                            <ul class="uk-list uk-clearfix">
                                                <li>Loại học bổng: {{ $catName }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
                            @include('frontend.component.pagination', ['model' => $scholars])
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
                                                            placeholder="Nhập từ khóa tìm keiems"
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
                                                        name="scholar_catalogues"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox"
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
                                        <h3 class="uk-accordion-title">Chính sách</h3>
                                        <div class="uk-accordion-content">
                                            <div class="filter-search-content">
                                                <form class="uk-form form">
                                                    <div class="form-row">
                                                        <input 
                                                            type="text" 
                                                            class="form-item-search" 
                                                            value=""
                                                            placeholder="Nhập từ khóa tìm keiems"
                                                        />
                                                        <button class="btn--search" value="" type="button"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(!is_null($policies) && count($policies))
                                            <div class="collapse-filter">
                                                @foreach($policies as $key => $val)
                                                <div class="filter-item uk-flex uk-flex-middle">
                                                    <input 
                                                        type="checkbox"
                                                        name="scholar_policies[]"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox"
                                                        id="scholar_catalogue_{{ $val->id }}"
                                                    >
                                                    <label for="scholar_catalogue_{{ $val->id }}">{{ $val->name; }}</label>
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
                                                            placeholder="Nhập từ khóa tìm keiems"
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
                                                        name="scholar_trains"
                                                        value="{{ $val->id }}"
                                                        class="input-checkbox"
                                                        id="scholar_catalogue_{{ $val->id }}"
                                                    >
                                                    <label for="scholar_catalogue_{{ $val->id }}">{{ $val->name; }}</label>
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


