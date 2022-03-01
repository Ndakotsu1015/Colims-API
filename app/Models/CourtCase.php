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
        'handler_id',
        'posted_by',
        'case_status_id',        
        'solicitor_id',
        'case_request_id',
        'is_case_closed',
        'court_pronouncement',
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
        'solicitor_id' => 'integer',
        'case_request_id' => 'integer',
        'is_case_closed' => 'boolean',        
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
    
    public function solicitor()
    {
        return $this->belongsTo(Solicitor::class);
    }

    public function caseRequest()
    {
        return $this->belongsTo(CaseRequest::class);
    }
}
