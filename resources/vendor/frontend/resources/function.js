
"use strict";
var HT = {}; // Khai báo là 1 đối tượng
var timer;
var $carousel = $(".owl-slide");
var _token = $('meta[name="csrf-token"]').attr('content');

HT.swiperOption = (setting) => {
    // console.log(setting);
    let option = {}
    if(setting.animation.length){
        option.effect = setting.animation;
    }	
    if(setting.arrow === 'accept'){
        option.navigation = {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    }
    if(setting.autoplay === 'accept'){
        option.autoplay = {
            delay: 50000,
            disableOnInteraction: false,
        }
    }
    if(setting.navigate === 'dots'){
        option.pagination = {
            el: '.swiper-pagination',
        }
    }
    return option
}

/* MAIN VARIABLE */
HT.swiper = () => {
    var swiper = new Swiper(".panel-slide .swiper-container", {
        loop: false,
        pagination: {
            el: '.swiper-pagination',
        },
        autoplay: {
            delay : 3000,
        },
        spaceBetween: 15,
        slidesPerView: 1.5,
        breakpoints: {
            100: {
                slidesPerView: 1,
            },
            500: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            1280: {
                slidesPerView: 1,
            }
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
    });
}

HT.major = () => {
    var swiper = new Swiper(".panel-major .swiper-container", {
        loop: false,
        pagination: {
            el: '.swiper-pagination',
        },
        autoplay: {
            delay : 2000,
        },
        spaceBetween: 15,
        slidesPerView: 1.5,
        breakpoints: {
            415: {
                slidesPerView: 1,
            },
            500: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1280: {
                slidesPerView: 2.5,
            }
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
    });
    
}


// HT.wow = () => {
// 	var wow = new WOW(
// 		{
// 		  boxClass:     'wow',      // animated element css class (default is wow)
// 		  animateClass: 'animated', // animation css class (default is animated)
// 		  offset:       0,          // distance to the element when triggering the animation (default is 0)
// 		  mobile:       true,       // trigger animations on mobile devices (default is true)
// 		  live:         true,       // act on asynchronously loaded content (default is true)
// 		  callback:     function(box) {
// 			// the callback is fired every time an animation is started
// 			// the argument that is passed in is the DOM node being animated
// 		  },
// 		  scrollContainer: null,    // optional scroll container selector, otherwise use window,
// 		  resetAnimation: true,     // reset animation on end (default is true)
// 		}
// 	  );
// 	  wow.init();


// }// arrow function

HT.niceSelect = () => {
    if($('.nice-select').length){
        $('.nice-select').niceSelect();
    }
    
}

HT.select2 = () => {
    if($('.setupSelect2').length){
        $('.setupSelect2').select2();
    }
    
}


// HT.loadDistribution = () => {
// 	$(document).on('click', '.agency-item', function(){
// 		let _this = $(this)

// 		$('.agency-item').removeClass('active')
// 		_this.addClass('active')

// 		$.ajax({
// 			url: 'ajax/distribution/getMap', 
// 			type: 'GET', 
// 			data: {
// 				id: _this.attr('data-id')
// 			}, 
// 			dataType: 'json', 
// 			success: function(res) {
// 				$('.agency-map').html(res)
// 			},
// 		});

// 	})
// }

HT.skeleton = () => {
    
    document.addEventListener("DOMContentLoaded", function() {
        // Lựa chọn tất cả các ảnh cần lazy load
        const lazyImages = document.querySelectorAll('.lazy-image');
        
        // Tạo Intersection Observer
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                // Khi phần tử trở nên visible
                if (entry.isIntersecting) {
                    const img = entry.target;
                    // Lấy nguồn ảnh từ thuộc tính data-src
                    const src = img.dataset.src;
                    
                    // Tạo ảnh mới và thiết lập trình xử lý sự kiện onload
                    const newImg = new Image();
                    newImg.onload = function() {
                        // Khi ảnh đã tải xong, gán src và thêm class loaded
                        img.src = src;
                        img.classList.add('loaded');
                        
                        // Ẩn skeleton loading
                        const parent = img.closest('.image');
                        if (parent) {
                            const skeleton = parent.querySelector('.skeleton-loading');
                            if (skeleton) {
                                skeleton.style.display = 'none';
                            }
                        }
                        
                        // Ngừng quan sát phần tử này
                        observer.unobserve(img);
                    };
                    
                    // Bắt đầu tải ảnh
                    newImg.src = src;
                }
            });
        }, {
            // Tùy chọn: thiết lập ngưỡng và root
            rootMargin: '0px 0px 50px 0px', // Tải trước ảnh khi chúng cách 50px từ viewport
            threshold: 0.1 // Kích hoạt khi ít nhất 10% của ảnh trở nên visible
        });
        
        // Quan sát mỗi ảnh
        lazyImages.forEach(img => {
            observer.observe(img);
        });
    });
}


