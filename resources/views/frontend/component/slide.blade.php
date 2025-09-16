@php
    $slideKeyword = App\Enums\SlideEnum::MAIN;
@endphp
@if(count($slides[$slideKeyword]['item']))
    <div class="panel-slide page-setup" data-setting="">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($slides[$slideKeyword]['item'] as $key => $val )
                    <div class="swiper-slide">
                        <a href="{{ $val['canonical'] }}" title="" class="image img-cover wow fadeInRight" data-wow-delay="0.8s">
                            <img src="{{ $val['image'] }}" alt="{{ $val['name'] }}">
                        </a>
                        <div class="slide-overlay">
                            <h2 class="slide-heading"><span>{{ $val['name'] }}</span></h2>
                            <div class="slide-description">{{ $val['alt'] }}</div>
                            <div class="slide-content">{{ $val['description'] }}</div>
                            <div class="slide-button uk-flex uk-flex-middle uk-flex-center">
                                <a href="{{ $val['canonical'] }}" class="uk-button button-primary uk-position-relative button-style-1">
                                    Bắt đầu ngay
                                </a>
                                <div class="phone-call ml20  wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                                    <div class="phone-icon">
                                        <img src="/vendor/frontend/img/project/phone-call-1.png" alt="">
                                    </div>
                                    <div class="phone-info">
                                        <div class="phone-label">Hoặc gọi trực tiếp</div>
                                        <a href="tel:0971.746.845" class="phone-number text-white">{{ $system['contact_hotline'] }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif