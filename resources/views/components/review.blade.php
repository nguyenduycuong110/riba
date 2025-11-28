@props(['item'])
@php
    // Xử lý cho cả Post và School model
    $language = $item->languages->first() ?? null;
    if($language) {
        // Nếu có pivot (belongsToMany như School)
        $name = $language->pivot->name ?? $language->name ?? '';
        $description = cutnchar(strip_tags($language->pivot->description ?? $language->description ?? ''));
        $canonical = write_url($language->pivot->canonical ?? $language->canonical ?? '');
    } else {
        // Fallback nếu không có language
        $name = '';
        $description = '';
        $canonical = '#';
    }
    $content = explode(',', $item->extra ?? '');
    $image = $item->image ?? '';
    $logo = $item->logo ?? '';
    // $rank = rand(1,10);
    $rate = $item->rate ?? rand(75,100);
    $comments = $item->comments ?? 0;
@endphp
<div class="review-item">
    <a href="{{ $canonical }}" class="image img-cover">
        <img src="{{ $image }}" alt="{{ $name }}">
        <span class="school-logo">
            <img src="{{ $logo }}" alt="logo">
        </span>
    </a>
    <div class="info">
        <div class="info-content">
             <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
            <div class="description">
                {!! $description !!}
            </div>
        </div>
        @if(count($content))
        <div class="extra-description">
            @foreach($content as $c)
            <p>{{ $c }}</p>
            @endforeach
        </div>
        @endif
        <a href="{{ $canonical }}" class="show-more-3">Xem thêm</a>
    </div>
     <div class="overlay">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="review-widget uk-flex uk-flex-middle">
                <div class="heart-icon"><i class="fa fa-heart-o"></i></div>
                <div class="uk-flex uk-flex-middle">
                    <span class="mr10">{{ $comments }} đánh giá </span>
                    <div class="star-rating uk-flex uk-flex-right">
                        <div class="stars" style="--star-width: {{ $rate }}%"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="rank">#{{ $rank }}</div> --}}
        </div>
    </div>
</div>