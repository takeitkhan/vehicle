@extends('layouts.app')

@section('title')
    Single Vehicle
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Single Vehicle',
            'spSubTitle' => 'view a Vehicle',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('vehicles.create'),
            'spAllData' => route('vehicles.index'),
            'spSearchData' => route('vehicles.search'),
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search vehicles...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    {{--    <article class="panel is-primary">--}}
    {{--        <div class="customContainer">--}}
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Main Vehicle Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Name</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $vehicle->name }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Vehicle size</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $vehicle->size }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Probably Cost</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $vehicle->probably_cost }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('column_right')
   
@endsection
@section('cusjs')
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
@endsection
