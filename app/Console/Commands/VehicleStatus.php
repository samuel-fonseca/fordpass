<?php

namespace App\Console\Commands;

use App\Services\Ford\Vehicle;
use Exception;
use Illuminate\Console\Command;

class VehicleStatus extends Command
{
    protected $signature = 'vehicle:status';

    protected $description = 'Get the current status of your Ford vehicle from the console';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Vehicle $service)
    {
        $response = $service->status()['vehiclestatus'];

        $this->info(sprintf('🚗 VIN: %s', $response['vin']));
        $this->info(sprintf('⚙️ Ignition status: %s', $response['ignitionStatus']['value']));
        if ($this->isCarRunning($response)) {
            $this->info('✅ Remote Start is on');
            $this->info(sprintf('Remote Start: %s (running since: %s)', $response['remoteStart']['remoteStartDuration'], $response['remoteStart']['remoteStartTime']));
        } else {
            $this->info('⛔️ Remote Start is off');
        }
        $this->info(sprintf('🔒 Lock: %s (%s)', $response['lockStatus']['value'], $response['lockStatus']['timestamp']));
        $this->info(sprintf('🔔 Alarm: %s (%s)', $response['alarm']['value'], $response['alarm']['timestamp']));
        $this->info(sprintf('⏱  Odometer: %s (%s)', $response['odometer']['value'], $response['odometer']['timestamp']));
        $this->info(sprintf('⛽️ Fuel: %s (until empty: %s)', $response['fuel']['fuelLevel'], $response['fuel']['distanceToEmpty']));
        $this->info(sprintf('📍 Location: lat %s / long %s', $response['gps']['latitude'], $response['gps']['longitude']));
        $this->info(sprintf('🔋 Battery Health: %s (%s)', $this->batteryHealthLevel($response['battery']), $response['battery']['batteryStatusActual']['value']));
        $this->info(sprintf('🛢  Oil Life: %s', $response['oil']['oilLifeActual']));
        $this->info(sprintf('🌡  Tire Pressure: %s', $this->tirePressureLevel($response['tirePressure'])));

        $this->line('----------------------------------');

        $this->line(sprintf('Last Refresh: %s', $response['lastRefresh']));
        $this->line(sprintf('Last Modified: %s', $response['lastModifiedDate']));
        $this->line(sprintf('Server Time: %s', $response['serverTime']));
    }

    private function isCarRunning(array $response): bool
    {
        return ((int) $response['remoteStartStatus']['value'] ?? 0) === 1;
    }

    private function batteryHealthLevel(array $battery): string
    {
        return $battery['batteryHealth']['value'] === 'STATUS_GOOD'
            ? '✅'
            : '⛔️';
    }

    private function tirePressureLevel(array $pressure): string
    {
        return $pressure['value'] === 'STATUS_GOOD'
            ? '✅'
            : '⛔️';
    }
}
