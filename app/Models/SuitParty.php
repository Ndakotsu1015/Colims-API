<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuitParty extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['courtCase'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        'court_case_id',
        'case_participant_id',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'court_case_id' => 'integer',
        'case_participant_id' => 'integer',
    ];

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class);
    }

    public function caseParticipant()
    {
        return $this->belongsTo(CaseParticipant::class);
    }
}
