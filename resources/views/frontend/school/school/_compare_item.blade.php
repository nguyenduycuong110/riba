{{--
    Mot muc truong trong popup "Them truong vao so sanh".

    Dung chung cho ca lan tai trang dau tien va ket qua tim kiem tra ve bang
    ajax, de hai ben khong bao gio lech markup. Doi cau truc o day la ca hai noi
    cung doi.

    data-json phai chua day du quan he ma JS doc khi do du lieu so sanh
    (information, school_catalogues.languages, school_projects, school_areas,
    school_scholars.languages, languages) - thieu quan he nao thi dong tuong ung
    trong bang so sanh se trong.
--}}
@if(!is_null($schools) && $schools->count() > 0)
    @foreach($schools as $school)
        @php
            $name = optional(optional($school->languages->first())->pivot)->name;
            $image = $school->logo;
            $code = $school->code;
        @endphp
        <div class="compare-school-item" data-json="{{ json_encode($school) }}">
            <div class="uk-flex uk-flex-middle">
                <img src="{{ $image }}" width="48" height="48" alt="{{ $name }}">
                <div>
                    <div class="fw-medium ">{{ $name }}</div>
                    <div class="small text-secondary">Mã: {{ $code }}</div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="compare-school-empty text-secondary p-2">Không tìm thấy trường nào phù hợp.</div>
@endif
