@extends('frontend.homepage.layout')
@section('content')
    <div class="schools page-wrapper">
        <div class="uk-container-1440 uk-container-center">
            @include('frontend.school.catalogue.component.filter')
            <div class="panel-body mb40">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-medium-2-3">
                        @if (!is_null($schools))
                            <div class="school-list">
                                <div class="uk-grid uk-grid-medium">
                                    @foreach ($schools as $item)
                                        <div class="uk-width-1-1 uk-width-small-1-1 uk-width-large-1-3 uk-width-xlarge-1-3 mb25">
                                            <x-school :item="$item" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="uk-width-medium-1-3">
                        @include('frontend.school.catalogue.component.aside')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
