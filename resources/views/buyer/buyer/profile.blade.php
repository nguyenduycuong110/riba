@extends('frontend.homepage.layout')
@section('content')
    <div id="buyer-signup"> 
        <div class="page-breadcrumb background">      
            <div class="uk-container uk-container-center">
                <ul class="uk-list uk-clearfix uk-flex uk-flex-middle">
                    <li>
                        <a href="/" title="Trang chủ">Trang chủ</a>
                    </li>
                    <li>    
                        <span class="slash">/</span>
                    </li>
                    <li>
                        <a href="{{ route('buyer.profile') }}" title="Thông tin tài khoản">Thông tin tài khoản</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="profile-container buyer-page">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-4">
                        @include('buyer.buyer.component.aside')
                    </div>
                    <div class="uk-width-large-3-4">
                        <div class="profile-content buyer-wrapper">
                            <div class="panel-head">
                                <div class="heading-2"><span>Hồ sơ của tôi</span></div>
                                <div class="description">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
                            </div>
                            <div class="panel-body">
                                @include('backend.dashboard.component.formError')
                                <form action="{{ route('buyer.profile.update') }}" method="post" class="uk-form form">
                                    @csrf
                                    <div class="form-row">
                                        <span class="label-name">Họ Tên:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="name"
                                                value="{{ $buyer->name }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Số điện thoại:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="phone"
                                                value="{{ $buyer->phone }}"
                                                placeholder=" {{ $buyer->phone ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Email:</span>
                                        <span class="label-value">{{ $buyer->email }}</span>
                                    </div>

                                    {{-- <div class="form-row">
                                        <span class="label-name">Thành phố:</span>
                                        <span class="label-value">
                                            <select name="province_id" class="input-text city">
                                                <option value="0">[Chọn Thành Phố]</option>
                                                @if($provinces['data'])
                                                    @foreach($provinces['data'] as $city)
                                                    <option value="{{ $city['PROVINCE_ID'] }}">{{ $city['PROVINCE_NAME'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Quận/Huyện:</span>
                                        <span class="label-value">
                                            <select name="district_id" class="input-text district">
                                                <option value="0">[Chọn Quận/Huyện]</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Chọn Phường Xã:</span>
                                        <span class="label-value">
                                            <select name="ward_id" class="input-text ward">
                                                <option value="0">[Chọn Phường/Xã]</option>
                                            </select>
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Địa chỉ:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="address"
                                                value="{{ $buyer->address }}"
                                                placeholder=" {{ $buyer->address ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Tài khoản ViettelPost:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="viettelpost_email"
                                                value="{{ $buyer->viettelpost_email }}"
                                                placeholder=" {{ $buyer->viettelpost_email ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Mật khẩu ViettelPost:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="viettelpost_password"
                                                value="{{ $buyer->viettelpost_password }}"
                                                placeholder=" {{ $buyer->viettelpost_password ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div> --}}
                                   
                                    <button type="submit" href="" class="button-shop change-info">Thay đổi thông tin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var province_id = '{{ (isset($buyer->province_id)) ? $buyer->province_id : old('province_id') }}'
        var district_id = '{{ (isset($buyer->district_id)) ? $buyer->district_id : old('district_id') }}'
        var ward_id = '{{ (isset($buyer->ward_id)) ? $buyer->ward_id : old('ward_id') }}'
    </script>

@endsection