HT.removePagination = () => {
    $('.filter-content').on('slide', function() {
        $('.uk-flex .pagination').hide();
    });
};


HT.wrapTable = () => {
    var width = $(window).width()
    if(width < 600){
        $('table').wrap('<div class="uk-overflow-container"></div>')
    }
}

HT.addVoucher = () => {
    $(document).on('click','.info-voucher', function(e){
        e.preventDefault()
        let _this = $(this)
        _this.toggleClass('active');
    })
}

HT.advise = () => {
    $(document).on('click','.suggest-aj button', function(e){
        e.preventDefault()
        let _this = $(this)
        let option  = {
            name : $('#suggest input[name=name]').val(),
            gender : $('#suggest input[name=gender]').val(),
            phone : $('#suggest input[name=phone]').val(),
            address: $('#suggest input[name=address]').val(),
            post_id : $('#suggest input[name=post_id ]').val(),
            product_id : $('#suggest input[name=product_id ]').val(),
            _token: _token,
        }
        toastr.success('Gửi yêu cầu thành công , chúng tôi sẽ sớm liên hệ vs bạn !', 'Thông báo từ hệ thống')
        $.ajax({
            url: 'ajax/contact/advise', 
            type: 'POST', 
            data: option, 
            dataType: 'json', 
            beforeSend: function() {
                
            },
            success: function(res) {
                console.log(res)
                if(res.code === 10){
                    
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else if(res.status === 422){
                    let errors = res.messages;
                    for(let field in errors){
                        let errorMessage = errors[field];
                        $('.'+ field + '-error').text(errorMessage);
                    }
                }
            },
        });
        
    })
}

HT.scroll = () => {
    $(document).ready(function() {
        $('a[href="#panel-contact"]').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $('#panel-contact').offset().top - 50
            }, 800); 
        });
    });
}



HT.scrollHeading = () => {
    $(document).on('click', '.widget-toc a', function(e) {
        e.preventDefault(); // Ngăn hành vi mặc định của thẻ a
        
        let _this = $(this);
        let href = _this.attr('href'); // Lấy giá trị href
        
        // Kiểm tra nếu href bắt đầu bằng #
        if (href && href.startsWith('#')) {
            let targetId = href.substring(1); // Loại bỏ dấu # đầu tiên
            
            // Sử dụng document.getElementById thay vì jQuery selector để tránh lỗi
            let targetElement = document.getElementById(targetId);
            
            // Kiểm tra xem element có tồn tại không
            if (targetElement) {
                // Chuyển về jQuery object để sử dụng offset()
                let $targetElement = $(targetElement);
                
                // Cuộn mượt đến element
                $('html, body').animate({
                    scrollTop: $targetElement.offset().top - 100 // Trừ 100px để tạo khoảng cách
                }, 800); // 800ms cho hiệu ứng cuộn mượt
                
                // Thêm class active cho liên kết được click
                $('.widget-toc a').removeClass('active');
                _this.addClass('active');
            } else {
                console.log('Không tìm thấy element với ID:', targetId);
            }
        }
    });
}


HT.highlightTocOnScroll = () => {
    $(window).on('scroll', function() {
        let scrollTop = $(window).scrollTop();
        
        $('.widget-toc a').each(function() {
            let href = $(this).attr('href');
            if (href && href.startsWith('#')) {
                let targetId = href.substring(1);
                let targetElement = document.getElementById(targetId); // Sử dụng getElementById
                
                if (targetElement) {
                    let $targetElement = $(targetElement);
                    let elementTop = $targetElement.offset().top - 150;
                    let elementBottom = elementTop + $targetElement.outerHeight();
                    
                    if (scrollTop >= elementTop && scrollTop < elementBottom) {
                        $('.widget-toc a').removeClass('active');
                        $(this).addClass('active');
                    }
                }
            }
        });
    });
}



