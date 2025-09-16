(function($) {
   "use strict";
   var HT = {}; // Khai báo là 1 đối tượng
   var timer = null
   var _token = $('meta[name="csrf-token"]').attr('content');

/* MAIN VARIABLE */

   var   $window = $(window),
         $document = $(document);


   // FUNCTION DECLARGE
   $.fn.elExists = function() {
     return this.length > 0;
   };

   HT.addWishlish = () => {
      $(document).on('click', '.addToWishlist', function(e){
         e.preventDefault()

         let _this = $(this)
        
         $.ajax({
            url: 'ajax/product/wishlist', 
            type: 'POST', 
            data: {
               id: _this.attr('data-id'),
               _token: _token
            }, 
            dataType: 'json', 
            beforeSend: function() {
               
            },
            success: function(res) {
               toastr.success(res.message, 'Thông báo từ hệ thống!')
               if(res.code == 1){
                  _this.removeClass('active')
               }else if(res.code == 2){
                  _this.addClass('active')
               }
            },
         });

      })
   }

    HT.addCart = () => {
        $(document).on('click', '.addToCart', function(e){
            e.preventDefault()
            let _this = $(this)
            let id = _this.attr('data-id')
            let quantity = $('.quantity-text').val()
            let type_promotion = $('input[name="type_promotion"]:checked').val();
            if(typeof quantity === 'undefined'){
                quantity = 1
            }
            let redirect = _this.attr('data-redirect')

            let attribute_id = []
            $('.attribute-value .choose-attribute').each(function(){
                let _this = $(this)
                if(_this.hasClass('active')){
                    attribute_id.push(_this.attr('data-attributeid'))
                }
            })

            let voucher_item = []

            $('.info-voucher').each(function(){
                let _this = $(this)
                if(_this.hasClass('active')){
                    voucher_item = {
                        'id' : _this.data('voucher'),
                    };
                }
            });

            let option = {
                id : id,
                quantity: quantity,
                attribute_id: attribute_id,
                voucher_id : voucher_item.id,
                type_promotion : type_promotion,
                _token: _token
            }

            $.ajax({
                    url: 'ajax/cart/create', 
                    type: 'POST', 
                    data: option, 
                    dataType: 'json', 
                    beforeSend: function() {
                        
                    },
                    success: function(res) {
                    toastr.clear()
                        if(res.code === 10){
                            toastr.success(res.messages, 'Thông báo từ hệ thống!')
                            if(redirect == 1){
                                window.location.href = 'gio-hang.html'
                            }
                        }else{
                            toastr.error('Có vấn đề xảy ra! Hãy thử lại', 'Thông báo từ hệ thống!')
                        }
                    },
                });


        })
    }

    HT.changeQuantity = () => {
        $(document).on('click', '.btn-qty', function(){
            let _this = $(this)
            let qtyElement = _this.siblings('.input-qty')
            let qty = qtyElement.val()
            let newQty = (_this.hasClass('minus')) ? parseInt(qty) - 1 : parseInt(qty) + 1
            newQty = (newQty < 1) ? 1 : newQty
            qtyElement.val(newQty)

            let option = {
                qty: newQty,
                rowId: _this.siblings('.rowId').val(),
                _token: _token
            }

            HT.handleUpdateCart(_this, option)
        })
   }

    HT.changeQuantityInput = () => {
        $(document).on('change', '.input-qty', function(){
            let _this = $(this)
            let option = {
                qty: (parseInt(_this.val()) == 0) ? 1 : parseInt(_this.val()),
                rowId: _this.siblings('.rowId').val(),
                _token: _token
            }

            if(isNaN(option.qty)){
                toastr.error('Số lượng nhập không chính xác', 'Thông báo từ hệ thống!')
                return false
            }

            HT.handleUpdateCart(_this, option)
        })
    }

    HT.handleUpdateCart = (_this, option) => {
        $.ajax({
            url: 'ajax/cart/update', 
            type: 'POST', 
            data: option, 
            dataType: 'json', 
            beforeSend: function() {
                
            },
            success: function(res) {
                toastr.clear()
                if(res.code === 10){
                    HT.changeMinyCartQuantity(res)
                    HT.changeVoucherDiscountForProduct(res)
                    HT.activeVoucher(res)
                    HT.changeMinyQuantityItem(_this, option)
                    HT.changeCartItemSubTotal(_this, res)
                    HT.changeCartTotal(res)
                    toastr.success(res.messages, 'Thông báo từ hệ thống!')
                }else{
                    toastr.error('Có vấn đề xảy ra! Hãy thử lại', 'Thông báo từ hệ thống!')
                }
            },
        });
    }

    HT.activeVoucher = (res) => {
        let cartTotal = res.response.cartTotal
        $('.voucher-item').each(function(){
            let min_order = $(this).data('min-order');
            if(min_order && cartTotal >= min_order){
                $(this).addClass('coupon-use')
            }else if(min_order && cartTotal < min_order){
                $(this).removeClass('coupon-use')
            }
        })
    }

    HT.changeVoucherDiscountForProduct = (res) => {
        let discount = 0
        if(res.response.cartItemUpdate.options.voucher){
            discount = res.response.cartItemUpdate.qty * res.response.cartItemUpdate.options.voucher.discount
        }
        $('.cart-item').each(function(){
            if($(this).data('pd') == res.response.cartItemUpdate.id){
                $(this).find('.voucher-discount').html('-'+(addCommas(discount))+'đ')
            }
        })
    }

    HT.changeMinyQuantityItem = (item, option) => {
        item.parents('.cart-item').find('.cart-item-number').html(option.qty)
    }

    HT.changeCartItemSubTotal = (item, res) => {
        let discount = res.response.cartVoucher || 0;
        item.parents('.cart-item-info').find('.cart-price-sale').html(addCommas(res.response.cartItemSubTotal - discount)+'đ')
    }

    HT.changeMinyCartQuantity = (res) => {
        $('#cartTotalItem').html(res.response.cartTotalItems)  
    }

    HT.changeCartTotal = (res) => {
        $('.cart-total').html(addCommas(res.response.cartTotal)+'đ')
        $('.discount-value').html('-' + addCommas(res.response.cartDiscount) + 'đ')
        $('.voucher-value').html('-' + addCommas(res.response.cartVoucher) + 'đ')
        $('.ship-value').html(addCommas(res.response.ship) + 'đ')
    }

    HT.removeCartItem = () => {
        $(document).on('click', '.cart-item-remove', function(){
            let _this = $(this)
            let option = {
                rowId: _this.attr('data-row-id'),
                _token: _token
            }
            $.ajax({
                url: 'ajax/cart/delete', 
                type: 'POST', 
                data: option, 
                dataType: 'json', 
                beforeSend: function() {
                
                },
                success: function(res) {
                toastr.clear()
                if(res.code === 10){
                    HT.changeMinyCartQuantity(res)
                    HT.unActiveVoucher(res)
                    HT.changeCartTotal(res)
                    HT.removeCartItemRow(_this)
                    toastr.success(res.messages, 'Thông báo từ hệ thống!')
                }else{
                    toastr.error('Có vấn đề xảy ra! Hãy thử lại', 'Thông báo từ hệ thống!')
                }
                },
            });
        })
    }
    
    HT.unActiveVoucher = (res) => {
        let cartTotal = res.response.cartTotal
        if(cartTotal == 0){
            $('.panel-voucher').hide()
            return
        }
        if(res.response.ship == 0){
           $('.voucher-item[data-min-shipping]').removeClass('coupon-use')
        }
        $('.voucher-item').each(function(){
            let min_order = $(this).data('min-order');
            if(res.response.voucherUnActive){
                $('.voucher-item[data-id="' + res.response.voucherUnActive + '"]').removeClass('use');
            }
            if(min_order && cartTotal >= min_order){
                $(this).addClass('coupon-use')
            }else if(min_order && cartTotal < min_order){
                $(this).removeClass('coupon-use')
            }
        })
    }

    HT.removeCartItemRow = (_this) => {
        _this.parents('.cart-item').remove()
    }

    HT.setupSelect2 = () => {
        if($('.setupSelect2').length){
            $('.setupSelect2').select2();
        }
    }
    
    HT.applyVoucher = () => {
        $(document).on('click','.voucher-item', function(){
            let _this = $(this)
            if(_this.hasClass('use')){
                return;
            }
            const voucher_id = _this.data('id')
            $.ajax({
                url: 'ajax/cart/applyCartVoucher', 
                type: 'GET', 
                data: {
                    voucher_id : voucher_id
                }, 
                dataType: 'json', 
                beforeSend: function() {
                
                },
                success: function(res) {
                    if(res.code == 10){
                        if(res.response.combine_voucher == false){
                            toastr.error('Voucher không được áp dụng do đã được áp dụng chương trình khuyến mại')
                            return;
                        }
                        if(res.response.valid == false){
                            toastr.error(`Đơn hàng của bạn không đủ điều kiện để áp dụng voucher này`)
                            return;
                        }
                        if(res.carts){
                            Object.values(res.carts).forEach(cart => {
                                const cartItemElement = document.querySelector(`.cart-item[data-pd="${cart.id}"]`);
                                let discount = 0;
                                if(cart.options.voucher){
                                    discount = cart.options.voucher.discount * cart.qty;
                                }
                                if (cart.options && cart.options.voucher) {
                                    const voucher_discount = cartItemElement.querySelector('.voucher-discount');
                                    const discount = Number(cart.options.voucher.discount) * Number(cart.qty) || 0;
                                
                                    if (voucher_discount) {
                                        voucher_discount.textContent = '-' + new Intl.NumberFormat('vi-VN').format(discount) + '₫';
                                    }
                                }
                                
                                if (cartItemElement) {
                                    const priceElement = cartItemElement.querySelector('.cart-price-sale');
                                    if (priceElement) {
                                        const totalPrice = (Number(cart.price) * Number(cart.qty)) - (Number(discount) || 0);
                                        priceElement.textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + '₫';
                                    }
                                }
                            })
                        }
                        if(res.response.voucher.product_scope == 'TOTAL_ORDERS'){
                            $('.voucher-item').removeClass('use')
                            _this.addClass('use')
                            HT.changeCartTotalAfterApplyVoucher(res)
                        }else if(res.response.voucher.product_scope == 'SHIPPING_ORDERS'){
                            $('.voucher-item').removeClass('use')
                            _this.addClass('use')
                            HT.changeCartTotalAfterApplyVoucher(res)
                        }else if(res.response.voucher.product_scope == 'ALL_PRODUCTS'){
                            $('.voucher-item').removeClass('use')
                            _this.addClass('use')
                            $('.cart-total').html(addCommas(res.response.cartTotal)+'đ')
                            $('.voucher-value').html('-' + addCommas(res.response.voucherDiscount) + 'đ')
                            $('.discount-value').html('-' + addCommas(res.response.cartDiscount) + 'đ')
                        }else if(res.response.voucher.product_scope == 'SPECIFIC_PRODUCTS'){
                            $('.voucher-item').removeClass('use')
                            _this.addClass('use')
                            $('.cart-total').html(addCommas(res.response.cartTotal)+'đ')
                            $('.voucher-value').html('-' + addCommas(res.response.voucherDiscount) + 'đ')
                            $('.discount-value').html('-' + addCommas(res.response.cartDiscount) + 'đ')
                        }
                    }
                },
            });
        })
    }

    HT.changeCartTotalAfterApplyVoucher = (res) =>{
        $('.cart-total').html(addCommas(res.response.cartTotal)+'đ')
        $('.discount-value').html('-' + addCommas(res.response.cartDiscount) + 'đ')
        $('.voucher-value').html('-' + addCommas(res.response.voucher.discount) + 'đ')
        $('.ship-value').html(addCommas(res.response.ship) + 'đ')
        $('.voucher-discount').html('-'+addCommas(0)+'đ')
    }

    HT.unUseVoucher = () =>{
        $(document).on('click','.use', function(){
            let _this = $(this)
            const voucher_id = _this.data('id')
            $.ajax({
                url: 'ajax/cart/unUseVoucher', 
                type: 'GET', 
                data: {
                    voucher_id : voucher_id
                }, 
                dataType: 'json', 
                beforeSend: function() {
                
                },
                success: function(res) {
                    if(res.code == 10){
                        _this.removeClass('use')
                        $('.cart-total').html(addCommas(res.response.cartTotal)+'đ')
                        $('.voucher-value').html('-' + addCommas(0) + 'đ')
                        $('.voucher-discount').html('-' + addCommas(0) + 'đ')
                        if(res.carts){
                            Object.values(res.carts).forEach(cart => {
                                const cartItemElement = document.querySelector(`.cart-item[data-pd="${cart.id}"]`);
                                let discount = 0;
                                if(cart.options.voucher){
                                    discount = cart.options.voucher.discount * cart.qty;
                                }
                                if (cart.options && cart.options.voucher) {
                                    const voucher_discount = cartItemElement.querySelector('.voucher-discount');
                                    const discount = Number(cart.options.voucher.discount) * Number(cart.qty) || 0;
                                
                                    if (voucher_discount) {
                                        voucher_discount.textContent = '-' + new Intl.NumberFormat('vi-VN').format(discount) + '₫';
                                    }
                                }
                                
                                if (cartItemElement) {
                                    const priceElement = cartItemElement.querySelector('.cart-price-sale');
                                    if (priceElement) {
                                        const totalPrice = (Number(cart.price) * Number(cart.qty)) - (Number(discount) || 0);
                                        priceElement.textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + '₫';
                                    }
                                }
                            })
                        }
                    }
                },
            });
        })
    }

    HT.buyNow = () => {
        $(document).on('click', '.order-buy-now', function(e){
            e.preventDefault()
            let _this = $(this)
            let id = _this.attr('data-id')
            let option = {
                id : id,
                _token: _token
            }

            $.ajax({
                    url: 'ajax/cart/pay', 
                    type: 'POST', 
                    data: option, 
                    dataType: 'json', 
                    beforeSend: function() {
                        
                    },
                    success: function(res) {
                        window.location.href = 'thanh-toan.html';
                    },
                });


        })
    }

    $document.ready(function() {
        HT.buyNow()
        HT.unUseVoucher()
        HT.applyVoucher()
        HT.addCart()
        HT.setupSelect2()
        HT.changeQuantity()
        HT.changeQuantityInput()
        HT.removeCartItem()
        HT.addWishlish()
    });

})(jQuery);
addCommas = (nStr) => { 
    nStr = String(nStr);
    nStr = nStr.replace(/\./gi, "");
    let str ='';
    for (let i = nStr.length; i > 0; i -= 3){
        let a = ( (i-3) < 0 ) ? 0 : (i-3);
        str= nStr.slice(a,i) + '.' + str;
    }
    str= str.slice(0,str.length-1);
    return str;
}