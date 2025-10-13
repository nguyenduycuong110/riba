<div class="major-list panel-major filter-list">
    @if(!is_null($majors) && count($majors))
    <div class="uk-grid uk-grid-medium">
        @foreach($majors as $item)
        @php
            $name = $item->languages->first()->pivot->name;
            $canonical = write_url($item->languages->first()->pivot->canonical);
            $description = $item->languages->first()->pivot->description;
            $image = $item->image;
            $rate = rand(75, 100);
        @endphp
        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-4 mb20">
            <div class="major-item">
                <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                <div class="info">
                    <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                    <div class="description">
                        {!! $description !!}
                    </div>
                </div>
                <div class="overlay">
                    <div class="uk-flex uk-flex-middle">
                        <span>Đánh giá: </span>
                        <div class="star-rating uk-flex uk-flex-right">
                            <div class="stars" style="--star-width: {{ $rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>