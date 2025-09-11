<div class="panel-foot">
    <h2 class="cart-heading"><span>Phương thức thanh toán</span></h2>
    <div class="cart-method mb30">
        @foreach(__('payment.method') as $key => $val)
            <label for="{{ $val['name'] }}" class="uk-flex uk-flex-middle method-item">
                <input 
                    type="radio"
                    name="method"
                    value="{{ $val['name'] }}"
                    @if (old('method', '') == $val['name'] || (!old('method') && $key == 0)) checked @endif
                    id="{{ $val['name'] }}"
                >
                <span class="image"><img src="{{ $val['image'] }}" alt=""></span>
                <span class="title">{{ $val['title'] }}</span>
            </label>
        @endforeach
        <label for="bank" class="uk-flex uk-flex-middle method-item">
            <input type="radio" name="method" value="bank" id="bank">
            <span class="image"><img src="/userfiles/image/other.png" alt=""></span>
            <span class="title">Thanh toán qua ngân hàng</span>
        </label>
        <div class="payment-info" id="bank-info">
            <h3>Thông tin chuyển khoản ngân hàng</h3>
            <div class="bank-details">
                <p><strong>Ngân hàng:</strong> {{ $system['bank_1'] }}</p>
                <p><strong>Số tài khoản:</strong> {{ $system['bank_2'] }}</p>
                <p><strong>Chủ tài khoản:</strong> {{ $system['bank_3'] }}</p>
            </div>
            <p class="note">Sau khi chuyển khoản, vui lòng giữ lại biên lai và liên hệ với chúng tôi để xác nhận thanh toán.</p>
        </div>
        <label for="qr_bank" class="uk-flex uk-flex-middle method-item">
            <input type="radio" name="method" value="qr_bank" id="qr_bank">
            <span class="image"><img src="frontend/resources/core/img/qr_code.svg" alt=""></span>
            <span class="title">Chuyển khoản qua QR</span>
        </label>
        <div class="payment-info" id="qr-info">
                <h3>Quét mã QR để thanh toán</h3>
                <div class="qr-code">
                    <img src="{{ $system['bank_4'] }}" alt="Mã QR thanh toán">
                </div>
                <p class="note">Vui lòng sử dụng ứng dụng ngân hàng của bạn để quét mã QR và thực hiện thanh toán.</p>
            </div>
        </div>
    <div class="cart-return mb10">
        <span>{!! __('payment.return') !!}</span>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodRadios = document.querySelectorAll('input[name="method"]');
        const bankInfo = document.getElementById('bank-info');
        const qrInfo = document.getElementById('qr-info');
        
        methodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                bankInfo.style.display = 'none';
                qrInfo.style.display = 'none';
                
                if (this.value === 'bank') {
                    bankInfo.style.display = 'block';
                } else if (this.value === 'qr_bank') {
                    qrInfo.style.display = 'block';
                }
            });
        });
        
        const selectedMethod = document.querySelector('input[name="method"]:checked');
        if (selectedMethod) {
            selectedMethod.dispatchEvent(new Event('change'));
        }
    });
</script>