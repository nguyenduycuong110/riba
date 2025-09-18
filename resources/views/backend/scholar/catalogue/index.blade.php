
@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['table']; }} </h5>
                @include('backend.dashboard.component.toolbox', ['model' => $config['model']])
            </div>
            <div class="ibox-content">
                <x-backend.filter 
                    createRoute="scholar.catalogue.create"
                    submitRoute="scholar.catalogue.index"
                />
                <x-backend.customtable 
                    :records="$scholars->getCollection()"
                    :columns="[
                        'name' => ['label' => 'Tên Học Bổng', 'render' => fn($item) => e($item->name)],
                        'description' => ['label' => 'Mô tả', 'render' => fn($item) => strip_tags(html_entity_decode($item->description))]
                    ]"
                    :actions="[
                        ['route' => 'scholar.catalogue.edit', 'class' => 'btn-success', 'icon' => 'fa-edit'],
                        ['route' => 'scholar.catalogue.delete', 'class' => 'btn-danger', 'icon' => 'fa-trash'],
                    ]"
                    :model="$config['model']"
                />
                {{ $scholars->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