HT.popupSwiperSlide = () => {
    document.querySelectorAll(".popup-gallery").forEach(popup => {
        var swiper = new Swiper(popup.querySelector(".swiper-container"), {
            loop: true,
            // autoplay: {
            // 	delay: 2000,
            // 	disableOnInteraction: false,
            // },
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: {
                    el: popup.querySelector('.swiper-container-thumbs'),
                    slidesPerView: 4,
                    spaceBetween: 10,
                    slideToClickedSlide: true,
                }
            }
        });
    });
}





HT.partner = () => {
    var swiper = new Swiper(".panel-partner .swiper-container", {
        loop: false,
        pagination: {
            el: '.swiper-pagination',
        },
        spaceBetween: 30,
        slidesPerView: 2,
        breakpoints: {
            315: {
                slidesPerView: 1,
            },
            500: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1280: {
                slidesPerView: 6,
            }
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
    });
}



HT.register = () => {
    $('.register-form').on('submit', function(e){
        e.preventDefault()
        let _this = $(this)
        let option = {
            'email' : $('#reg_email').val(),
            'name' : $('#reg_name').val(),
            'phone' : $('#reg_phone').val(),
            'message' : $('#reg_message').val() + "<br>" + `Khóa học quan tâm: ${$('#reg_product_name').val()}`,
            '_token' : _token
        }

        $.ajax({
            url: 'ajax/contact/saveContact', 
            type: 'POST', 
            data: option,
            dataType: 'json', 
            beforeSend: function() {
                // console.log(1234);
                _this.find('.register-btn').html('Đang gửi dữ liệu...').attr('disabled', true)
                // return false
                
            },
            success: function(res) {
                let inputValue = ((option.value == 1)?2:1)
                if(res.flag == true){
                    _this.val(inputValue)
                }
                _this.find('.register-btn').html('Đăng ký ngay').removeAttr('disabled')
                alert('Gửi thông tin liên hệ thành công. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất')
                _this[0].reset()
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
                console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
            }
        });
        
    })
}

HT.previewVideo = () => {
    $('.preview-video').on('click', function(e){
        e.preventDefault()
        let _this = $(this)
        let video = JSON.parse(_this.attr('data-video'))
        
        // Parse iframe và thêm autoplay
        let $iframe = $(video)
        let src = $iframe.attr('src')
        
        if (src) {
            // Thêm autoplay parameter
            let separator = src.includes('?') ? '&' : '?'
            let newSrc = src + separator + 'autoplay=1'
            
            // Có thể thêm thêm parameters khác
            newSrc += '&mute=1' // Mute để tránh browser block autoplay
            
            $iframe.attr('src', newSrc)
        }
        
        $('.video-feature').html($iframe[0].outerHTML)
    })
}



HT.changeStatusChildren = () => {
    $(document).on('click', '.toggle', function () {
        let $item = $(this).closest('.filter-list__item'); 
        let $children = $item.find('.children').first(); 
        if ($children.hasClass('active')) {
            $(this).removeClass('rotate');
            $children.removeClass('active');
        } else {
            $(this).addClass('rotate');
            $children.addClass('active');
        }
    });
}

HT.changeStatusPass = () => {
    $(document).on('click', '.password-toggle', function(e) {
        e.preventDefault();
        const $passwordInput = $(this).siblings('input[type="password"], input[type="text"]');
        const currentType = $passwordInput.attr('type');
        const inputId = $passwordInput.attr('id');
        if (currentType === 'password') {
            $passwordInput.attr('type', 'text');
            $(`#eye-${inputId}`).hide();
            $(`#eye-slash-${inputId}`).show();
        } else {
            $passwordInput.attr('type', 'password');
            $(`#eye-${inputId}`).show();
            $(`#eye-slash-${inputId}`).hide();
        }
    });
}

HT.changeStatusDropdownMenu = () => {
    $(document).on('click', '.browse-tools .dropdown', function() {
        let _this = $(this)
        _this.toggleClass('active')
        if(_this.hasClass('active')){
            _this.closest('.browse-tools').find('.dropdown-menu').addClass('open')
        }else{
            _this.closest('.browse-tools').find('.dropdown-menu').removeClass('open')
        }
    });
}

HT.collapse = () => {{
    $(document).on('click', '[data-bs-toggle="collapse"]', function() {
        let target = $($(this).data('bs-target'));
        target.hasClass('show') ? target.removeClass('show') : target.addClass('show');
    });
}}


HT.regForm = () => {
    $(document).on('submit', '.reg-form', function(e){
        e.preventDefault()
        e.stopPropagation()
        let $form = $(this);
        let formData = {
            name: $form.find('input[placeholder="Họ Tên *"]').val().trim(),
            email: $form.find('input[placeholder="Email *"]').val().trim(),
            phone: $form.find('input[placeholder="Số điện thoại *"]').val().trim(),
            scholarshipType: $form.find('#schoolarshipType').val(),
            address: $form.find('input[placeholder="Địa chỉ *"]').val().trim(),
            _token: $('meta[name="csrf-token"]').attr('content') // nhớ có csrf ở <head>
        };

        // validate
        let errors = [];
        if(!formData.name) errors.push("Vui lòng nhập họ tên");
        if(!formData.email || !/^\S+@\S+\.\S+$/.test(formData.email)) errors.push("Email không hợp lệ");
        if(!formData.phone || !/^(0[0-9]{9})$/.test(formData.phone)) errors.push("Số điện thoại không hợp lệ");
        if(!formData.address) errors.push("Vui lòng nhập địa chỉ");

        if(errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }

        // submit ajax
        $.ajax({
            url: "ajax/contact/saveContact",  // route xử lý ở backend
            type: "POST",
            data: formData,
            beforeSend: function(){
                $form.find('button[type="submit"]').prop('disabled', true).text('Đang gửi...');
            },
            success: function(res){
                if(res.success){
                    alert("Đăng ký thành công!");
                    $form.trigger('reset'); // reset form
                } else {
                    alert(res.message || "Có lỗi xảy ra, vui lòng thử lại.");
                }
            },
            error: function(xhr){
                console.error(xhr.responseText);
                try {
                    let errObj = JSON.parse(xhr.responseText);
                    if (errObj.errors) {
                        let valErrors = [];
                        for (let key in errObj.errors) {
                            valErrors.push(errObj.errors[key][0]);
                        }
                        alert(valErrors.join("\n"));
                        return;
                    }
                } catch(e) {}
                alert("Hệ thống lỗi, vui lòng thử lại sau.");
            },
            complete: function(){
                $form.find('button[type="submit"]').prop('disabled', false).text('Đăng Ký Ngay');
            }
        });

    })
    
}

HT.searchFilterItem = () => {
    let debounceTimer = null;

    $(document).on('keyup', '.form-item-search', function(){
        let $input = $(this);
        let $wrapper = $input.closest('.uk-accordion-content');

        clearTimeout(debounceTimer); 
        debounceTimer = setTimeout(() => {
            let keyword = $input.val().toLowerCase().trim();

            $wrapper.find('.filter-item').each(function(){
                let text = $(this).find('label').text().toLowerCase();
                if (text.indexOf(keyword) > -1) {
                    console.log(123);
                    
                    $(this).show();
                } else {
                    console.log(234);
                    
                    $(this).hide();
                }
            });
        }, 300); 
    });
}

HT.scholarFilter = () => {
    if($('.scholar-catalogue-page').length){
        $(document).on('change', '.filter-value, .scholar-keyword', function () {
            HT.loadScholarFilter()
        })

        // sự kiện khi click phân trang
        $(document).on('click', '.model-paginate a', function (e) {
            e.preventDefault()
            let url = $(this).attr('href')
            HT.loadScholarFilter()
        })
    }
    
}

HT.loadScholarFilter = (url) => {
    let params = {}

    // gom tất cả filter đang check
    $('.filter-value:checked').each(function () {
        let name = $(this).attr('name').replace('[]','')
        if (!params[name]) params[name] = []
        params[name].push($(this).val())
    })

    // gom keyword
    let keyword = $('.scholar-keyword').val()
    if (keyword) {
        params['keyword'] = keyword
    }

    $.ajax({
        url: '/ajax/scholar/filter', // hoặc route filter
        type: 'GET',
        data: params,
        beforeSend: function() {
            $('.filter-result-list').addClass('loading');
        },
        success: function(res) {
            // render lại danh sách
            $('.filter-result-list').html(res.html);
            $('.filter-count').text(res.count)  
        },
        complete: function() {
            $('.filter-result-list').removeClass('loading');
        }
    });
}

HT.admissionFilter = () => {
    if($('.admission-catalogue-page').length){
        $(document).on('change', '.filter-value, .admission-keyword, input[name=min_year], input[name=max_year]', function () {
            HT.loadAdmissionFilter()
        })

        // sự kiện khi click phân trang
        $(document).on('click', '.model-paginate a', function (e) {
            e.preventDefault()
            let url = $(this).attr('href')
            HT.loadAdmissionFilter()
        })
    }
    
}

HT.loadAdmissionFilter = (url) => {
    let params = {}

    // gom tất cả filter đang check
    $('.filter-value:checked').each(function () {
        let name = $(this).attr('name').replace('[]','')
        if (!params[name]) params[name] = []
        params[name].push($(this).val())
    })

    // gom keyword
    let keyword = $('.scholar-keyword').val()
    if (keyword) {
        params['keyword'] = keyword
    }

    params['min_year'] = $('input[name=min_year]').val()
    params['max_year'] = $('input[name=max_year]').val()


    $.ajax({
        url: '/ajax/admission/filter', // hoặc route filter
        type: 'GET',
        data: params,
        beforeSend: function() {
            $('.filter-result-list').addClass('loading');
        },
        success: function(res) {
            // render lại danh sách
            $('.filter-result-list').html(res.html);
            $('.filter-count').text(res.count)  
            $('html, body').animate({
                scrollTop: $('.filter-result-list').offset().top
            }, 500)
        },
        complete: function() {
            $('.filter-result-list').removeClass('loading');
        }
    });
}


HT.schoolFilter = () => {
    if($('.school-catalogue-page').length){
        $(document).on('change', '.filter-value, .school-keyword', function () {
            HT.loadSchoolFilter()
        })

        // sự kiện khi click phân trang
        $(document).on('click', '.model-paginate a', function (e) {
            e.preventDefault()
            let url = $(this).attr('href')
            HT.loadSchoolFilter()
        })
    }
    
}

HT.loadSchoolFilter = (url) => {
    let params = {}

    // gom tất cả filter đang check
    $('.filter-value:checked').each(function () {
        let name = $(this).attr('name').replace('[]','')
        if (!params[name]) params[name] = []
        params[name].push($(this).val())
    })

    // gom keyword
    let keyword = $('.scholar-keyword').val()
    if (keyword) {
        params['keyword'] = keyword
    }

    $.ajax({
        url: '/ajax/school/filter', // hoặc route filter
        type: 'GET',
        data: params,
        beforeSend: function() {
            $('.filter-result-list').addClass('loading');
        },
        success: function(res) {
            // render lại danh sách
            $('.filter-result-list').html(res.html);
            $('.filter-count').text(res.count)  
            $('html, body').animate({
                scrollTop: $('.filter-result-list').offset().top
            }, 500)
        },
        complete: function() {
            $('.filter-result-list').removeClass('loading');
        }
    });
}


HT.regScholarForm = () => {
    $(document).on('submit', '.scholar-form', function(e){
        e.preventDefault()
        e.stopPropagation()
        let $form = $(this);
        let formData = {
            name: $form.find('.name').val().trim(),
            email: $form.find('.email').val().trim(),
            phone: $form.find('.phone').val().trim(),
            destination_area: $form.find('.destination_area').val(),
            apply_for: $form.find('.apply_for').val().trim(),
            _token: $('meta[name="csrf-token"]').attr('content') // nhớ có csrf ở <head>
        };


        // validate
        let errors = [];
        if(!formData.name) errors.push("Vui lòng nhập họ tên");
        if(!formData.email || !/^\S+@\S+\.\S+$/.test(formData.email)) errors.push("Email không hợp lệ");
        if(!formData.phone || !/^(0[0-9]{9})$/.test(formData.phone)) errors.push("Số điện thoại không hợp lệ");
        if(!formData.destination_area) errors.push("Vui lòng nhập khu vực du học mong muốn");
        if(!formData.apply_for) errors.push("Vui lòng nhập loại học bổng muốn đăng ký");

        if(errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }

        // submit ajax
        $.ajax({
            url: "ajax/contact/saveScholarShip",  // route xử lý ở backend
            type: "POST",
            data: formData,
            beforeSend: function(){
                $form.find('button[type="submit"]').prop('disabled', true).text('Đang gửi...');
            },
            success: function(res){
                if(res.success){
                    alert("Đăng ký thành công!");
                    $form.trigger('reset'); // reset form
                } else {
                    alert(res.message || "Có lỗi xảy ra, vui lòng thử lại.");
                }
            },
            error: function(xhr){
                console.error(xhr.responseText);
                try {
                    let errObj = JSON.parse(xhr.responseText);
                    if (errObj.errors) {
                        let valErrors = [];
                        for (let key in errObj.errors) {
                            valErrors.push(errObj.errors[key][0]);
                        }
                        alert(valErrors.join("\n"));
                        return;
                    }
                } catch(e) {}
                alert("Hệ thống lỗi, vui lòng thử lại sau.");
            },
            complete: function(){
                $form.find('button[type="submit"]').prop('disabled', false).text('Đăng ký tư vấn');
            }
        });

    })
    
}

HT.scrollToForm = () => {
    $('.slide-button .uk-button').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#panel-form').offset().top
        }, 800); // thời gian scroll: 800ms
    });
}

