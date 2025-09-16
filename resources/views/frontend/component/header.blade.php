@php
    $socialItem = ['facebook', 'google', 'tiktok', 'twitter']
@endphp
<div id="header" class="pc-header uk-visible-large">
    <div class="header-top">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="header-contact uk-flex uk-flex-middle">
                    <a class="header-contact__item email">{{ $system['contact_email'] }}</a>
                    <a class="header-contact__item phone">{{ $system['contact_hotline'] }}</a>
                </div>
                <div class="header-widget uk-flex uk-flex-middle">
                    <div class="header-widget__menu uk-flex uk-flex-middle">
                        <a class="widget_menu__item" href="#">FAQ</a>
                        <a class="widget_menu__item" href="#">Hỗ Trợ</a>
                        <a class="widget_menu__item" href="#">Liên Hệ</a>
                    </div>
                    <ul class="header-widget__social uk-flex uk-flex-middle uk-clearfix">
                        @foreach($socialItem as $item)
                        <li>
                            <a href="{{ $system['social_'.$item] }}" class="{{ $item }} wow fadeInLeft"  title="{{ $item }}" target="_blank">
                            <img src="/vendor/frontend/img/{{ $item }}.svg" alt="{{ $item }}">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="header-middle__widget uk-flex uk-flex-middle">
                    <div class="logo">
                        <a href="/" class="main-logo logo"><img src="{{ $system['homepage_logo'] }}" alt=""></a>
                    </div>
                    @include('frontend.component.navigation')
                </div>
                <div class="header-middle__search">
                    <form action="tim-kiem" class="form-search">
                        <input type="text" name="keyword" value="" placeholder="Nhập từ khóa muốn tìm kiếm ?">
                        <button type="submit" class="btn-search">
                            <img src="/vendor/frontend/img/search.svg" alt="">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.component.header-mobile')
{{-- @include('frontend.auth.index') --}}