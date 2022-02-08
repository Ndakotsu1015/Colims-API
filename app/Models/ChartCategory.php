<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartCategory extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['chartTypes', 'dashboardSettings', 'chartProvider'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chart_category',
        'chart_provider_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'chart_provider_id' => 'integer',
    ];

    public function chartTypes()
    {
        return $this->hasMany(ChartType::class);
    }

    public function dashboardSettings()
    {
        return $this->hasMany(DashboardSetting::class);
    }

    public function chartProvider()
    {
        return $this->belongsTo(ChartProvider::class);
    }
}
