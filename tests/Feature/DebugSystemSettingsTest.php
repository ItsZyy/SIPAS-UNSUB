<?php

namespace Tests\Feature;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebugSystemSettingsTest extends TestCase
{
    public function test_submit_form_and_check_db(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        // Reset DB to known state
        SystemSetting::setValue('session_timeout', '30');
        SystemSetting::setValue('max_file_size', '25');
        SystemSetting::setValue('log_retention_days', '30');

        // Simulate the EXACT form submission from browser
        $response = $this->actingAs($admin)->put('/settings/system', [
            'session_timeout' => '1',
            'max_file_size' => '75',
            'log_retention_days' => '60',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect();

        // Check what got saved
        echo "session_timeout = " . SystemSetting::getValue('session_timeout') . "\n";
        echo "max_file_size = " . SystemSetting::getValue('max_file_size') . "\n";
        echo "log_retention_days = " . SystemSetting::getValue('log_retention_days') . "\n";

        $this->assertEquals('1', SystemSetting::getValue('session_timeout'));
        $this->assertEquals('75', SystemSetting::getValue('max_file_size'));
        $this->assertEquals('60', SystemSetting::getValue('log_retention_days'));

        // Now simulate what Blade renders - check getValue
        echo "\n--- On next page load ---\n";
        echo "session_timeout = " . SystemSetting::getValue('session_timeout', '30') . "\n";
        $timeout = SystemSetting::getValue('session_timeout', '30');
        $presets = ['15', '30', '60'];
        echo "Is custom? " . (!in_array($timeout, $presets) ? 'yes' : 'no') . "\n";
        echo "Kustom radio value: " . (!in_array($timeout, $presets) ? $timeout : '(empty)') . "\n";
        echo "Custom input value: " . (!in_array($timeout, $presets) ? $timeout : '(empty)') . "\n";
    }
}
