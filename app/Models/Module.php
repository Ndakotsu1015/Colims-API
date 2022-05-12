<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['dashboardSettings'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order_by',
        'active_id',
        'url',
        'created_by',
        'modified_by',
        'icon',
        'bg_class',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_by' => 'integer',
        'active_id' => 'integer',
        'created_by' => 'integer',
        'modified_by' => 'integer',
    ];

    public function dashboardSettings()
    {
        return $this->hasMany(DashboardSetting::class);
    } 
    
    public function menus()
    {
        return $this->hasMany(Menu::class)->orderBy('order');
    }
}
