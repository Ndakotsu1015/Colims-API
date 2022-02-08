<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseActivity extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['case', 'suitParties', 'courtCase', 'user', 'caseOutcome'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'court_case_id',
        'user_id',
        'case_outcome_id',
        'status',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'court_case_id' => 'integer',
        'user_id' => 'integer',
        'case_outcome_id' => 'integer',
    ];

    public function suitParties()
    {
        return $this->hasMany(SuitParty::class);
    }

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caseOutcome()
    {
        return $this->belongsTo(CaseOutcome::class);
    }
}
