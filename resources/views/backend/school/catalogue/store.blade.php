@include('backend.dashboard.component.breadcrumb', [
    'title' => $config['method'] == 'create' 
        ? $config['seo']['create']['title'] 
        : $config['seo']['edit']['title']
])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('school.catalogue.store') : route('school.catalogue.update', $schoolCatalogue->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin chung</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    @if($config['method'] == 'create')
                                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb5">
                                            <label for="" class="control-label text-left">Loại hình trường<span class="text-danger">(*)</span></label>
                                            <button type="button" class="add-item">+ Thêm loại hình trường</button>
                                        </div>
                                        <input 
                                            type="text"
                                            name="name[]"
                                            value="{{ old('name.0', '') }}"
                                            class="form-control"
                                            placeholder="Nhập loại hình trường"
                                            autocomplete="off"
                                        >
                                        <div class="group-input">
                                            @if(old('name'))
                                                @foreach(old('name') as $index => $value)
                                                    @if($index > 0) 
                                                        <div class="input-item">
                                                            <div class="row">
                                                                <div class="col-lg-11">
                                                                    <div class="form-row">
                                                                        <input 
                                                                            type="text"
                                                                            name="name[]"
                                                                            value="{{ $value }}"
                                                                            class="form-control mt10"
                                                                            placeholder="Nhập loại hình trường"
                                                                            autocomplete="off"
                                                                        >
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <button type="button" class="form-control btn btn-danger remove-item mt10">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    @else
                                        <label for="" class="control-label text-left">Loại hình trường <span class="text-danger">(*)</span></label>
                                        <input 
                                            type="text"
                                            name="name"
                                            value="{{ old('name', isset($schoolCatalogue) ? $schoolCatalogue->name : '') }}"
                                            class="form-control"
                                            placeholder="Nhập loại hình trường"
                                            autocomplete="off"
                                        >
                                    @endif
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

