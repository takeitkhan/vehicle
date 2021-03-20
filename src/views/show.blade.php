@extends('layouts.app')

@section('title')
    Single Vehicle
@endsection
@if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id))
    @php
        $addUrl = route('vehicles.create');
    @endphp
@else
    @php
        $addUrl = '#';
    @endphp
@endif
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
            'spAddUrl' => $addUrl,
            'spAllData' => route('vehicles.index'),
            'spSearchData' => route('vehicles.search'),
            'spTitle' => 'Vehicles',
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('vehicles.create'),
            'spAllData' => route('vehicles.index'),
            'spSearchData' => route('vehicles.search'),
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


    @php
        $daterange = request()->get('daterange');
        if(!empty(request()->get('daterange'))) {
            $dates = explode(' - ', $daterange);
            $start = $dates[0];
            $end = $dates[1];
            $vehicles = \Tritiyo\Task\Models\TaskVehicle::leftJoin('tasks', 'tasks.id', 'tasks_vehicle.task_id')
                    ->where('tasks_vehicle.vehicle_id', $vehicle->id)
                    ->whereBetween('tasks.task_for', [$start, $end])
                    ->get();
        } else {
            $vehicles = \Tritiyo\Task\Models\TaskVehicle::leftJoin('tasks', 'tasks.id', 'tasks_vehicle.task_id')
                    ->where('tasks_vehicle.vehicle_id', $vehicle->id)
                    ->whereBetween('tasks.task_for', [ date('Y-m-d'), date('Y-m-d') ])
                    ->get();
        }

        //dd($vehicles);
    @endphp

    <div class="card tile is-child" style="margin-top: 15px !important;">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Vehicle Used

            {{ Form::open(array('url' => route('vehicles.show', $vehicle->id), 'method' => 'GET', 'value' => 'PATCH', 'id' => 'tasks_advanced_search', 'class' => 'dateFilter', 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column">
                    <input class="input is-small" type="text" name="daterange" value=""/>
                </div>
                <div class="column">
                    <input name="search" type="submit" class="button is-small is-primary has-background-primary-dark"
                           value="Search"/>
                </div>
            </div>
            {{ Form::close() }}
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                @if($vehicles->count() > 0)
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <tr>
                            <th title="Task date" width="20%">Task Name</th>
                            <th title="Task date" width="10%">Task date</th>
                            <th title="Task head">Site Head</th>
                            <th title="Project Name">Project Name</th>
                            <th title="Vehicle Rent">Vehicle Rent</th>
                            <th title="Vehicle Note">Vehicle Note</th>
                        </tr>
                        @php
                            $in_total = [];
                        @endphp

                        @foreach($vehicles as $vehicle)
                            <tr>
                                <td title="Task ID">
                                    <a href="{{ route('tasks.show', $vehicle->task_id) }}" target="_blank">
                                        {{ \Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->task_name }}
                                    </a>
                                </td>
                                <td title="Task date">
                                    {{ \Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->task_for }}
                                </td>
                                <td title="Task head">
                                    {{ \App\Models\User::where('id', \Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->site_head)->first()->name }}
                                </td>
                                <td title="Project Name">
                                    <a href="{{ route('projects.show', \Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->project_id) }}"
                                       target="_blank">
                                        {{ \Tritiyo\Project\Models\Project::where('id', \Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->project_id)->first()->name }}
                                    </a>
                                </td>
                                <td title="Vehicle Rent">
                                    {{ $in_total[] = $vehicle->vehicle_rent }}
                                </td>
                                <td title="Resource Used">
                                    {{ $vehicle->vehicle_note }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">
                                In Total for this vehicle
                            </td>
                            <td>
                                {{ 'BDT. ' . array_sum($in_total) }}
                            </td>
                        </tr>
                    </table>
                @else
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <tr>
                            <td title="Task date" width="20%">No vehicle used based on your selected date range.
                            </th>
                        </tr>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('column_right')

@endsection


@section('cusjs')
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>


    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
@endsection
