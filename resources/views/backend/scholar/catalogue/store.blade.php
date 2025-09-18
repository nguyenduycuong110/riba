@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo'][$config['method']]['title']])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('scholar.catalogue.store') : route('scholar.catalogue.update', $scholarCatalogue->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.tableHeading') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content', ['model' => ($postCatalogue) ?? null])
                    </div>
                </div>
               @include('backend.dashboard.component.album', ['model' => ($postCatalogue) ?? null])
               @include('backend.dashboard.component.seo', ['model' => ($postCatalogue) ?? null])
            </div>
            <div class="col-lg-3">
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>{{ __('messages.parent') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <span class="text-danger notice" >*{{ __('messages.parentNotice') }}</span>
                                    <select name="parent_id" class="form-control setupSelect2" id="">
                                        @foreach($dropdown as $key => $val)
                                        <option {{ 
                                            $key == old('parent_id', (isset($postCatalogue->parent_id)) ? $postCatalogue->parent_id : '') ? 'selected' : '' 
                                            }} value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('backend.dashboard.component.publish', ['model' => ($postCatalogue) ?? null, 'hideImage' => false])
            </div>
        </div>
        <div class="text-right mb15 fixed-bottom">
            <button class="btn btn-primary" type="submit" name="send" value="send_and_stay">{{ __('messages.save') }}</button>
            <button class="btn btn-success" type="submit" name="send" value="send_and_exit">Đóng</button>
        </div>
    </div>
</form>
