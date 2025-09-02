@extends('frontend.homepage.layout')
@php
    $section1 = [
        [
            'number' => $introduce['block_1_number_1'],
            'title' => 'Chuyên Gia'
        ],
        [
            'number' => $introduce['block_1_number_2'],
            'title' => 'Năm Kinh Nghiệm'
        ],
        [
            'number' => $introduce['block_1_number_3'],
            'title' => 'Tổ chức hàng đầu'
        ],
    ];

    $section2 = [
        [
            'icon' => 'frontend/resources/img/intro-icon-1.png',
            'title' => $introduce['block_2_text_1'],
        ],
        [
            'icon' => 'frontend/resources/img/intro-icon-2.png',
            'title' => $introduce['block_2_text_2'],
        ],
        [
            'icon' => 'frontend/resources/img/intro-icon-3.png',
            'title' => $introduce['block_2_text_3'],
        ]
    ];
@endphp
@section('content')
    <div class="intro-container">
        <div class="intro-section-1" style="background:url({{ $introduce['block_1_background'] }})">
            <div class="breadcrumb uk-text-center uk-flex uk-flex-center">
                <ul class="uk-list uk-clearfix uk-flex uk-flex-middle">
                    <li>
                        <a href="/">{{ __('frontend.home') }}</a>
                    </li>
                    <li>
                        <span class="slash">/</span>
                    </li>
                    @if(!is_null($breadcrumb))
                        @foreach($breadcrumb as $key => $val)
                            @php
                                $name = $val->languages->first()->pivot->name;
                                $canonical = write_url($val->languages->first()->pivot->canonical, true, true);
                            @endphp
                            <li>
                                <a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="section-1-info uk-text-center">
                <div class="heading">{{ $introduce['block_1_title'] }}</div>
                <div class="description">{{ $introduce['block_1_description'] }}</div>
                <div class="section-1-list">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($section1 as $item)
                        <div class="uk-width-large-1-3">
                            <div class="section-1-item uk-text-center">
                                <div class="number">{{ $item['number'] }}</div>
                                <div class="title">{{ $item['title'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="button-group">
                    <div class="uk-flex uk-flex-middle uk-flex-center">
                        <a href="{{ $introduce['block_1_button_1_link'] }}" class="button-style-1">{{ $introduce['block_1_button_1'] }}</a>
                        <a href="{{ $introduce['block_1_button_2_link'] }}" class="button-style-2">{{ $introduce['block_1_button_2'] }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            <div class="intro-section-2">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="heading">{{ $introduce['block_2_title'] }}</div>
                        <ul class="uk-list uk-clearfix intro-2-list">
                            @foreach($section2 as $item)
                            <li>
                                <a href="" class="uk-flex uk-flex-middle">
                                    <img src="{{ $item['icon'] }}" alt="{{ $item['title'] }}">
                                    <span>{{ $item['title'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="intro-2-button">
                            <a href="{{ $introduce['block_2_button_link'] }}">{{ $introduce['block_2_button'] }}</a>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <img src="{{ $introduce['block_2_image'] }}" alt="2">
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-section-3">
            <div class="uk-container uk-container-center">
                <div class="heading">{{ $introduce['block_3_title'] }}</div>
                <div class="number-line">
                    .uk-grid.uk-grid-medium.uk-width-
                </div>
            </div>
        </div>
    </div>


   
@endsection

