@extends('frontend.homepage.layout')
@section('content')
    <div class="register-container">
        <div class="uk-container uk-container-center">
            <div class="register-page">
                <div class="page-breadcrumb">
                    <div class="uk-container uk-container-center">
                        <ul class="uk-list uk-clearfix uk-flex uk-flex-middle">
                            <li>
                                <a href="/">Trang chủ</a>
                            </li>
                            <li>
                                <span class="slash">/</span>
                            </li>
                            <li>
                                <a href="" title="Đăng ký" class="rg">Đăng ký</a>
                            </li>
                        </ul>
                    </div>
                </div>    
                @php
                    $slideKeyword = App\Enums\SlideEnum::WHYCHOOSE;
                @endphp  
                @if(count($slides[$slideKeyword]['item']))
                    <div class="panel-why-choose">
                        <div class="uk-container uk-container-center">
                            <div class="background-overlay image img-cover">
                                <img src="{{ $system['background_1'] }}" alt="">
                            </div>
                            <div class="bl">
                                <div class="panel-head">
                                    <h2 class="heading-1">
                                        <span>{{ $slides[$slideKeyword]['name'] }}</span>
                                    </h2>
                                    <div class="description">{{ $slides[$slideKeyword]['short_code'] }}</div>
                                </div>
                                <div class="panel-body">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            @foreach($slides[$slideKeyword]['item'] as $key => $val )
                                                <div class="swiper-slide">
                                                    <div class="slide-item">
                                                        <a href="" class="image img-cover">
                                                            <img src="{{ $val['image'] }}" alt="">
                                                        </a>
                                                        <div class="name">
                                                            {{ $val['name'] }}
                                                        </div>
                                                        <div class="description">
                                                            {{ $val['alt'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="panel-register">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-medium-1-2">
                            <div class="register-frm">
                                <h2 class="heading-1"><span>Đăng ký</span></h2>
                                <div class="subtitle">Đăng ký ngay để nhận ưu đãi từ chúng tôi</div>
                                <form action="{{ route('customer.reg') }}" method="POST" class="rf">
                                    @csrf
                                    <input type="hidden" name="customer_catalogue_id" value="1">
                                    <div class="form-group">
                                        <label for="name">Họ và tên</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Họ và tên">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email của bạn</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email của bạn">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="re_password">Xác nhận mật khẩu</label>
                                        <input type="password" id="re_password" name="re_password" placeholder="Xác nhận mật khẩu">
                                        @error('re_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <p class="condition">
                                        Bằng cách đăng ký, bạn đã đồng ý với 
                                        <a href="#" target="_blank" class="policies">điều khoản và chính sách</a> 
                                        của chúng tôi
                                    </p>
                                    <button type="submit" class="submit-btn">Đăng ký</button>
                                    <div class="login-link">
                                        Bạn đã có tài khoản ? <a href="#modal-login" id="loginLink" data-uk-modal>Đăng nhập</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="image-content">
                                <div class="bg-overlay">
                                    <img src="{{ $system['background_3'] }}" alt="">
                                </div>
                                <div class="txt-overlay">
                                    <svg width="25" height="20" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.6562 9.87292H18.75V7.05208C18.75 5.49622 20.1514 4.23125 21.875 4.23125H22.2656C22.915 4.23125 23.4375 3.75964 23.4375 3.17344V1.05781C23.4375 0.471608 22.915 0 22.2656 0H21.875C17.5586 0 14.0625 3.15581 14.0625 7.05208V17.6302C14.0625 18.7982 15.1123 19.7458 16.4062 19.7458H22.6562C23.9502 19.7458 25 18.7982 25 17.6302V11.9885C25 10.8205 23.9502 9.87292 22.6562 9.87292ZM8.59375 9.87292H4.6875V7.05208C4.6875 5.49622 6.08887 4.23125 7.8125 4.23125H8.20312C8.85254 4.23125 9.375 3.75964 9.375 3.17344V1.05781C9.375 0.471608 8.85254 0 8.20312 0H7.8125C3.49609 0 0 3.15581 0 7.05208V17.6302C0 18.7982 1.0498 19.7458 2.34375 19.7458H8.59375C9.8877 19.7458 10.9375 18.7982 10.9375 17.6302V11.9885C10.9375 10.8205 9.8877 9.87292 8.59375 9.87292Z" fill="white"/>
                                    </svg>
                                    <p>{{  $system['text_1']  }}</p>
                                </div>
                                <a href="" class="image img-cover">
                                    <img src="{{ $system['background_2'] }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection