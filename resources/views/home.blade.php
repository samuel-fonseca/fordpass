@extends('_layouts.main')

@section('container')

<div class="row">
    <div class="col-12">
        <h1>{{ $details['nickName'] }}</h1>
        <h4>{{ $details['vehicleType'] }}</h4>
        <h4>VIN: {{ $details['vin'] }}</h4>
    </div>

    <hr />

    <div class="col-12">
        <h2>Vehicle Status</h2>
        <p class="text-muted">Last refreshed {{ $status['lastRefresh'] }}</p>
        <table class="table table-borderless">
            <tr>
                <th>Ignition</th>
                <td>{{ $status['ignitionStatus']['value'] }}</td>
            </tr>
            <tr>
                <th>Lock</th>
                <td>
                    <i
                        class="bi bi-{{ str_replace('ed', '', strtolower($status['lockStatus']['value'])) }}-fill"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ $status['lockStatus']['value'] }}"
                    ></i>
                </td>
            </tr>
            <tr>
                <th>Alarm</th>
                <td>
                    <i
                        class="bi bi-{{ $status['alarm']['value'] === 'ACTIVE' ? 'bell-fill' : 'bell-slash-fill' }}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ $status['alarm']['value'] }}"
                    ></i>
                </td>
            </tr>
            <tr>
                <th>Odometer</th>
                <td>
                    {{ $status['odometer']['value'] }} miles
                </td>
            </tr>
            <tr>
                <th>Fuel</th>
                <td>
                    <x-progress progress="{{ $status['fuel']['fuelLevel'] }}" content="⛽️  {{ round($status['fuel']['fuelLevel'], 2) }}%"></x-progress>
                </td>
            </tr>
            <tr>
                <th>Oil Life</th>
                <td>
                    <x-progress progress="{{ $status['oil']['oilLifeActual'] }}" content="<div class='d-flex-inline'><i class='bi bi-droplet-half'></i> {{ $status['oil']['oilLifeActual'] }}%</div>"></x-progress>
                </td>
            </tr>

            {{-- $this->info(sprintf('⚙️  Ignition status: %s', $response['ignitionStatus']['value']));
            if ($this->isCarRunning($response)) {
                $this->info('✅ Remote Start is on');
                $this->info(sprintf('Remote Start: %s (running since: %s)', $response['remoteStart']['remoteStartDuratin'], $response['remoteStart']['remoteStartTime']));
            } else {
                $this->info('⛔️ Remote Start is off');
            }
            $this->info(sprintf('🔒 Lock: %s (%s)', $response['lockStatus']['value'], $response['lockStatus']['timestamp']));
            $this->info(sprintf('🔔 Alarm: %s (%s)', $response['alarm']['value'], $response['alarm']['timestamp']));
            $this->info(sprintf('⏱  Odometer: %s (%s)', $response['odometer']['value'], $response['odometer']['timestamp']));
            $this->info(sprintf('⛽️ Fuel: %s%% (until empty: %s)', $response['fuel']['fuelLevel'], $response['fuel']['distanceToEmpty']));
            $this->info(sprintf('📍 Location: lat %s / long %s', $response['gps']['latitude'], $response['gps']['longitude']));
            $this->info(sprintf('🌎 Map View: https://duckduckgo.com/?q=%s,%s&ia=web&iaxm=maps', $response['gps']['latitude'], $response['gps']['longitude']));
            $this->info(sprintf('🔋 Battery Health: %s (%s)', $this->batteryHealthLevel($response['battery']), $response['battery']['batteryStatusActual']['value']));
            $this->info(sprintf('🛢  Oil Life: %s%%', $response['oil']['oilLifeActual']));
            $this->info(sprintf('🌡  Tire Pressure: %s', $this->tirePressureLevel($response['tirePressure']))); --}}
        </table>

        <div class="my-4">
            <x-raw-json :data="$status" />
        </div>

    </div>

    <hr />

    <div class="col-12">

        <iframe
            width="100%"
            height="300"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
            src="https://maps.google.com/maps?q={{ $status['gps']['latitude'] }},{{ $status['gps']['longitude'] }}&hl=es&z=14&amp;output=embed"
        ></iframe>
        <br />
        <small>
            <a
                href="https://maps.google.com/maps?q={{ $status['gps']['latitude'] }},{{ $status['gps']['longitude'] }}&hl=es;z=14&amp;output=embed"
                style="color:#0000FF;text-align:left"
                target="_blank"
            >
                See map bigger
            </a>
        </small>

    </div>
</div>

@endsection