HT.showFilter = () => {
    $('.filter-box .filter-content-item .uk-accordion-title').on('click', function(){
        let _this = $(this);
        _this.siblings('.uk-accordion-content').find('.collapse-filter').toggleClass('mobile-active');
    });
   
}



HT.majorFilter = () => {
    if($('.major-catalogue-page').length){
        $(document).on('change', '.filter-value, .major-keyword', function () {
            HT.loadmajorFilter()
        })

        // sự kiện khi click phân trang
        $(document).on('click', '.model-paginate a', function (e) {
            e.preventDefault()
            let url = $(this).attr('href')
            HT.loadmajorFilter()
        })
    }
    
}

HT.loadmajorFilter = (url) => {
    let params = {}

    // gom tất cả filter đang check
    $('.filter-value:checked').each(function () {
        let name = $(this).attr('name').replace('[]','')
        if (!params[name]) params[name] = []
        params[name].push($(this).val())
    })

    // gom keyword
    let keyword = $('.major-keyword').val()
    if (keyword) {
        params['keyword'] = keyword
    }

    $.ajax({
        url: '/ajax/major/filter', // hoặc route filter
        type: 'GET',
        data: params,
        beforeSend: function() {
            $('.filter-result-list').addClass('loading');
        },
        success: function(res) {
            // render lại danh sách
            $('.filter-result-list').html(res.html);
            $('.filter-count').text(res.count)  
            $('html, body').animate({
                scrollTop: $('.filter-result-list').offset().top
            }, 500)
        },
        complete: function() {
            $('.filter-result-list').removeClass('loading');
        }
    });
}

