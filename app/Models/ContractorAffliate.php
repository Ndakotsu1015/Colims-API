<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractorAffliate extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['bank', 'contractor'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'account_no',
        'account_officer',
        'account_officer_email',
        'bank_address',
        'sort_code',
        'bank_id',
        'contractor_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'contractor_id' => 'integer',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
