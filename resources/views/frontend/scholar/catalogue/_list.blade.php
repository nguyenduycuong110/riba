<div class="scholar-list filter-list">
    @if(!is_null($scholars) && count($scholars))
        <div class="uk-grid uk-grid-medium">
            @foreach($scholars as $item)
                @php
                    $name = $item->languages->first()->pivot->name;
                    $canonical = write_url($item->languages->first()->pivot->canonical);
                    $catName = $item->scholar_catalogues->first()->languages->first()->pivot->name ?? '';
                    $image = $item->image;
                @endphp
                <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 mb20">
                    <div class="scholar-item">
                        <a href="{{ $canonical }}" class="image img-cover">
                            <img src="{{ $image }}" alt="{{ $name }}" class="img-zoomin">
                        </a>
                        <div class="info">
                            <h3 class="title">
                                <a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
                            </h3>
                            <ul class="uk-list uk-clearfix">
                                <li>Loại học bổng: {{ $catName }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Không tìm thấy học bổng nào phù hợp.</p>
    @endif
</div>

<div class="model-paginate mt30 mb30 uk-flex uk-flex-center">
    @include('frontend.component.pagination', ['model' => $scholars])
</div>