HT.findSchoolList = () => {
    $(document).on('click', '.choose-school', function(){
        const _this = $(this)
        let index = _this.attr('data-row')
        $('#school-index').val(index)
    })
}

HT.chooseSchoolToCompare = () => {
    $(document).on('click', '.compare-school-item', function(){
        const _this = $(this)
        const index = parseInt($('#school-index').val(), 10) // ép kiểu về số nguyên
        const schoolData = JSON.parse(_this.attr('data-json'))
        const info = schoolData.information || {}

        const name =  schoolData.languages[0].pivot.name;
        const logo = schoolData.logo || '/images/no-logo.png';
        const col = $(`.choose-school[data-row="${index}"]`).closest('.sst-col');

        col.html(`
        <div class="text-center my-2">
            <img src="${logo}" width="48" height="48" alt="${name}">
            <div class="mt-2 fw-medium">${name}</div>
            <button type="button" class="p-2 btnRevUni btn btn-light" data-row="${index}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="1.5"></path>
                </svg>
            </button>
        </div>
        `);

        // Test: đổ giá trị Mã trường
        updateValue("Mã trường", schoolData.code)
        updateValue("Năm thành lập", info.founded_year)
        updateValue("Loại hình trường", schoolData.school_catalogues[0].languages[0].pivot.name)
        const projects = (schoolData.school_projects || []).map(p => p.name).join(', ')
        updateValue("Dự án", projects)
        updateValue("Trực thuộc trung ương", info.direct_center)
        updateValue("Khu Vực", schoolData.school_areas.name)
        updateValue("Thành phố", info.city)
        updateValue("Thành phố", info.city)
        updateValue("Cấp thành phố", info.city_level)
        updateValue("Cấp tỉnh", info.tinh_level)
        updateValue("Đặc khu kinh tế", info.special_economic_zone)
        updateValue("Xếp hạng quốc gia", info.national_rank)
        updateValue("Xếp hạng thế giới", info.world_rank)
        updateValue("Diện tích (m2)", info.acreage)
        updateValue("Cơ sở trường", info.campuses)
        updateValue("Số nhà ăn", 'N/A')
        updateValue("Sân tập thể dục", 'Không có')
        updateValue("Phòng thí nghiệm", info.labs_count)
        updateValue("Sách thư viện", info.library_books)
        updateValue("Số giảng viên", info.faculty_count)
        updateValue("Tổng sinh viên", info.total_students)
        updateValue("Sinh viên đại học", info.sinh_vien_dai_hoc)
        updateValue("Nghiên cứu sinh", info.nghien_cuu_sinh)
        updateValue("Sinh viên quốc tế", info.international_students)
        updateValue("Số chuyên ngành đại học", info.programs_count)
        updateValue("Chuyên ngành thạc sĩ", info.master_programs)
        updateValue("Chuyên ngành tiến sĩ", info.phd_programs)
        updateValue("Ngành trọng điểm quốc gia", info.key_subjects)
        updateValue("Số lượng học bổng", schoolData.school_scholars.length)
        const scholars = (schoolData.school_scholars || [])
        const scholarChinhPhu = scholars
        .filter(s => s.scholar_catalogue_id == 16)
        .map(s => s.languages?.[0]?.pivot?.name)
        .filter(Boolean)
        .join(', ')

        updateValue("Học bổng chính phủ", scholarChinhPhu || '—')

        const scholarKhongTu = scholars
        .filter(s => s.scholar_catalogue_id == 15)
        .map(s => s.languages?.[0]?.pivot?.name)
        .filter(Boolean)
        .join(', ')
        updateValue("Học bổng khổng tử", scholarKhongTu || '—')

        const scholarTinh = scholars
        .filter(s => s.scholar_catalogue_id == 14)
        .map(s => s.languages?.[0]?.pivot?.name)
        .filter(Boolean)
        .join(', ')
        updateValue("Học bổng Tỉnh", scholarTinh || '—')

        const scholarThanhPho = scholars
        .filter(s => s.scholar_catalogue_id == 13)
        .map(s => s.languages?.[0]?.pivot?.name)
        .filter(Boolean)
        .join(', ')
        updateValue("Học bổng Thành phố", scholarThanhPho || '—')

        const scholarTruong = scholars
        .filter(s => s.scholar_catalogue_id == 11)
        .map(s => s.languages?.[0]?.pivot?.name)
        .filter(Boolean)
        .join(', ')
        updateValue("Học bổng Trường", scholarTruong || '—')
        updateValue("Học phí 1 năm tiếng", info.language_fee)
        updateValue("Học phí hệ Đại học (Tệ/năm)", info.bachelor_fee)
        updateValue("Học phí hệ Thạc sĩ (Tệ/năm)", info.master_fee)
        updateValue("Học phí hệ Tiến sĩ (Tệ/năm)", info.phd_fee)
        updateValue("Sinhhoạt phí (Tệ/tháng)", info.living_fee)
        updateValue("Phí ký túc xá (Tệ/tháng)", info.dormitory_fee)


        function updateValue(labelText, value){
            if (!labelText) return

            const safeLabel = labelText.replace(/(["'\\])/g, '\\$1') // tránh lỗi ký tự đặc biệt
            const selector = `.sst-row:has(.label:contains("${safeLabel}")) .sst-col:nth-child(${index + 1})`
            
            // console.log('Selector:', selector, '| Value:', value)
            $(selector).html(value || "—")
        }
    })
}


HT.resetCompareCol = () => {
    $(document).on('click', '.btnRevUni', function(){
        const _this = $(this)
        const index = parseInt($(this).attr('data-row'), 10);
        const col = _this.closest('.sst-col')

        // Xoá nội dung cũ và render lại nút "+"
        col.html(`
            <button 
                data-row="${index}" 
                type="button" 
                class="p-2 btn-raised btn btn-primary uk-button choose-school" 
                data-uk-modal="{target:'#school-list'}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4.5v15m7.5-7.5h-15"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke="currentColor"
                        stroke-width="1.5"></path>
                </svg>
            </button>
        `)

        // 2️⃣ Xoá toàn bộ dữ liệu trong cột tương ứng (trừ label)
        $('.sst-row').each(function (rowIndex) {
            if (rowIndex === 0) return; // ❌ bỏ qua hàng đầu tiên

            const colToClear = $(this).find(`.sst-col:nth-child(${index + 1})`);
            if (!colToClear.hasClass('label')) {
                colToClear.html('');
            }
        });

        console.log(`✅ Đã reset xong cột thứ ${index}`);
    })
}

$(document).ready(function(){
    HT.resetCompareCol()
    HT.chooseSchoolToCompare();
    HT.findSchoolList()
    HT.showFilter()
    HT.scrollToForm()
    HT.schoolFilter()
    HT.regScholarForm()
    HT.searchFilterItem()
    HT.scholarFilter()
    HT.majorFilter()

    HT.admissionFilter()

    HT.collapse()
    HT.changeStatusDropdownMenu()
    HT.changeStatusPass()
    HT.changeStatusChildren()

    HT.regForm()
    // HT.whyChoose()
    
    // HT.video()
    // HT.techStaff ()
    // HT.renderProductFromProductCatalogue ()
    // HT.loadProject();
    // HT.popupSwiperSlide();
    HT.highlightTocOnScroll();
    HT.scrollHeading()
    // HT.requestConsult()
    HT.scroll()
    // HT.advise()
    HT.addVoucher()
    HT.removePagination()
    // HT.wow()
    // HT.category()
    // HT.swiperBestSeller()
    // HT.swiperAsideFeature()
    
    /* CORE JS */
    HT.swiper()
    HT.niceSelect()		
    HT.select2()
    // HT.loadDistribution()
    HT.wrapTable()
    // HT.service()
    HT.skeleton()

    /** ACTION  */
    HT.register()
    HT.previewVideo()
    // HT.filterCourse()


    /** SLIDES */

    HT.major()
    HT.partner()

    // $(window).on('load', function() {
    //     HT.swiper();
    // });
});



const addCommas = (nStr) => { 
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

// document.addEventListener("DOMContentLoaded", function() {
//     // Lựa chọn tất cả các ảnh cần lazy load
//     const lazyImages = document.querySelectorAll('.lazy-image');

//     // Tạo Intersection Observer
//     const observer = new IntersectionObserver((entries, observer) => {
//         entries.forEach(entry => {
//             // Khi phần tử trở nên visible
//             if (entry.isIntersecting) {
//                 const img = entry.target;
//                 // Lấy nguồn ảnh từ thuộc tính data-src
//                 const src = img.dataset.src;
            
//                 // Tạo ảnh mới và thiết lập trình xử lý sự kiện onload
//                 const newImg = new Image();
//                 newImg.onload = function() {
//                     // Khi ảnh đã tải xong, gán src và thêm class loaded
//                     img.src = src;
//                     img.classList.add('loaded');
                
//                     // Ẩn skeleton loading
//                     const parent = img.closest('.image');
//                     if (parent) {
//                         const skeleton = parent.querySelector('.skeleton-loading');
//                         if (skeleton) {
//                             skeleton.style.display = 'none';
//                         }
//                     }
                
//                     // Ngừng quan sát phần tử này
//                     observer.unobserve(img);
//                 };
            
//                 // Bắt đầu tải ảnh
//                 newImg.src = src;
//             }
//         });
//     }, {
//         // Tùy chọn: thiết lập ngưỡng và root
//         rootMargin: '0px 0px 50px 0px', // Tải trước ảnh khi chúng cách 50px từ viewport
//         threshold: 0.1 // Kích hoạt khi ít nhất 10% của ảnh trở nên visible
//     });

//     // Quan sát mỗi ảnh
//     lazyImages.forEach(img => {
//         observer.observe(img);
//     });
// });