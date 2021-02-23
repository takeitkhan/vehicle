@extends('layouts.app')
@section('title')
    Edit Vehicle
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Edit Vehicle',
            'spSubTitle' => 'Edit a single vehicle',
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
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Vehicle Information</a>
        </p>


        <div class="customContainer">
            {{ Form::open(array('url' => route('vehicles.update', $vehicle->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('name', 'Name', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('name', $vehicle->name ?? NULL, ['class' => 'input', 'placeholder' => 'Enter name...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('size', 'Vehicle Size', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('size', $vehicle->size ?? NULL, ['class' => 'input', 'placeholder' => 'Enter Vehicle Size...']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                 <div class="column is-3">
                    <div class="field">
                        {{ Form::label('probably_cost', 'Probably Cost', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('probably_cost', $vehicle->probably_cost ?? NULL, ['class' => 'input', 'placeholder' => 'Enter probably cost...']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </article>
@endsection

@section('column_right')
    <article class="is-primary">
        <div class="box">
            <h1 class="title is-5">Important Note</h1>
            <p>
                Please select project manager and budget properly
            </p>
        </div>
    </article>
@endsection
