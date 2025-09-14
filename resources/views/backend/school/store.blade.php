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
                            <div class="col-lg-5">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Tên trường<span class="text-danger">(*)</span></label>
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
                            <div class="col-lg-3">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mã trường</label>
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
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Email<span class="text-danger">(*)</span></label>
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
                            <div class="col-lg-4">
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
                            <div class="col-lg-4">
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
                            <div class="col-lg-4">
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
                        <div class="row mb30">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mô tả ngắn</label>
                                    <textarea 
                                        name="description" 
                                        class="ck-editor" 
                                        id="ckDescription"
                                        data-height="100">{{ old('description', ($school->description) ?? '') }}</textarea>
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
                        <div class="row mb30">
                            <div class="col-lg-12">
                                <label for="" class="control-label text-left">Toàn cảnh trường</label>
                                <div class="form-row">
                                    <textarea name="panorama" class="form-control" style="height:168px;">{{ old('panorama', (isset($school->panorama)) ? $school->panorama : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb30">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Thông tin trường</label>
                                    <textarea 
                                        name="information" 
                                        class="ck-editor" 
                                        id="ckInformation"
                                        data-height="200">{{ old('information', ($school->information) ?? '') }}</textarea>
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
            </div>
            <div class="col-lg-3">
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
                            <h5>Video</h5>
                            <a href="" class="upload-video">Upload Video</a>
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
