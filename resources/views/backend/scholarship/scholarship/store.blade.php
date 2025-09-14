@include('backend.dashboard.component.breadcrumb', [
    'title' => $config['method'] == 'create' 
        ? $config['seo']['create']['title'] 
        : $config['seo']['edit']['title']
])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('scholarship.store') : route('scholarship.update', $scholarship->id);
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
                                    <label for="" class="control-label text-left">Học bổng <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($scholarship->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row mb20">
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nhóm học bổng <span class="text-danger">(*)</span></label>
                                    <select name="scholarship_catalogue_id" class="form-control setupSelect2">
                                        <option value="0">[Chọn nhóm học bổng]</option>
                                        @if(!empty($scholarshipCatalogues))
                                            @foreach($scholarshipCatalogues as $key => $item)
                                                <option {{ 
                                                    $item->id == old('scholarship_catalogue_id', (isset($scholarship->scholarship_catalogue_id)) ? $scholarship->scholarship_catalogue_id : '') ? 'selected' : '' 
                                                    }}  value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Chính sách<span class="text-danger">(*)</span></label>
                                    <select name="policy_id" class="form-control setupSelect2">
                                        <option value="0">[Chọn chính sách]</option>
                                        @if(!empty($policies))
                                            @foreach($policies as $key => $item)
                                                <option {{ 
                                                    $item->id == old('policy_id', (isset($scholarship->policy_id)) ? $scholarship->policy_id : '') ? 'selected' : '' 
                                                    }}  value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Thể loại đào tạo<span class="text-danger">(*)</span></label>
                                    <select name="train_id" class="form-control setupSelect2">
                                        <option value="0">[Chọn thể loại đào tạo]</option>
                                        @if(!empty($trains))
                                            @foreach($trains as $key => $item)
                                                <option {{ 
                                                    $item->id == old('train_id', (isset($scholarship->train_id)) ? $scholarship->train_id : '') ? 'selected' : '' 
                                                    }}  value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Giới thiệu về học bổng</label>
                                    <textarea 
                                        name="introduce" 
                                        class="ck-editor" 
                                        id="ckIntroduce"
                                        data-height="100">{{ old('introduce', ($scholarship->introduce) ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nội dung</label>
                                    <textarea 
                                        name="content" 
                                        class="ck-editor" 
                                        id="ckContent"
                                        data-height="150">{{ old('content', ($scholarship->content) ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('backend.scholarship.scholarship.component.policy')
            </div>
            <div class="col-lg-3">
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>Chọn trường</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <select multiple name="school_id[]" class="form-control setupSelect2">
                                        @if(!empty($schools))
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}"
                                                    @if(in_array($school->id, old('school_id', $schoolIds ?? [])))
                                                        selected
                                                    @endif>
                                                    {{ $school->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>Chọn ảnh</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <span class="image img-cover image-target"><img src="{{ (old('image', ($scholarship->image) ?? '' ) ? old('image', ($scholarship->image) ?? '')   :  'backend/img/not-found.jpg') }}" alt=""></span>
                                    <input type="hidden" name="image" value="{{ old('image', ($scholarship->image) ?? '' ) }}">
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

