<?php

namespace Tests\Unit\Models;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_filters_and_fields_are_cast_to_array(): void
    {
        $report = Report::factory()->create([
            'filters' => ['city' => 'Salvador'],
            'fields' => ['date', 'city'],
        ]);

        $this->assertIsArray($report->filters);
        $this->assertSame(['city' => 'Salvador'], $report->filters);
        $this->assertSame(['date', 'city'], $report->fields);
    }

    public function test_format_and_status_are_cast_to_enums(): void
    {
        $report = Report::factory()->create([
            'format' => ReportFormat::Pdf->value,
            'status' => ReportStatus::Processing->value,
        ]);

        $this->assertSame(ReportFormat::Pdf, $report->format);
        $this->assertSame(ReportStatus::Processing, $report->status);
    }

    public function test_report_belongs_to_a_user(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($report->user->is($user));
    }
}
