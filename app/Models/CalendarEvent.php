<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'location',
        'start_time',
        'end_time',
        'posted_by',
        'court_case_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'posted_by' => 'integer',
        'court_case_id' => 'integer',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class);
    }
}
