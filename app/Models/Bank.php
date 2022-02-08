<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['contractorAffliates'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        // 'created_by',
        // 'modified_by',
        'bank_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        // 'created_by' => 'integer',
        // 'modified_by' => 'integer',
    ];

    public function contractorAffliates()
    {
        return $this->hasMany(ContractorAffliate::class);
    }
}
