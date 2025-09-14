(function($) {
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
			loop: true,
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

	HT.category = () => {
		var swiper = new Swiper(".panel-category .swiper-container", {
			loop: true,
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
					slidesPerView: 1.5,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 3,
				},
				1280: {
					slidesPerView: 3,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
		
	}

	HT.service = () => {
		const swiper = new Swiper('.panel-service-1 .swiper-container', {
            centeredSlides: true,
            loop: true,
            speed: 500,
            slidesPerView: 1.5,
            spaceBetween: 120,
            // autoplay: {
            //     delay: 3000,
            // },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
        
                640: {
                    slidesPerView: 2.5,
                },
                768: {
                    slidesPerView: 2.75,
                },
                1080: {
                    slidesPerView: 3.25,
                },
                1280: {
                    slidesPerView: 2.75,
                },
            },
        });
		
	}


	HT.swiperCategory = () => {
		var swiper = new Swiper(".panel-category .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 1.5,
			breakpoints: {
				415: {
					slidesPerView: 1.5,
				},
				500: {
				  slidesPerView: 2.5,
				},
				768: {
				  slidesPerView: 4,
				},
				1280: {
					slidesPerView: 5,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	HT.swiperAsideFeature = () => {
		var swiper = new Swiper(".aside-feature .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 0,
			slidesPerView: 1,
			breakpoints: {
				415: {
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

	HT.swiperBestSeller = () => {
		var swiper = new Swiper(".catalogue-slide .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 2,
			breakpoints: {
				415: {
					slidesPerView: 1,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 3,
				},
				1280: {
					slidesPerView: 4,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	
	HT.wow = () => {
		var wow = new WOW(
			{
			  boxClass:     'wow',      // animated element css class (default is wow)
			  animateClass: 'animated', // animation css class (default is animated)
			  offset:       0,          // distance to the element when triggering the animation (default is 0)
			  mobile:       true,       // trigger animations on mobile devices (default is true)
			  live:         true,       // act on asynchronously loaded content (default is true)
			  callback:     function(box) {
				// the callback is fired every time an animation is started
				// the argument that is passed in is the DOM node being animated
			  },
			  scrollContainer: null,    // optional scroll container selector, otherwise use window,
			  resetAnimation: true,     // reset animation on end (default is true)
			}
		  );
		  wow.init();


	}// arrow function

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


	HT.loadDistribution = () => {
		$(document).on('click', '.agency-item', function(){
			let _this = $(this)

			$('.agency-item').removeClass('active')
			_this.addClass('active')

			$.ajax({
				url: 'ajax/distribution/getMap', 
				type: 'GET', 
				data: {
					id: _this.attr('data-id')
				}, 
				dataType: 'json', 
				success: function(res) {
					$('.agency-map').html(res)
				},
			});

		})
	}

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

    HT.requestConsult = () => {
        $(document).on('click', '#advise button', function(e){
            e.preventDefault()
            let phone =  $('#advise input[name=phone]').val()
            if (!phone || !/^(0[3|5|7|8|9][0-9]{8})$/.test(phone)) {
                alert('Vui lòng nhập số điện thoại hợp lệ (10 chữ số, bắt đầu bằng 0).');
                return;
            }
            toastr.success('Gửi thông tin thành công. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất', 'Thông báo từ hệ thống')
            $.ajax({
				url: 'ajax/contact/requestConsult', 
				type: 'POST', 
				data: {
					'phone' : phone,
                    '_token' : _token
				}, 
				dataType: 'json', 
				success: function(res) {
					if(res.status == true){
                        // toastr.success(res.messages, 'Thông báo từ hệ thống !')
                        $('#advise input[name=phone]').val('')
                    }
				},
			});
        })
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

    HT.updateHeaderColor = (slideIndex) => {
        const updateHeaderBasedOnSlide = (currentSlideIndex) => {
            const $slides = $('.panel-slide .swiper-slide');
            const $header = $('.pc-header');
            
            console.log('Updating header color for slide index:', currentSlideIndex);
            
            const $currentSlide = $slides.eq(currentSlideIndex);
            
            if($currentSlide.length) {
                console.log('Current slide classes:', $currentSlide.attr('class'));
                
                if($currentSlide.hasClass('slide-item-2')) {
                    console.log('Slide 2 active - adding white-text-mode class');
                    
                    // CHỈ CẦN ADD CLASS - CSS SẼ LO PHẦN CÒN LẠI
                    $header.addClass('white-text-mode');
                    
                } else {
                    console.log('Other slide active - removing white-text-mode class');
                    
                    // CHỈ CẦN REMOVE CLASS
                    $header.removeClass('white-text-mode');
                }
            }
        };
        
        if(typeof slideIndex !== 'undefined') {
            updateHeaderBasedOnSlide(slideIndex);
        }
        
        return updateHeaderBasedOnSlide;
    };

    HT.manualSlide = () => {
        if($('.panel-slide').length){
            console.log('Setting up manual slide system...');
            
            let currentSlide = 0;
            let $slides = $('.panel-slide .swiper-slide');
            let totalSlides = $slides.length;
            let $container = $('.panel-slide .swiper-container');
            let $wrapper = $('.panel-slide .swiper-wrapper');
            
            // Initialize header color updater
            const updateHeaderColor = HT.updateHeaderColor();
            
            console.log('Total slides found:', totalSlides);
            
            if(totalSlides <= 1) {
                console.log('Only 1 slide, hiding navigation');
                $('.panel-slide .swiper-button-next, .panel-slide .swiper-button-prev').hide();
                return;
            }
            
            // Reset CSS của wrapper và slides
            $wrapper.css({
                'display': 'block',
                'position': 'relative',
                'width': '100%',
                'height': '100%'
            });
            
            // Thiết lập slides - ẩn tất cả trừ slide đầu
            $slides.each(function(index) {
                $(this).css({
                    'position': 'absolute',
                    'top': '0',
                    'left': '0',
                    'width': '100%',
                    'height': '100%',
                    'opacity': index === 0 ? '1' : '0',
                    'transition': 'opacity 0.5s ease-in-out',
                    'z-index': index === 0 ? '2' : '1'
                });
            });
            
            // Set initial header color for first slide
            updateHeaderColor(0);
            
            // Function để chuyển slide
            const goToSlide = (newIndex) => {
                if(newIndex === currentSlide) return;
                
                console.log('Changing from slide', currentSlide, 'to slide', newIndex);
                
                // Fade out current slide
                $slides.eq(currentSlide).css({
                    'opacity': '0',
                    'z-index': '1'
                });
                
                // Fade in new slide
                $slides.eq(newIndex).css({
                    'opacity': '1',
                    'z-index': '2'
                });
                
                currentSlide = newIndex;
                
                // *** FIX: TRUYỀN newIndex VÀO updateHeaderColor ***
                console.log('Updating header for slide index:', newIndex);
                updateHeaderColor(newIndex);
            };
            
            // Next button click
            $('.panel-slide .swiper-button-next').off('click').on('click', function(e) {
                e.preventDefault();
                console.log('Next button clicked, current slide:', currentSlide);
                let nextSlide = (currentSlide + 1) % totalSlides;
                console.log('Going to next slide:', nextSlide);
                goToSlide(nextSlide);
            });
            
            // Prev button click  
            $('.panel-slide .swiper-button-prev').off('click').on('click', function(e) {
                e.preventDefault();
                console.log('Prev button clicked, current slide:', currentSlide);
                let prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                console.log('Going to prev slide:', prevSlide);
                goToSlide(prevSlide);
            });
            
            // Debug: Log tất cả slides và classes
            console.log('=== DEBUG SLIDES ===');
            $slides.each(function(index) {
                console.log(`Slide ${index}:`, $(this).attr('class'));
            });
            console.log('==================');
            
            // Keyboard navigation
            $(document).on('keydown', function(e) {
                if($('.panel-slide').is(':visible')) {
                    if(e.key === 'ArrowRight') {
                        $('.panel-slide .swiper-button-next').click();
                    } else if(e.key === 'ArrowLeft') {
                        $('.panel-slide .swiper-button-prev').click();
                    }
                }
            });
            
            // Touch/swipe support
            let startX = 0;
            let startY = 0;
            let isTouch = false;
            
            $container.on('touchstart mousedown', function(e) {
                isTouch = true;
                startX = e.type === 'touchstart' ? e.originalEvent.touches[0].clientX : e.clientX;
                startY = e.type === 'touchstart' ? e.originalEvent.touches[0].clientY : e.clientY;
            });
            
            $container.on('touchend mouseup', function(e) {
                if(!isTouch) return;
                
                let endX = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientX : e.clientX;
                let endY = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientY : e.clientY;
                
                let deltaX = endX - startX;
                let deltaY = endY - startY;
                
                // Check if horizontal swipe is stronger than vertical
                if(Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                    if(deltaX > 0) {
                        // Swipe right - previous slide
                        $('.panel-slide .swiper-button-prev').click();
                    } else {
                        // Swipe left - next slide
                        $('.panel-slide .swiper-button-next').click();
                    }
                }
                
                isTouch = false;
            });
            
            console.log('Manual slide system initialized successfully');
        }
    };

    
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

   

    HT.loadProject = () => {
        $(document).on('click', '.project-tab li a', function(e){
            e.preventDefault()
            const _this = $(this)
            const id = _this.attr('data-id')
            $.ajax({
				url: 'ajax/projects', 
				type: 'GET', 
				data: {id: id}, 
				dataType: 'json', 
				beforeSend: function() {
					
				},
				success: function(res) {
                    console.log(res.html);
                    
                    if(res.html.length > 0){
                        $('.panel-project-body').html(res.html)
                    }else{
                        $('.panel-project-body').html('<div class="uk-text-center">Không tìm thấy dữ liệu hợp lệ</div>')
                    }
					
				},
			});

        })
    }

    HT.renderProductFromProductCatalogue = () => {
        $(document).on('click','.filter-category li', function(e){
			e.preventDefault()
			let _this = $(this)
            $('.panel-new-course .btn').hide()
            $('.filter-category li').removeClass('active');
            _this.addClass('active')
            if(_this.hasClass('all')){
                $('.panel-new-course .panel-body').hide()
                $('.panel-new-course .btn').show()
                $('.panel-new-course .all-pd').show()
                return;
            }
            let option = {
                product_catalogue_id : _this.data('product-catalogue-id')
            }
            $.ajax({
                url: 'ajax/dashboard/findProductObject', 
                type: 'GET', 
                data: option,
                dataType: 'json', 
                success: function(res){
                    $('.panel-new-course .panel-body').hide()
                    $('.panel-new-course .uk-container').append(res.html)
                },
                beforeSend: function(){

                },
            });
		})
	}

    HT.techStaff = () => {
        var swiper = new Swiper(".panel-tech-staff .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 25,
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
					slidesPerView: 4,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
    }

    HT.video = () => {
        var swiper = new Swiper(".videos .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 25,
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
					slidesPerView: 1,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
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

    HT.whyChoose = () => {
        var swiper = new Swiper(".panel-why-choose .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 45,
			slidesPerView: 2,
			breakpoints: {
				315: {
					slidesPerView: 1,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView:2,
				},
				1280: {
					slidesPerView: 3
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

    HT.filterCourse = () => {
        
        $('.p-filter').on('change', function(){
            let _this = $(this)
            let productCatalogueId = $('input[name="product_catalogue_id[]"]:checked').map(function() {
                return $(this).val()
            }).get();
            let lectureId = $('input[name="lecture_id[]"]:checked').map(function() {
                return $(this).val()
            }).get();

            const filterOptions = {
                productCatalogueId: productCatalogueId,
                lectureId: lectureId
            }
            
            $.ajax({
				url: 'ajax/product/filter', 
				type: 'GET', 
				data: filterOptions, 
				dataType: 'json', 
				success: function(res) {
                    let html = res.data
                    let countProduct = res.countProduct
                    $('.caption strong').html('')
                    $('.caption strong').html(`${countProduct} sản phẩm`)
                    $('.product-catalogue .product-list').html(html);
                    HT.skeleton()
				},
			});
          
            

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

        

	$(document).ready(function(){
        HT.changeStatusDropdownMenu()
        HT.changeStatusPass()
        HT.changeStatusChildren()
        HT.whyChoose()
        HT.partner()
        HT.video()
        HT.techStaff ()
        HT.renderProductFromProductCatalogue ()
        HT.loadProject();
        HT.popupSwiperSlide();
        HT.highlightTocOnScroll();
        HT.scrollHeading()
        HT.requestConsult()
        HT.scroll()
        HT.advise()
        HT.addVoucher()
		HT.removePagination()
		HT.wow()
		HT.category()
		HT.swiperBestSeller()
		HT.swiperAsideFeature()
		
		/* CORE JS */
        HT.swiper()
		HT.niceSelect()		
		HT.select2()
		HT.loadDistribution()
		HT.wrapTable()
        HT.service()
        HT.skeleton()

        /** ACTION  */
        HT.register()
        HT.previewVideo()
        HT.filterCourse()

        // $(window).on('load', function() {
        //     HT.swiper();
        // });
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