<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourtCase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'case_no',
        'status',
        'handler_id',
        'posted_by',
        'case_status_id',
        'case_outcome_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'handler_id' => 'integer',
        'posted_by' => 'integer',
        'case_status_id' => 'integer',
        'case_outcome_id' => 'integer',
    ];

    public function suitParties()
    {
        return $this->hasMany(SuitParty::class);
    }

    public function legalDocuments()
    {
        return $this->hasMany(LegalDocument::class);
    }

    public function caseActivities()
    {
        return $this->hasMany(CaseActivity::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function caseStatus()
    {
        return $this->belongsTo(CaseStatus::class, 'case_status_id');
    }

    public function caseOutcome()
    {
        return $this->belongsTo(CaseOutcome::class, 'case_outcome_id');
    }
}
