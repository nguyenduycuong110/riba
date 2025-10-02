<div class="scholar-list filter-list">
    @if(!is_null($admissions) && count($admissions))
    <div class="uk-grid uk-grid-medium">
        <div class="uk-width-small-1-1">
            @foreach($admissions as $item)
            <x-admission-item :item="$item" />
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
    @include('frontend.component.pagination', ['model' => $admissions])
</div>