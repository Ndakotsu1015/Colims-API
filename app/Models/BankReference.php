<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankReference extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['awardLetter', 'affiliate', 'awardLetter.contractor', 'awardLetter.state'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_date',
        'reference_no',
        'created_by',
        'in_name_of',
        'affiliate_id',
        'award_letter_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reference_date' => 'datetime',
        'reference_no' => 'integer',
        'created_by' => 'integer',
        'affiliate_id' => 'integer',
        'award_letter_id' => 'integer',
    ];

    public function awardLetter()
    {
        return $this->belongsTo(AwardLetter::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(ContractorAffliate::class, 'affiliate_id');
    }
}
