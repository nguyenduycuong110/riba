<footer id="footer">
    <div class="footer-upper">
        <div class="uk-container uk-container-center">
            <div class="name-company">
                <h3 class="heading-2 wow fadeInDown" data-wow-delay="0.3s"><span>{{ $system['homepage_company'] }}</span></h3>
            </div>
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-medium-2-5">
                    <div class="info-company wow fadeInDown" data-wow-delay="0.3s">
                        <p class="office">Văn phòng Hà Nội</p>
                        <p class="address">- Địa chỉ: {{ $system['contact_office'] }}</p>
                        <p class="hotline">
                            - Hotline: <a href="tel:{{ $system['contact_hotline'] }}">{{ $system['contact_hotline'] }} </a>
                        </p>
                        <p class="address">- Email: <a href="mailto:{{ $system['contact_email'] }}">{{ $system['contact_email'] }}</a></p>
                        <p class="website">- Website: <a href="{{ $system['contact_website'] }}">{{ $system['contact_website'] }}</a></p>
                    </div>
                </div>
                @if($menu['footer-menu'])
                    @foreach($menu['footer-menu'] as $key => $val)
                        @php
                            $name = $val['item']->languages->first()->pivot->name;
                            $canonical = write_url($val['item']->languages->first()->pivot->canonical);
                        @endphp
                        <div class="uk-width-medium-1-6">
                            <div class="footer-menu__item wow fadeInDown" data-wow-delay="0.3s">
                                <h3 class="heading-2"><span>{{ $name }}</span></h3>
                                @if($val['children'])
                                <ul class="uk-list uk-clearfix">
                                    @foreach($val['children'] as $children)
                                    @php
                                        $nameC = $children['item']->languages->first()->pivot->name;
                                        $canonicalC = write_url($children['item']->languages->first()->pivot->canonical);
                                    @endphp
                                    <li>
                                        <a href="{{ $canonicalC }}" title="{{ $nameC }}" >- {{ $nameC }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="uk-width-medium-1-4">
                    <div class="footer-menu__item wow fadeInDown" data-wow-delay="0.3s">
                        <h3 class="heading-2"><span>Liên kết</span></h3>
                        <div class="fb-page" data-href="{{ $system['social_facebook'] }}"  data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright " >
        <div class="uk-container uk-container-center">
            <p class="wow fadeInUp" data-wow-delay="0.3s">{{ $system['homepage_copyright'] }}</p>
        </div>
    </div>
</footer>

<!-- ==================== RIGHT SIDE CONTACT WIDGET (ZALO & MESSENGER) ==================== -->
<div class="contact-floating-widget">
    <!-- Nút Messenger (Nằm phía trên) -->
    <a href="{{ $system['social_messenger'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="contact-link messenger-link">
        <!-- Vòng sóng tỏa -->
        <span class="contact-wave wave-messenger-1"></span>
        <span class="contact-wave wave-messenger-2"></span>
        
        <!-- Nút tròn chứa Logo Messenger -->
        <div class="contact-btn-circle messenger-btn">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="contact-svg">
                <path d="M12 2C6.477 2 2 6.145 2 11.258c0 2.914 1.46 5.513 3.75 7.15V22l3.412-1.875A12.016 12.016 0 0012 20.516c5.523 0 10-4.145 10-9.258C22 6.145 17.523 2 12 2zm1.096 12.21l-2.617-2.79-5.1 2.79 5.61-5.957 2.617 2.79 5.099-2.79-5.609 5.957z" fill="#FFFFFF"/>
            </svg>
        </div>
        <!-- Nhãn chữ trượt về bên trái -->
        <div class="contact-tooltip-bubble">Nhắn tin Messenger</div>
    </a>

    <!-- Nút Zalo (Nằm phía dưới) -->
    <a href="https://zalo.me/{{ $system['contact_hotline'] }}" target="_blank" rel="noopener noreferrer" class="contact-link zalo-link">
        <!-- Vòng sóng tỏa -->
        <span class="contact-wave wave-zalo-1"></span>
        <span class="contact-wave wave-zalo-2"></span>
        
        <!-- Nút tròn chứa Logo Zalo -->
        <div class="contact-btn-circle zalo-btn">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="contact-svg">
                <path d="M12 0C5.37 0 0 4.7 0 10.5c0 3.2 1.68 6.1 4.32 8-.13.77-.48 2.8-.57 3.52-.11.85.4.84.72.61.43-.3 2.78-1.93 3.9-2.7 1.13.32 2.33.49 3.63.49 6.63 0 12-4.7 12-10.5S18.63 0 12 0zm-4.47 13.91H4.64v-1.08l2.89-3.95H4.81V7.8h3.49v1.08L5.41 12.83h3.11v1.08zm4.72 0h-1.43V7.8h1.43v6.11zm3.83-4.25c-.73 0-1.33.59-1.33 1.32v2.93c0 .73.6 1.32 1.33 1.32s1.32-.59 1.32-1.32v-2.93c0-.73-.59-1.32-1.32-1.32z" fill="#FFFFFF"/>
            </svg>
        </div>
        <!-- Nhãn chữ trượt về bên trái -->
        <div class="contact-tooltip-bubble">Chat Zalo với chúng tôi</div>
    </a>
</div>

<style>
/* Cấu hình chung cho Widget */
.contact-floating-widget {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 16px; /* Khoảng cách giữa Zalo và Messenger */
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.contact-floating-widget .contact-link {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Căn lề phải để tooltip trượt sang trái */
    text-decoration: none;
}

/* Nút hình tròn chung */
.contact-floating-widget .contact-btn-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    position: relative;
    z-index: 10;
}

/* Màu nền Zalo */
.contact-floating-widget .zalo-btn {
    background-color: #0068ff;
    box-shadow: 0 4px 16px rgba(0, 104, 255, 0.4);
}

/* Màu nền Gradient Messenger chính hãng */
.contact-floating-widget .messenger-btn {
    background: linear-gradient(135deg, #0084FF 0%, #A132DB 50%, #FF5C8A 100%);
    box-shadow: 0 4px 16px rgba(161, 50, 219, 0.4);
}

/* Logo SVG */
.contact-floating-widget .contact-svg {
    width: 28px;
    height: 28px;
    transition: transform 0.3s ease;
}

/* Hiệu ứng Hover phóng to nút */
.contact-floating-widget .contact-link:hover .contact-btn-circle {
    transform: scale(1.1);
}

.contact-floating-widget .contact-link:hover .zalo-btn {
    background-color: #0056d6;
    box-shadow: 0 6px 20px rgba(0, 104, 255, 0.6);
}

.contact-floating-widget .contact-link:hover .messenger-btn {
    box-shadow: 0 6px 20px rgba(161, 50, 219, 0.6);
}

.contact-floating-widget .contact-link:hover .contact-svg {
    transform: rotate(5deg) scale(1.05);
}

/* Hiệu ứng Sóng tỏa (Pulse Wave Animation) */
.contact-floating-widget .contact-wave {
    position: absolute;
    top: 0;
    right: 0;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    z-index: 1;
    pointer-events: none;
}

/* Màu sóng tỏa cho Zalo */
.contact-floating-widget .wave-zalo-1,
.contact-floating-widget .wave-zalo-2 {
    background-color: rgba(0, 104, 255, 0.4);
}

/* Màu sóng tỏa cho Messenger */
.contact-floating-widget .wave-messenger-1,
.contact-floating-widget .wave-messenger-2 {
    background-color: rgba(161, 50, 219, 0.4);
}

.contact-floating-widget .wave-zalo-1,
.contact-floating-widget .wave-messenger-1 {
    animation: contactPulse 2s infinite ease-out;
}

.contact-floating-widget .wave-zalo-2,
.contact-floating-widget .wave-messenger-2 {
    animation: contactPulse 2s infinite ease-out 1s;
}

@keyframes contactPulse {
    0% {
        transform: scale(1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1.6);
        opacity: 0;
    }
}

/* Nhãn Tooltip trượt về bên trái */
.contact-floating-widget .contact-tooltip-bubble {
    position: absolute;
    right: 65px; /* Nằm cách bên trái nút tròn */
    white-space: nowrap;
    background-color: #1e293b;
    color: #ffffff;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateX(10px); /* Trượt nhẹ từ phải sang trái */
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    pointer-events: none;
    z-index: 5;
}

/* Kích hoạt Tooltip khi Hover */
.contact-floating-widget .contact-link:hover .contact-tooltip-bubble {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}
</style>



<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v24.0&appId=103609027035330"></script>