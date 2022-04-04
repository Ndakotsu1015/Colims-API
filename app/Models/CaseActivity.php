<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseActivity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'court_case_id',
        'user_id',
        'solicitor_id',
        'case_status_id',
        'location',
        'court_pronouncement',
        'next_adjourned_date',
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
        'solicitor_id' => 'integer',
        'case_status_id' => 'integer',
        'next_adjourned_date' => 'date',
    ];

    public function caseActivitySuitParties()
    {
        return $this->hasMany(CaseActivitySuitParty::class);
    }

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function solicitor()
    {
        return $this->belongsTo(Solicitor::class);
    }

    public function caseStatus()
    {
        return $this->belongsTo(CaseStatus::class);
    }
}
