<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chart extends Model
{
    use HasFactory, SoftDeletes;
    
    // protected $with = ['dashboardSettings', 'module', 'chartType', 'chartCategory'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chart_title',
        'sql_query',
        'is_active',
        'module_id',
        'filter_column',
        'chart_type_id',
        'chart_category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'module_id' => 'integer',
        'chart_type_id' => 'integer',
        'chart_category_id' => 'integer',
    ];

    public function dashboardSettings()
    {
        return $this->hasMany(DashboardSetting::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function chartType()
    {
        return $this->belongsTo(ChartType::class);
    }

    public function chartCategory()
    {
        return $this->belongsTo(ChartCategory::class);
    }

}
