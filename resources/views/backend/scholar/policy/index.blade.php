
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
                    createRoute="scholar.policy.create"
                    submitRoute="scholar.policy.index"
                />
                <x-backend.customtable 
                    :records="$policies->getCollection()"
                    :columns="[
                        'name' => ['label' => 'Chính sách', 'render' => fn($item) => e($item->name)],
                    ]"
                    :actions="[
                        ['route' => 'scholar.policy.edit', 'class' => 'btn-success', 'icon' => 'fa-edit'],
                        ['route' => 'scholar.policy.delete', 'class' => 'btn-danger', 'icon' => 'fa-trash'],
                    ]"
                    :model="$config['model']"
                />
                {{ $policies->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
