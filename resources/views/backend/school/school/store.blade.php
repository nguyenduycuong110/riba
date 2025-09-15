@include('backend.dashboard.component.breadcrumb', [
    'title' => $config['method'] == 'create' 
        ? $config['seo']['create']['title'] 
        : $config['seo']['edit']['title']
])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('school.store') : route('school.update', $school->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin chung</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Tiêu đề <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($school->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row mb30">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Giới thiệu ngắn</label>
                                    <textarea 
                                        name="description" 
                                        class="ck-editor" 
                                        id="ckDescription"
                                        data-height="100">{{ old('description', ($school->description) ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Giới thiệu</label>
                                    <textarea 
                                        name="introduction" 
                                        class="ck-editor" 
                                        id="ckIntroduction"
                                        data-height="300">{{ old('introduction', ($school->introduction) ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    @include('backend.dashboard.component.album', ['model' => $school ?? null])
                </div>
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tổng quan</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table>
                                    <thead>
                                        <h3>Thông tin trường</h3>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th><span class="fixed-text">Tiếng Việt</span></th>
                                            <td class="input-value">
                                                <input type="text" name="information[university_vn]" class="form-control">
                                            </td>
                                            <th><span class="fixed-text">Tiếng Anh</span></th>
                                            <td class="input-value">
                                                <input type="text" name="information[university_en]" class="form-control">
                                            </td>
                                            <th><span class="fixed-text">Tiếng Trung</span></th>
                                            <td class="input-value">
                                                <input type="text" name="information[university_cn]" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Loại hình</span></th>
                                            <td class="input-value">
                                                <input type="text" name="information[type]" class="form-control">
                                            </td>
                                            <th><span class="fixed-text">Năm thành lập</span></th>
                                            <td class="input-value">
                                                <input type="number" name="information[founded]" class="form-control">
                                            </td>
                                            <th><span class="fixed-text">Cơ sở trường</span></th>
                                            <td class="input-value">
                                                <input type="number" name="information[facility_number]" class="form-control" min="1" max="100">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Khu vực</span></th>
                                            <td class="input-value">--</td>
                                            <th><span class="fixed-text">Tỉnh</span></th>
                                            <td class="input-value">--</td>
                                            <th><span class="fixed-text">Thành phố</span></th>
                                            <td class="input-value">Thượng Hải</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Xếp hạng quốc gia</span></th>
                                            <td class="input-value">5</td>
                                            <th><span class="fixed-text">Học phí 1 năm tiếng</span></th>
                                            <td class="input-value">21,000</td>
                                            <th><span class="fixed-text">Cấp thành phố</span></th>
                                            <td class="input-value">--</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Xếp hạng thế giới</span></th>
                                            <td class="input-value">56</td>
                                            <th><span class="fixed-text">Học phí hệ Đại học (Tệ/năm)</span></th>
                                            <td class="input-value">23,000-54,600</td>
                                            <th><span class="fixed-text">Quy mô thành phố</span></th>
                                            <td class="input-value">--</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Số lượng sinh viên</span></th>
                                            <td class="input-value">54,528</td>
                                            <th><span class="fixed-text">Học phí hệ Thạc sĩ (Tệ/năm)</span></th>
                                            <td class="input-value">26,000-528,000</td>
                                            <th><span class="fixed-text">Xếp loại thành phố</span></th>
                                            <td class="input-value">--</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Số lượng sinh viên quốc tế</span></th>
                                            <td class="input-value">2,535</td>
                                            <th><span class="fixed-text">Học phí hệ Tiến sĩ (Tệ/năm)</span></th>
                                            <td class="input-value">30,000-180,000</td>
                                            <th><span class="fixed-text">Diện tích (m²)</span></th>
                                            <td class="input-value">2,410,800</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Số lượng giảng viên</span></th>
                                            <td class="input-value">5,731</td>
                                            <th><span class="fixed-text">Phí ký túc xá (Tệ/tháng)</span></th>
                                            <td class="input-value">--</td>
                                            <th><span class="fixed-text">Sách thư viện</span></th>
                                            <td class="input-value">5,910,600</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Số lượng chuyên ngành</span></th>
                                            <td class="input-value">80</td>
                                            <th><span class="fixed-text">Sinh hoạt phí (Tệ/tháng)</span></th>
                                            <td class="input-value">4,000</td>
                                            <th><span class="fixed-text">Phòng thí nghiệm</span></th>
                                            <td class="input-value">231</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Số lượng ngành học</span></th>
                                            <td class="input-value">80</td>
                                            <th><span class="fixed-text">Ngành trọng điểm</span></th>
                                            <td class="input-value">61</td>
                                            <th><span class="fixed-text">Số nhà ăn</span></th>
                                            <td class="input-value">N/A</td>
                                        </tr>
                                        <tr>
                                            <th><span class="fixed-text">Chuyên ngành tiến sĩ</span></th>
                                            <td class="input-value">N/A</td>
                                            <th><span class="fixed-text">Số loại học bổng</span></th>
                                            <td class="input-value">--</td>
                                            <th><span class="fixed-text">Chuyên ngành thạc sĩ</span></th>
                                            <td class="input-value">N/A</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox-w mb20">
                    <div class="ibox-content">
                        <div class="row mb15">
                             <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Xếp hạng <span class="text-danger">(*)</span></label>
                                    <div class="rate">
                                        <input 
                                            type="number"
                                            name="rate"
                                            value="{{ old('rate', ($school->rate) ?? '' ) }}"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            min="1"
                                            max="1000"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                             <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mã trường <span class="text-danger">(*)</span></label>
                                    <div class="code">
                                        <input 
                                            type="text"
                                            name="code"
                                            value="{{ old('code', ($school->code) ?? '' ) }}"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Email <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="email"
                                        value="{{ old('email', ($school->email) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Số điện thoại</label>
                                    <input 
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone', ($school->phone) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Địa chỉ</label>
                                    <input 
                                        type="text"
                                        name="address"
                                        value="{{ old('address', ($school->address) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Link website</label>
                                    <input 
                                        type="text"
                                        name="link_website"
                                        value="{{ old('link_website', ($school->link_website) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>Chọn logo</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <span class="image img-cover image-target"><img src="{{ (old('logo', ($school->logo) ?? '' ) ? old('logo', ($school->logo) ?? '')   :  'backend/img/not-found.jpg') }}" alt=""></span>
                                    <input type="hidden" name="logo" value="{{ old('logo', ($school->logo) ?? '' ) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>Chọn ảnh đại diện</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <span class="image img-cover image-target"><img src="{{ (old('image', ($school->image) ?? '' ) ? old('image', ($school->image) ?? '')   :  'backend/img/not-found.jpg') }}" alt=""></span>
                                    <input type="hidden" name="image" value="{{ old('image', ($school->image) ?? '' ) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h5>Toàn cảnh trường</h5>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <textarea name="panorama" class="form-control" style="height:168px;">{{ old('panorama', (isset($school->panorama)) ? $school->panorama : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb5">
                            <h5>Video</h5>
                            <p class="system-link" style="margin-bottom:0;color:#2962ff;">Mỗi 1 link video cách nhau 1 dấu , và xuống dòng</p>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <textarea name="video" class="form-control video-target" style="height:168px;">{{ old('video', (isset($school->video)) ? $school->video : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <label for="" class="uk-flex uk-flex-space-between">
                            <h5>Bản đồ</h5>
                            <a class="system-link" target="_blank" href="https://manhan.vn/hoc-website-nang-cao/huong-dan-nhung-ban-do-vao-website/">Hướng dẫn thiết lập bản đồ</a>
                        </label>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <textarea name="map" class="form-control" style="height:168px;">{{ old('map', (isset($school->map)) ? $school->map : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>
<style>
    table{
        width: 100%;
    }
    th{
        font-weight: 500;
        width: 210px;
    }
    td,th{
        border: 1px solid #e7e7e7;
        padding: 10px;
    }
</style>