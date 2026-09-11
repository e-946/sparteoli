<?php

namespace Database\Factories;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'filters' => [],
            'fields' => ['date', 'city', 'requester'],
            'format' => $this->faker->randomElement(ReportFormat::cases())->value,
            'status' => ReportStatus::Pending->value,
            'file_path' => null,
            'error_message' => null,
            'completed_at' => null,
        ];
    }
}
