<?php

namespace App\Models;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'filters' => 'array',
        'fields' => 'array',
        'format' => ReportFormat::class,
        'status' => ReportStatus::class,
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
