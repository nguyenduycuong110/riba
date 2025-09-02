@extends('frontend.homepage.layout')
@section('content')
    @php
    $breadcrumbImage = !empty($productCatalogue->album) ? json_decode($productCatalogue->album, true)[0] : asset('userfiles/image/system/breadcrumb.png');
    @endphp
    <div class="product-catalogue page-wrapper">
        <div class="uk-container uk-container-center">
            <div class="mt40 mb40 banner">
                <a href="" class="image img-cover">
                    <img src="{{ $system['background_1'] }}" alt="">
                </a>
                <div class="text-overlay">
                    @include('frontend.component.breadcrumb', [
                        'model' => $productCatalogue,
                        'breadcrumb' => $breadcrumb,
                    ])
                    <h2 class="heading-1"><span>{{ $productCatalogue->name }}</span></h2>
                    <div class="description">
                        {!! $productCatalogue->description !!}
                    </div>
                </div>
            </div>
            <div class="panel-body mb30">
                <div class="uk-container uk-container-center">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-medium-1-4">
                            <div class="browse-filters">
                                <div class="filters-title">
                                    <h3 class="heading-2"><span>Lọc khóa học</span></h3>
                                </div>
                                <div class="filters-category">
                                    <div class="bucket">
                                        <div class="filter-item">
                                            <div class="filter-item__title">Loại khóa học</div>
                                            <div class="filter-item__content filter-group">
                                                <ul class="filter-list">
                                                    @if(!is_null($children))
                                                        @foreach($children as $item)
                                                            @php
                                                                $name = $item->languages->first()->pivot->name;
                                                                $canonical= write_url($item->languages->first()->pivot->canonical);
                                                                $product_count = $item->product_count;
                                                            @endphp
                                                            <li class="filter-list__item">
                                                                <div class="uk-flex uk-flex-middle">
                                                                    <input id="product-catalogue-{{ $item->id }}" type="checkbox" class="input-value p-filter" name="product_catalogue_id[]" value="{{ $item->id }}">
                                                                    <label for="product-catalogue-{{ $item->id }}">
                                                                        <i class="fa"></i>
                                                                        {{ $name }}
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bucket mb20">
                                        <div class="filter-item">
                                            <div class="filter-item__title">Giảng viên</div>
                                            <div class="filter-item__content filter-group">
                                                <ul class="filter-list">
                                                    @if(!is_null($lecturers))
                                                        @foreach($lecturers as $item)
                                                            @php
                                                                $id = $item->id;
                                                                $name = $item->name;
                                                            @endphp
                                                             <li class="filter-list__item">
                                                                <div class="uk-flex uk-flex-middle">
                                                                    <input id="lecture-{{ $item->id }}" type="checkbox" class="input-value p-filter" name="lecture_id[]" value="{{ $item->id }}">
                                                                    <label for="lecture-{{ $item->id }}">
                                                                        <i class="fa"></i>
                                                                        {{ $name }}
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-3-4">
                            <div class="browse-items">
                                <div class="browse-tools">
                                    <div class="filter-tools">
                                        <button class="button button-outline button-pill toggle-filters">
                                            <span class="icon icon-filters"></span><span class="caption">Hiển thị <strong>{{ $products->count() }} kết quả</strong></span>
                                        </button>
                                    </div>
                                    {{-- <div class="dropdown dropdown-align-right sort-options">
                                        <button class="button button-outline button-pill dropdown-toggle" title="Sort" aria-label="Sort">
                                            <span class="overflow">Sắp xếp</span>
                                            <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.03126 1.85714H8.90626C9.03058 1.85714 9.14981 1.80823 9.23771 1.72116C9.32562 1.63409 9.37501 1.51599 9.37501 1.39286V0.464286C9.37501 0.341149 9.32562 0.223057 9.23771 0.135986C9.14981 0.0489157 9.03058 0 8.90626 0H7.03126C6.90694 0 6.78771 0.0489157 6.69981 0.135986C6.6119 0.223057 6.56251 0.341149 6.56251 0.464286V1.39286C6.56251 1.51599 6.6119 1.63409 6.69981 1.72116C6.78771 1.80823 6.90694 1.85714 7.03126 1.85714ZM7.03126 5.57143H10.7813C10.9056 5.57143 11.0248 5.52251 11.1127 5.43544C11.2006 5.34837 11.25 5.23028 11.25 5.10714V4.17857C11.25 4.05544 11.2006 3.93734 11.1127 3.85027C11.0248 3.7632 10.9056 3.71429 10.7813 3.71429H7.03126C6.90694 3.71429 6.78771 3.7632 6.69981 3.85027C6.6119 3.93734 6.56251 4.05544 6.56251 4.17857V5.10714C6.56251 5.23028 6.6119 5.34837 6.69981 5.43544C6.78771 5.52251 6.90694 5.57143 7.03126 5.57143ZM14.5312 11.1429H7.03126C6.90694 11.1429 6.78771 11.1918 6.69981 11.2788C6.6119 11.3659 6.56251 11.484 6.56251 11.6071V12.5357C6.56251 12.6588 6.6119 12.7769 6.69981 12.864C6.78771 12.9511 6.90694 13 7.03126 13H14.5312C14.6556 13 14.7748 12.9511 14.8627 12.864C14.9506 12.7769 15 12.6588 15 12.5357V11.6071C15 11.484 14.9506 11.3659 14.8627 11.2788C14.7748 11.1918 14.6556 11.1429 14.5312 11.1429ZM7.03126 9.28571H12.6563C12.7806 9.28571 12.8998 9.2368 12.9877 9.14973C13.0756 9.06266 13.125 8.94456 13.125 8.82143V7.89286C13.125 7.76972 13.0756 7.65163 12.9877 7.56456C12.8998 7.47749 12.7806 7.42857 12.6563 7.42857H7.03126C6.90694 7.42857 6.78771 7.47749 6.69981 7.56456C6.6119 7.65163 6.56251 7.76972 6.56251 7.89286V8.82143C6.56251 8.94456 6.6119 9.06266 6.69981 9.14973C6.78771 9.2368 6.90694 9.28571 7.03126 9.28571ZM5.15626 9.28571H3.75002V0.464286C3.75002 0.341149 3.70063 0.223057 3.61272 0.135986C3.52482 0.0489157 3.40559 0 3.28127 0H2.34377C2.21945 0 2.10022 0.0489157 2.01231 0.135986C1.92441 0.223057 1.87502 0.341149 1.87502 0.464286V9.28571H0.468772C0.0530499 9.28571 -0.157301 9.78598 0.138011 10.0782L2.48176 12.8639C2.56966 12.9509 2.68884 12.9998 2.8131 12.9998C2.93737 12.9998 3.05655 12.9509 3.14445 12.8639L5.4882 10.0782C5.78175 9.78656 5.57287 9.28571 5.15626 9.28571Z" fill="#555555"/>
                                            </svg>
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                            @if (!is_null($products))
                            <div class="product-catalogue product-list">
                                <div class="uk-grid uk-grid-medium">
                                    @foreach ($products as $product)
                                        <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-3 mb20">
                                            @include('frontend.component.p-item', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                                 <div class="uk-flex uk-flex-center">
                                    @include('frontend.component.pagination', ['model' => $products])
                                </div>
                            </div>
                                
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="description dc">
                {!! $productCatalogue->content !!}
            </div>
        </div>
    </div>
@endsection
