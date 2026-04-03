<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GatewayAddonSettingsSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('addon_settings')) {
            return;
        }

        $gateways = [
            'fonepay' => [
                'gateway' => 'fonepay',
                'mode' => 'test',
                'status' => 0,
                'merchant_code' => '',
                'secret_key' => '',
                'return_url' => '',
                'r1' => '',
                'r2' => 'N/A',
            ],
            'fonepay_qr' => [
                'gateway' => 'fonepay_qr',
                'mode' => 'test',
                'status' => 0,
                'merchant_code' => '',
                'secret_key' => '',
                'return_url' => '',
                'r1' => '',
                'r2' => 'N/A',
            ],
        ];

        foreach ($gateways as $keyName => $defaults) {
            $row = DB::table('addon_settings')
                ->where('key_name', $keyName)
                ->where('settings_type', 'payment_config')
                ->first();

            if (!$row) {
                DB::table('addon_settings')->insert([
                    'key_name' => $keyName,
                    'live_values' => json_encode($defaults),
                    'test_values' => json_encode($defaults),
                    'settings_type' => 'payment_config',
                    'mode' => $defaults['mode'],
                    'is_active' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'additional_data' => json_encode([
                        'gateway_title' => $keyName === 'fonepay_qr' ? 'Fonepay QR' : 'Fonepay',
                        'gateway_image' => '',
                    ]),
                ]);
                continue;
            }

            $live = $this->decodeJson($row->live_values);
            $test = $this->decodeJson($row->test_values);
            $additional = $this->decodeJson($row->additional_data);

            $live = array_merge($defaults, $live);
            $test = array_merge($defaults, $test);
            $additional = array_merge([
                'gateway_title' => $keyName === 'fonepay_qr' ? 'Fonepay QR' : 'Fonepay',
                'gateway_image' => '',
            ], $additional);

            DB::table('addon_settings')
                ->where('key_name', $keyName)
                ->where('settings_type', 'payment_config')
                ->update([
                    'live_values' => json_encode($live),
                    'test_values' => json_encode($test),
                    'additional_data' => json_encode($additional),
                    'updated_at' => now(),
                ]);
        }
    }

    private function decodeJson($value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        return [];
    }
}
