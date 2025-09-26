<aside class="select-search">
    <div class="widget">
        <div class="mb-3">
            <h2 class=" text-uppercase h5 mb-0">Tùy chọn tìm kiếm</h2>
        </div>
        <div class="widget-body">
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#content-00" aria-expanded="false" aria-controls="collapseList">
                    Xếp hạng 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                <div class="collapse show" id="content-00">
                    <div class="item-collapse">
                        <div class="filter-price-content">
                            <input type="text" id="priceRange" readonly="" class="uk-hidden">
                            <div id="price-range" class="slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                                <span class="ui-slider-handle ui-state-default ui-corner-all start" tabindex="0" style="left: 0%;"></span>
                                <span class="ui-slider-handle ui-state-default ui-corner-all end" tabindex="0" style="left: 100%;"></span>
                            </div>
                        </div>
                        <div class="filter-input-value mt5">
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-medium-1-2">
                                    <div class="input-wrapper">
                                        <span class="px-2">Min</span>
                                        <input type="text" class="min-value form-control" value="1">
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="input-wrapper">
                                        <span class="px-2">Max</span>
                                        <input type="text" class="max-value form-control" value="1000">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#area" aria-expanded="false" aria-controls="collapseList">
                    Khu vực
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($areas))
                    <div class="collapse show" id="area">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($areas as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->id }}">
                                        <label class="form-check-label" for="{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#city" aria-expanded="false" aria-controls="collapseList">
                    Thành phố
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($cities))
                    <div class="collapse" id="city">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($cities as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->id }}">
                                        <label class="form-check-label" for="{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#scholar" aria-expanded="false" aria-controls="collapseList">
                    Học bổng
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($scholars))
                    <div class="collapse show" id="scholar">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($scholars as $item)
                                    @php
                                        $id = $item->id;
                                        $name = $item->languages->first()->pivot->name;
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $id }}">
                                        <label class="form-check-label" for="{{ $id }}">{{ $name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#school_catalogue" aria-expanded="false" aria-controls="collapseList">
                    Loại hình trường
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($schoolCatalogues))
                    <div class="collapse show" id="school_catalogue">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($schoolCatalogues as $item)
                                    @php
                                        $id = $item->id;
                                        $name = $item->languages->first()->pivot->name;
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $id }}">
                                        <label class="form-check-label" for="{{ $id }}">{{ $name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#project" aria-expanded="false" aria-controls="collapseList">
                    Dự án
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($projects))
                    <div class="collapse show" id="project">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($projects as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $item->id }}">
                                        <label class="form-check-label" for="{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#major_catalogue" aria-expanded="false" aria-controls="collapseList">
                    Ngành
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($majorCatalogues))
                    <div class="collapse show" id="major_catalogue">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($majorCatalogues as $item)
                                    @php
                                        $id = $item->id;
                                        $name = $item->languages->first()->pivot->name;
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $id }}">
                                        <label class="form-check-label" for="{{ $id }}">{{ $name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="group-item-filter">
                <button class="btn btn-white" type="button" data-bs-toggle="collapse" data-bs-target="#major" aria-expanded="false" aria-controls="collapseList">
                    Chuyên ngành
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
                @if(!is_null($majors))
                    <div class="collapse show" id="major">
                        <div class="item-collapse">
                            <div class="form-search-text">
                                <input type="text" placeholder="Search here...">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjkiIGhlaWdodD0iMjkiIHZpZXdCb3g9IjAgMCAyOSAyOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI0MTcgMjAuMjAxNkMxNi43ODk2IDIwLjIwMTYgMjAuNDc2NSAxNi41MTQ3IDIwLjQ3NjUgMTEuOTY2OEMyMC40NzY1IDcuNDE4NzkgMTYuNzg5NiAzLjczMTkzIDEyLjI0MTcgMy43MzE5M0M3LjY5MzY5IDMuNzMxOTMgNC4wMDY4NCA3LjQxODc5IDQuMDA2ODQgMTEuOTY2OEM0LjAwNjg0IDE2LjUxNDcgNy42OTM2OSAyMC4yMDE2IDEyLjI0MTcgMjAuMjAxNloiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNS4xODE4IDI0LjkwNzNMMjAuMDY0NSAxOS43ODk5IiBzdHJva2U9ImJsYWNrIiBzdHJva2Utb3BhY2l0eT0iMC4zIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="search">
                            </div>
                            <div class="group-box-item">
                                @foreach($majors as $item)
                                    @php
                                        $id = $item->id;
                                        $name = $item->languages->first()->pivot->name;
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $id }}">
                                        <label class="form-check-label" for="{{ $id }}">{{ $name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="uk-flex uk-flex-middle gap-2 pt-3">
                <button type="button" class="btn-raised w-100 btn btn-primary">Apply</button>
                <div class="w-100">
                    <button type="button" class="w-100 btn btn-trash">
                        Bộ lọc
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</aside>