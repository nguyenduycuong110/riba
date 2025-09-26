<div class="bg-filter">
    <div class="filter-form">
        <h2 class="h5">Tra cứu Trường</h2>
        <form action="" class="uk-flex">
            <div class="rel-icon me-2">
                <input 
                    class="form-control" 
                    type="text" 
                    placeholder="Tìm kiếm..." 
                    id="searchInput" 
                    name="searchInput" 
                    value=""
                >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </div>
            <div class="rel-icon me-2">
                <select class="form-select no-background" id="sortBy" name="sortBy">
                    <option value="rank"> Xếp hạng</option>
                    <option value="view"> Lượt xem</option>
                    <option value="like"> Lượt thích</option>
                    <option value="favorite"> Lượt quan tâm</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                    <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                </svg>  
            </div>
            <button class="btn-blue" type="submit">Tìm trường</button>
        </form>
        <p class="result-p">Chúng tôi tìm thấy {{ $schools->count() }} kết quả cho bộ lọc của bạn.</p>
    </div>
</div>