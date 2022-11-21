@extends('_layouts.main')

@section('container')

<div class=""></div>

<div class="container py-5">
    <div class="row">
        <div class="col-xs-8 col-md-10">
            <h1>
                {{ $details['nickName'] }}
                <span class="fs-4">{{ $details['vehicleType'] }}</span>
            </h1>
            <h5>VIN: {{ $details['vin'] }}</h5>
        </div>
        <div class="col-xs-4 col-md-2">
            <x-raw-json title="Raw Details" :data="$details" />
        </div>

    </div>

    @include('partials.status')

    @include('partials.map')

</div>

@endsection
