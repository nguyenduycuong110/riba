@props(['scholars'])


<div class="panel-form" id="panel-form">
    <div class="form-area">
        <div class="apply-form-4__bg__1 d-none d-xl-block"></div>
        <div class="apply-form-4__bg__2"></div>
        <div class="apply-form-4__thumb__bg" style="background-image: url(https://wp.rrdevs.net/routex/wp-content/uploads/2024/10/thumb-bg.jpg);"></div>
        <div class="apply-form-4__shape upDown d-none d-xxl-block" bis_skin_checked="1">
            <img decoding="async" src="/vendor/frontend/img/project/apply-form-4-shape.png" alt="image not found">
        </div>
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-large-1-2">
                    <div class="apply-form-wrapper">
                        <form action="post" class="reg-form">
                            <div class="form-heading">
                                <h2 class="heading-3"><span>Đăng Ký<br /> Tư Vấn <span class="clr">Học Bổng</span> </span></h2>
                                <div class="description">
                                    Liên hệ ngay cho Du học CTI HSK để được tư vấn hỗ trợ
                                </div>
                                <div class="form-container">
                                    <div class="uk-grid uk-grid-medium mb20">
                                        <div class="uk-width-large-1-2">
                                            <div class="form-row">
                                                <input class="input-text form-control" value="" required placeholder="Họ Tên *" type="text">
                                            </div>
                                        </div>
                                        <div class="uk-width-large-1-2">
                                            <div class="form-row">
                                                <input class="input-text form-control" value="" required placeholder="Email *" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-grid uk-grid-medium mb20">
                                        <div class="uk-width-large-1-2">
                                            <div class="form-row">
                                                <input class="input-text form-control" value="" required placeholder="Số điện thoại *" type="text">
                                            </div>
                                        </div>
                                        <div class="uk-width-large-1-2">
                                            <div class="form-row">
                                                <input class="input-text form-control" value="" placeholder="Địa chỉ *" type="text">
                                            </div>
                                            {{-- <div class="form-row">
                                                <select name="schoolarshipType" id="schoolarshipType" class="form-control">
                                                    <option value="0">Chọn loại học bổng</option>
                                                    @forelse($scholars as $scholar)
                                                        <option value="{{ $scholar->id }}">{{ $scholar->languages->first()->pivot->name }}</option>
                                                    @empty
                                                        <option value="">Không có học bổng</option>
                                                    @endforelse
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="uk-grid uk-grid-medium mb20">
                                        <div class="uk-width-large-1-1">
                                            <div class="form-row">
                                               <input name="messsage" placeholder="Nhập vào nội dung tư vấn" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" value="submit">Đăng Ký Ngay</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>