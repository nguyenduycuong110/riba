@extends('frontend.homepage.layout')
@section('content')
    <div class="lecturer-page">
        <div class="uk-container uk-container-center">
            <div class="lecturer-info">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-medium-1-4">
                        <a href="" class="image img-cover">
                            <img src="{{ $lecturer->image }}" alt="">
                        </a>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <div class="text-content">
                            <h2 class="heading-1">
                                <span>{{ $lecturer->name }}</span>
                            </h2>
                            <div class="description">
                                {!! $lecturer->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-courses">
                <h2 class="heading-1 mb30">
                    <span>Danh sách khóa học của {{ $lecturer->name }}</span>
                </h2>
                @if(!empty($products))
                    <div class="uk-grid uk-grid-medium">
                        @foreach ($products as $product)
                            <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4 mb25">
                                @include('frontend.component.p-item', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
