<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartType extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['chartCategory', 'dashboardSettings'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chart_type',
        'chart_category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'chart_category_id' => 'integer',
    ];

    public function dashboardSettings()
    {
        return $this->hasMany(DashboardSetting::class);
    }

    public function chartCategory()
    {
        return $this->belongsTo(ChartCategory::class);
    }
}
