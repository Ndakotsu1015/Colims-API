<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseRequestMovement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_request_id',
        'user_id',
        'forward_to',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'case_request_id' => 'integer',
        'user_id' => 'integer',
        'forward_to' => 'integer',
    ];

    public function caseRequest()
    {
        return $this->belongsTo(CaseRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forwardTo()
    {
        return $this->belongsTo(User::class, 'forward_to');
    }
}
