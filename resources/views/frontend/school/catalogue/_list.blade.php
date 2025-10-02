<div class="school-list filter-list">
    @if(!is_null($schools) && count($schools))
        <div class="uk-grid uk-grid-medium">
            @foreach($schools as $item)
                <div class="uk-width-small-1-1 uk-width-medium-1-3 mb20">
                    <x-school :item="$item" />
                </div>
            @endforeach
        </div>
    @else
        <p>Không tìm thấy học bổng nào phù hợp.</p>
    @endif
</div>

<div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
    @include('frontend.component.pagination', ['model' => $schools])
</div>
