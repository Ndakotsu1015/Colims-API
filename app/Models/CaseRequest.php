<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',        
        'memo_file',
        'initiator_id',
        'case_reviewer_id',
        'status',
        'recommendation_note',
        'should_go_to_trial',
        'is_case_closed',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'initiator_id' => 'integer',
        'case_reviewer_id' => 'integer',
        'should_go_to_trial' => 'boolean',
        'is_case_closed' => 'boolean',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function caseReviewer()
    {
        return $this->belongsTo(User::class, 'case_reviewer_id');
    }
}
