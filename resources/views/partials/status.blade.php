<div class="row border-top my-3 py-3">

    <div class="col-12">
        <h2>Vehicle Status</h2>
        <p class="text-muted">Last refreshed {{ toPreferredTimezone($status['lastRefresh']) }}</p>
        <table class="table table-borderless">
            <tr>
                <th>Ignition</th>
                <td>
                    <i
                        class="fs-3 bi bi-{{ $status['ignitionStatus']['value'] == 'Off' ? 'dash-circle-dotted text-danger' : 'power text-green' }}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ $status['ignitionStatus']['value'] }}"
                    ></i>
                </td>
            </tr>
            <tr>
                <th>Remote Start</th>
                <td>
                    <i
                        class="fs-3 bi bi-{{ $status['ignitionStatus']['value'] == 1 ? 'power text-green' : 'dash-circle-dotted text-danger' }}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ $status['remoteStartStatus']['value'] == 1 ? 'On' : 'Off' }}"
                    ></i>
                    @if($status['remoteStartStatus']['value'] == 1)
                    {{ $status['remoteStart']['remoteStartDuration'] }} min left ({{ $status['remoteStart']['remoteStartTime'] }})
                    @endif
                </td>
            </tr>
            <tr>
                <th>Lock</th>
                <td>
                    <i
                        class="fs-3 bi bi-{{ str_replace('ed', '', strtolower($status['lockStatus']['value'])) }}-fill"
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
                        class="fs-3 bi bi-{{ in_array($status['alarm']['value'], ['ACTIVE', 'SET']) ? 'bell-fill' : 'bell-slash-fill' }}"
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
                <th>To Empty</th>
                <td>
                    {{ $status['fuel']['distanceToEmpty'] }} miles to Empty
                </td>
            </tr>
            <tr>
                <th>Oil Life</th>
                <td>
                    <x-progress progress="{{ $status['oil']['oilLifeActual'] }}" content="<div class='d-flex-inline'><i class='bi bi-droplet-half'></i> {{ $status['oil']['oilLifeActual'] }}%</div>"></x-progress>
                </td>
            </tr>
            <tr>
                <th>Tire Pressure (PSI)</th>
                <td>
<pre><code>
{{ tirePressureConvert($status['TPMS']['leftFrontTirePressure']['value']) }} | {{ tirePressureConvert($status['TPMS']['rightFrontTirePressure']['value']) }}
   |
{{ tirePressureConvert($status['TPMS']['outerLeftRearTirePressure']['value']) }} | {{ tirePressureConvert($status['TPMS']['outerRightRearTirePressure']['value']) }}
</code></pre>
                </td>
            </tr>
        </table>

        <div class="my-4">
            <x-raw-json title="Raw Status" :data="$status" />
        </div>

    </div>

</div>
