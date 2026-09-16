@extends('frontend.homepage.layout')
@section('content')
    <div class="contact-page">
        <div class="uk-container uk-container-center">
            <div class="mt40 mb40 banner">
                <a href="" class="image img-cover">
                    <img src="{{ $system['background_1'] }}" alt="">
                </a>
                <div class="text-overlay">
                    <h2 class="heading-1"><span>Liên hệ với chúng tôi</span></h2>
                    <div class="description">
                        <p>Bạn đang có những thắc mắc, nan giải về khóa học hãy chia sẻ vấn đề với chúng tôi</p>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <div class="wrapper">
                    <div class="frm-ct">
                        <h3 class="heading-2"><span>Liên hệ ngay</span></h3>
                        <p class="des">{{ $system['text_12'] }}</p>
                        {{-- Chi hien loi nhap lieu o day. Thong bao thanh cong / that bai
                             KHONG kiem tra bang session('success'): du an dung php-flasher,
                             no chan redirect()->with('success'|'error') va chuyen thanh
                             thong bao dang toast, nen session('success') luon rong - viet
                             @if(session('success')) o day se la code chet. --}}
                        @if($errors->any())
                            <div class="uk-alert uk-alert-danger mb20">
                                <ul class="mb0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('contact.save') }}" method="POST" class="ct-form">
                            @csrf
                            <div class="form-group">
                                <label for="name">Họ tên</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Tiêu đề</label>
                                <input type="text" id="content" name="content" value="{{ old('content') }}" placeholder="Tôi cần hỗ trợ về..." required>
                            </div>
                            <div class="form-group">
                                <label for="description">Nội dung cần hỗ trợ</label>
                                <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                            </div>
                            <div class="btn">
                                <button type="submit" class="submit-btn">Xác nhận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-info">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-medium-2-5">
                        <div class="contact-details">
                            <h3 class="heading-2"><span>Liên hệ</span></h3>
                            <div class="info">
                                <p>📍 {{ $system['contact_office'] }}</p>
                                <p>
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.1677 1.59643C13.3756 1.59643 13.5439 1.42808 13.5439 1.22021V0.467773C13.5439 0.259911 13.3756 0.0915527 13.1677 0.0915527H0.37622C0.168359 0.0915527 0 0.259911 0 0.467773V1.22021C0 1.42808 0.168359 1.59643 0.37622 1.59643H0.751971V10.6257H0.37622C0.168359 10.6257 0 10.7941 0 11.0019V11.7544C0 11.9622 0.168359 12.1306 0.37622 12.1306H6.01953V10.2495C6.01953 10.0426 6.18883 9.87329 6.39575 9.87329H7.14819C7.35511 9.87329 7.52441 10.0426 7.52441 10.2495V12.1306H13.1677C13.3756 12.1306 13.5439 11.9622 13.5439 11.7544V11.0019C13.5439 10.7941 13.3756 10.6257 13.1677 10.6257H12.7915V1.59643H13.1677ZM6.01953 2.64985C6.01953 2.49936 6.17002 2.34888 6.3205 2.34888H7.22343C7.37392 2.34888 7.52441 2.49936 7.52441 2.64985V3.55278C7.52441 3.70327 7.37392 3.85376 7.22343 3.85376H6.3205C6.17002 3.85376 6.01953 3.70327 6.01953 3.55278V2.64985ZM6.01953 4.90717C6.01953 4.75669 6.17002 4.6062 6.3205 4.6062H7.22343C7.37392 4.6062 7.52441 4.75669 7.52441 4.90717V5.8101C7.52441 5.96059 7.37392 6.11108 7.22343 6.11108H6.3205C6.17002 6.11108 6.01953 5.96059 6.01953 5.8101V4.90717ZM3.00976 2.64985C3.00976 2.49936 3.16025 2.34888 3.31074 2.34888H4.21367C4.36416 2.34888 4.51465 2.49936 4.51465 2.64985V3.55278C4.51465 3.70327 4.36416 3.85376 4.21367 3.85376H3.31074C3.16025 3.85376 3.00976 3.70327 3.00976 3.55278V2.64985ZM4.21367 6.11108H3.31074C3.16025 6.11108 3.00976 5.96059 3.00976 5.8101V4.90717C3.00976 4.75669 3.16025 4.6062 3.31074 4.6062H4.21367C4.36416 4.6062 4.51465 4.75669 4.51465 4.90717V5.8101C4.51465 5.96059 4.36416 6.11108 4.21367 6.11108ZM4.51465 9.12084C4.51465 7.87414 5.52527 6.86352 6.77197 6.86352C8.01867 6.86352 9.02929 7.87414 9.02929 9.12084H4.51465ZM10.5342 5.8101C10.5342 5.96059 10.3837 6.11108 10.2332 6.11108H9.33027C9.17978 6.11108 9.02929 5.96059 9.02929 5.8101V4.90717C9.02929 4.75669 9.17978 4.6062 9.33027 4.6062H10.2332C10.3837 4.6062 10.5342 4.75669 10.5342 4.90717V5.8101ZM10.5342 3.55278C10.5342 3.70327 10.3837 3.85376 10.2332 3.85376H9.33027C9.17978 3.85376 9.02929 3.70327 9.02929 3.55278V2.64985C9.02929 2.49936 9.17978 2.34888 9.33027 2.34888H10.2332C10.3837 2.34888 10.5342 2.49936 10.5342 2.64985V3.55278Z" fill="#666666"/>
                                    </svg>
                                    {{ $system['contact_office'] }}
                                </p>
                                <p>
                                    <a href="tel:{{ $system['contact_hotline'] }}" title="">📞 {{ $system['contact_hotline'] }}</a>
                                </p>
                                <p>
                                    ✉️ <a href="mailto:{{ $system['contact_email'] }}" title="" class="mail">{{ $system['contact_email'] }}</a>
                                </p>
                            </div>
                            <h3 class="heading-2"><span>Thời gian làm việc</span></h3>
                            <ul class="working-hours">
                                <li>
                                    Thứ 2 - thứ 6
                                    <br>
                                    (8h00 - 17h00)
                                </li>
                                <li>
                                    Thứ 7
                                    <br>
                                    (8h00 - 12h00)
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="uk-width-medium-3-5">
                        <div class="map-container">
                            {!! $system['contact_map'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

