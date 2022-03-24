<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseDraft extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = [
        'handler', 'solicitor',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_no',
        'title',
        'dls_approved',
        'review_submitted',
        'review_comment',
        'handler_id',
        'solicitor_id',
        'case_request_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dls_approved' => 'boolean',
        'review_submitted' => 'boolean',
        'handler_id' => 'integer',
        'solicitor_id' => 'integer',
        'case_request_id' => 'integer',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class);
    }

    public function solicitor()
    {
        return $this->belongsTo(Solicitor::class);
    }

    public function caseRequest()
    {
        return $this->belongsTo(CaseRequest::class);
    }

    public function suitParties()
    {
        return $this->hasMany(CaseDraftSuitParty::class);
    }
}
