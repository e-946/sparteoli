<?php

namespace Tests\Feature;

use App\Enums\ReportStatus;
use App\Jobs\GenerateOccurrenceReportJob;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/report'));
    }

    public function test_non_admin_cannot_view_the_index(): void
    {
        $this->actingAsUser();

        $this->get('/report')->assertForbidden();
    }

    public function test_non_admin_cannot_view_the_create_form(): void
    {
        $this->actingAsUser();

        $this->get('/report/create')->assertForbidden();
    }

    public function test_non_admin_cannot_request_a_report(): void
    {
        $this->actingAsUser();

        $this->post('/report/create', [
            'format' => 'csv',
            'fields' => ['date'],
        ])->assertForbidden();
    }

    public function test_admin_can_view_the_index(): void
    {
        $this->actingAsAdmin();
        Report::factory()->create();

        $this->get('/report')->assertOk();
    }

    public function test_admin_can_view_the_create_form(): void
    {
        $this->actingAsAdmin();

        $this->get('/report/create')->assertOk();
    }

    public function test_storing_a_report_requires_format_and_fields(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/report/create')->post('/report/create', []);

        $response->assertSessionHasErrors(['format', 'fields']);
    }

    public function test_storing_a_report_rejects_unknown_fields(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/report/create')->post('/report/create', [
            'format' => 'csv',
            'fields' => ['not_a_real_field'],
        ]);

        $response->assertSessionHasErrors(['fields.0']);
    }

    public function test_admin_can_request_a_report_and_it_dispatches_the_job(): void
    {
        Queue::fake();
        $admin = $this->actingAsAdmin();

        $response = $this->post('/report/create', [
            'format' => 'csv',
            'fields' => ['date', 'city'],
            'filters' => ['city' => 'Salvador'],
        ]);

        $response->assertRedirect(route('index-report'));

        $report = Report::sole();
        $this->assertSame($admin->id, $report->user_id);
        $this->assertSame(ReportStatus::Pending, $report->status);
        $this->assertSame(['date', 'city'], $report->fields);
        $this->assertSame(['city' => 'Salvador'], $report->filters);

        Queue::assertPushed(GenerateOccurrenceReportJob::class);
    }

    public function test_download_404s_when_report_is_not_completed(): void
    {
        $this->actingAsAdmin();
        $report = Report::factory()->create(['status' => ReportStatus::Processing->value]);

        $this->get("/report/{$report->id}/download")->assertNotFound();
    }

    public function test_download_streams_the_file_when_completed(): void
    {
        Storage::fake('reports');
        Storage::disk('reports')->put('occurrence-report-1.csv', 'id,city');

        $this->actingAsAdmin();
        $report = Report::factory()->create([
            'status' => ReportStatus::Completed->value,
            'file_path' => 'occurrence-report-1.csv',
        ]);

        $this->get("/report/{$report->id}/download")->assertOk();
    }
}
