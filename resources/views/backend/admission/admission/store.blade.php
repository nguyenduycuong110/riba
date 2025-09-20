@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo'][$config['method']]['title']])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('scholar.store') : route('scholar.update', $scholar->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                @php
                    $translation = (isset($scholar)) ? $scholar->languages->first()->pivot : null;
                @endphp
                <x-backend.content-scholar
                    :name="$translation?->name"
                    description="{!! $translation?->description !!}"
                    content="{!! $translation?->content !!}"
                />
                <x-backend.album 
                    :model="$scholar ?? null"
                />
                <x-backend.policy 
                    :model="$scholar ?? null"
                />
                <x-backend.seo 
                    :meta_title="$translation?->meta_title"
                    :meta_keyword="$translation?->meta_keyword"
                    :meta_description="$translation?->meta_description"
                    :canonical="$translation?->canonical"
                />
            </div>
            <div class="col-lg-3">
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>{{ __('messages.scholar_catalogue') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <x-backend.select2-custom
                            :options="$scholarCatalogues"
                            :heading="__('messages.scholar_catalogue')"
                            name="scholar_catalogue_id"
                            :selectedValue="$scholar->scholar_catalogue_id ?? 0"
                        />
                    </div>
                </div>

                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>{{ __('messages.policy') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <x-backend.select2-custom
                            :options="$policies"
                            :heading="__('messages.policy')"
                            name="policy_id"
                            :selectedValue="$scholar->policy_id ?? 0"
                        />
                    </div>
                </div>

                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>{{ __('messages.train') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <x-backend.select2-custom
                            :options="$trains"
                            :heading="__('messages.train')"
                            name="train_id"
                            :selectedValue="$scholar->train_id ?? 0"
                        />
                    </div>
                </div>
                
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>{{ __('messages.image') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <x-backend.image-preview 
                            name="image"
                            :value="$scholar->image ?? ''"
                        />
                    </div>
                </div>

                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>Cấu hình nâng cao</h5>
                    </div>
                    <div class="ibox-content">
                        <x-backend.select2 
                            :options="__('messages.publish')"
                            name="publish"
                            :selectedValue="$scholar->publish ?? 0"
                            class="mb10"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15 fixed-bottom">
            <button class="btn btn-primary" type="submit" name="send" value="send_and_stay">{{ __('messages.save') }}</button>
            <button class="btn btn-success" type="submit" name="send" value="send_and_exit">Đóng</button>
        </div>
    </div>
</form>
