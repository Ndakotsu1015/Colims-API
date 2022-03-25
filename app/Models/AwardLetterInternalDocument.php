<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardLetterInternalDocument extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'filename',
        'award_letter_id',
        'posted_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'award_letter_id' => 'integer',
        'posted_by' => 'integer'
    ];

    public function awardLetter()
    {
        return $this->belongsTo(AwardLetter::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
