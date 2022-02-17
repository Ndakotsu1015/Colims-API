<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['parentMenu', 'module'];

    // protected $with = ['parent', 'module'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'link',
        'order',
        'is_active',
        'icon',
        'parent_id',
        'module_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'parent_id' => 'integer',
        'module_id' => 'integer',
    ];

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }    
}
