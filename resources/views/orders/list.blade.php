@extends('layouts.app')

@push('individual_styles')
    {{--    <link rel="stylesheet" href="{{ asset('css/choices.base.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom/realty_characteristics.css') }}">
@endpush

@section('content')
    <div class="container mb-2">
        <form class="w-100">
            <div class="row">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <div class="select_wr">
                            <select name="categories" id="category_select">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->ext_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row justify-content-center">
                        <div class="select_wr">
                            <select name="realty_type_id" id="realty_type_select">
                                <option value=""></option>
                                @foreach($realty_types as $realty_type)
                                    <option value="{{ $realty_type->ext_id }}">{{ $realty_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row justify-content-center">
                        <div class="select_wr">
                            <select id="operation_type_select" name="advert_type_id">
                                <option value=""></option>
                                @foreach($operation_types as $operation_type)
                                    <option value="{{ $operation_type->ext_id }}">{{ $operation_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row justify-content-center">
                        <div class="select_wr">
                            <button class="btn btn-success w-100">Поиск</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Orders</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>

                @foreach($orders as $order)

                    <div class="card mb-3">
                        <div class="row no-gutters">

                                <div class="col-md-4">
                                    <a href="{{ config('common.dom_ria_base_url') . $order->beautiful_url }}">
                                        <img src="{{ config('common.ria_images_base_url') . $order->main_photo }}" class="card-img" alt="...">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="{{ config('common.dom_ria_base_url') . $order->beautiful_url }}">
                                                {{ $order->district_type }}
                                                {{ $order->district_name }}
                                                {{ $order->street_name }}
                                                {{ $order->building_number_str }}
                                                {{ $order->flat_number }}
                                            </a>
                                        </h4>
                                        <h5 style="color: green;"><b>{{ $order->price }} {{ $order->currency_type }}</b></h5>
                                        <p>{{ $order->operation_type_name }} {{ $order->realty_type_name }}</p>
                                        <div class="d-flex justify-content-between">
                                            @if($order->rooms_count) <p>Комнат: {{ $order->rooms_count }}</p> @endif
                                            @if($order->floors_count) <p>Этаж: {{ $order->floor }} / {{ $order->floors_count }}</p> @endif
                                            @if($order->total_square_meters) <p>Площадь: {{ $order->total_square_meters }} м<sup>2</sup></p> @endif
                                        </div>
                                        <p class="card-text">{{ $order->description }}</p>
                                        <p class="card-text"><small class="text-muted">{{ $order->publishing_date }}</small></p>
                                    </div>
                                </div>

                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('individual_scripts')
    <script src="{{ asset('js/choices.min.js') }}"></script>
@endpush

@push('page_script')
    <script>
        $(function () {
            var select_config = {
                shouldSort: false
            };

            var categories_select = new Choices($('#category_select').get(0), select_config);
            var operation_types = new Choices($('#operation_type_select').get(0), select_config);
            var realty_types = new Choices($('#realty_type_select').get(0), select_config);
        });

        $('#category_select').on('change', function (event) {
            console.log('category_select changes');
        });

    </script>
@endpush
