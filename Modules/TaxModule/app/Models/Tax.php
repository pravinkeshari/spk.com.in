<?php

namespace Modules\TaxModule\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Tax extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_default' => 'integer',
        'is_active' => 'integer',
        'tax_rate' => 'float',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function ($model) {
            \Modules\TaxModule\app\Services\SystemTaxSetupService::clearTaxSystemTypeCache();
        });

        static::deleted(function ($model) {
            \Modules\TaxModule\app\Services\SystemTaxSetupService::clearTaxSystemTypeCache();
        });
    }

}
