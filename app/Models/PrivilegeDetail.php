<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivilegeDetail extends Model
{
    use HasFactory, SoftDeletes;
    // protected $with = ['privilegeClass', 'user', 'privilege'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege_class_id',
        'user_id',
        'privilege_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'privilege_class_id' => 'integer',
        'user_id' => 'integer',
        'privilege_id' => 'integer',
    ];

    public function privilegeClass()
    {
        return $this->belongsTo(PrivilegeClass::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function privilege()
    {
        return $this->belongsTo(Privilege::class);
    }    
}
