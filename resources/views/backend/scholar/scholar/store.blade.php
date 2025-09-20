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
                <x-backend.content
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
                <x-ibox heading="Chọn Danh mục cha">
                     <x-backend.select2
                        :options="$dropdown"
                        heading="Chọn danh mục cha"
                        name="scholar_catalogue_id"
                        :selectedValue="$scholar->scholar_catalogue_id ?? 0"
                    />
                </x-ibox>
                
                <x-ibox heading="Chọn Chính sách">
                     <x-backend.select2
                        :options="$policies"
                        heading="Chọn chính sách"
                        name="policy_id"
                        :selectedValue="$scholar->policy_id ?? 0"
                    />
                </x-ibox>

                <x-ibox heading="Chọn Hệ đào tạo">
                     <x-backend.select2
                        :options="$trains"
                        heading="Chọn chính sách"
                        name="train_id"
                        :selectedValue="$scholar->train_id ?? 0"
                    />
                </x-ibox>
                
                <x-ibox heading="Ảnh đại diện">
                    <x-backend.image-preview 
                        name="image"
                        :value="$scholar->image ?? ''"
                    />
                </x-ibox>

                <x-ibox heading="Cấu hình nâng cao">
                    <x-backend.select2 
                        :options="__('messages.publish')"
                        name="publish"
                        :selectedValue="$scholar->publish ?? 0"
                        class="mb10"
                    />
                </x-ibox>
            </div>
        </div>
        <div class="text-right mb15 fixed-bottom">
            <button class="btn btn-primary" type="submit" name="send" value="send_and_stay">{{ __('messages.save') }}</button>
            <button class="btn btn-success" type="submit" name="send" value="send_and_exit">Đóng</button>
        </div>
    </div>
</form>
