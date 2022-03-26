<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractDocumentSubmission extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_submitted',
        'is_approved',
        'due_date',
        'award_letter_id',
        'url_token',
        'access_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_submitted' => 'boolean',
        'is_approved' => 'boolean',
        'due_date' => 'date',
        'award_letter_id' => 'integer',
    ];

    public function contractDocumentSubmissionEntries()
    {
        return $this->hasMany(ContractDocumentSubmissionEntry::class);
    }

    public function awardLetter()
    {
        return $this->belongsTo(AwardLetter::class);
    }
}
