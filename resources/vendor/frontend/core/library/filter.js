(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng
	var timer;
    var filter = $('.filtering');
    var filterContainer = $('.filter-content');


    HT.priceRange = () => {
        let isInitialized = false;
		$("#price-range").slider({
			step: 50000,
			range: true, 
			min: 0, 
			max: 10000000, 
			values: [0, 10000000], 
			slide: function(event, ui){
				$('.min-value').val(addCommas(ui.values[0]) + 'đ')
				$('.max-value').val(addCommas(ui.values[1]) + 'đ')
			},
            create: function(event, ui) {
                isInitialized = true;
            },
            change: function(event, ui) {
                if (isInitialized) {
                    HT.sendDataToFilter();
                }
              }
		  });
        $("#priceRange").val($("#price-range")
            .slider("values", 0) + " - " + $("#price-range")
            .slider("values", 1));
    }


    HT.filter = () => {
        $(document).on('change', '.filtering', function(){
            HT.sendDataToFilter()
        })
    }

    HT.filterInput = () => {
        $(document).on('click','.filter-input-value-mobile .input-value', function(e){
            e.preventDefault()
            $('.uk-flex .pagination').hide()
            let _this = $(this)
            let option = HT.filterOptionInput(_this)
            $.ajax({
                url: 'ajax/product/filter', 
                type: 'GET', 
                data: option, 
                dataType: 'json', 
                beforeSend: function() {
                    
                },
                success: function(res) {
                    let html = res.data
                    $('.product-catalogue .product-list').html(html);
                },
            });
        })
    }

    HT.filterOptionInput = (clickedElement) => {
        var filterOption = {
            perpage: $('select[name=perpage]').val(),
            sort: $('select[name=sort]').val(),
            rate: $('input[name="rate[]"]:checked').map(function(){
                return this.value
            }).get(),
            price: {
                price_min : clickedElement.data('from'),
                price_max : clickedElement.data('to')
            },
            sortType : clickedElement.data('sort'),
            productCatalogueId: $('input[name="product_catalogue_id[]"]:checked').val(),
            attributes:  {}
        }

        $('.filterAttribute:checked').each(function(){
            let attributeId = $(this).val()
            let attributeGroup  = $(this).attr('data-group')

            if (!filterOption.attributes.hasOwnProperty(attributeGroup)) {
                filterOption.attributes[attributeGroup] = [];
            }
        
            filterOption.attributes[attributeGroup].push(attributeId);
        })

        return filterOption
    }

    HT.sendDataToFilter = () => {
        let option = HT.filterOption()
        $.ajax({
            url: 'ajax/product/filter', 
            type: 'GET', 
            data: option, 
            dataType: 'json', 
            beforeSend: function() {
                
            },
            success: function(res) {
                let html = res.data
                let countProduct = res.countProduct
                $('.caption strong').html('')
                $('.caption strong').html(`${countProduct} sản phẩm`)
                $('.product-catalogue .product-list').html(html);
            },
        });
    }

    HT.filterOption = () => {
        var filterOption = {
            perpage: $('select[name=perpage]').val(),
            sort: $('select[name=sort]').val(),
            rate: $('input[name="rate[]"]:checked').map(function(){
                return this.value
            }).get(),
            price: {
                price_min : $('.min-value').val(),
                price_max : $('.max-value').val()
            },
            sortType : $(this).data('sort'),
            productCatalogueId: $('.product_catalogue_id').val(),
            attributes:  {}
        }

        $('.filterAttribute:checked').each(function(){
            let attributeId = $(this).val()
            let attributeGroup  = $(this).attr('data-group')

            if (!filterOption.attributes.hasOwnProperty(attributeGroup)) {
                filterOption.attributes[attributeGroup] = [];
            }
        
            filterOption.attributes[attributeGroup].push(attributeId);
        })

        return filterOption
    }

    HT.openFilter = () => {
		$('.filter-button .btn-filter').on('click', function(e){
			
			if(filterContainer.hasClass('filter-minimize')){
				filterContainer.removeClass('filter-minimize')
				filterContainer.addClass('filter-open')
			}else {
				filterContainer.removeClass('filter-open')
				filterContainer.addClass('filter-minimize')
			}
			e.preventDefault()
		})
	}

    HT.closeFilter = () => {
		$('.filter-close').on('click', function(){
			filterContainer.removeClass('filter-open')
			filterContainer.addClass('filter-minimize')
		})
	}

    HT.sortProduct = () => {
        $(document).on('click', '.sort-options .menu-item a', function(e){
            e.preventDefault()
            let _this = $(this)
            let option = HT.filterOptionInput(_this)
            $.ajax({
                url: 'ajax/product/filter', 
                type: 'GET', 
                data: option, 
                dataType: 'json', 
                beforeSend: function() {
                    
                },
                success: function(res) {
                    let html = res.data
                    let countProduct = res.countProduct
                    $('.caption strong').html('')
                    $('.caption strong').html(`${countProduct} sản phẩm`)
                    $('.product-catalogue .product-list').html(html);
                },
            });
        })
    }
    

	$(document).ready(function(){
        HT.sortProduct()
        HT.priceRange()
        HT.filter()
        HT.openFilter()
        HT.closeFilter()
        HT.filterInput()
	});

})(jQuery);

