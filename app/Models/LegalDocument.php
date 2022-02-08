<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalDocument extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['user', 'courtCase', 'documentType'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'filename',
        'user_id',
        'court_case_id',
        'document_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'court_case_id' => 'integer',
        'document_type_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courtCase()
    {
        return $this->belongsTo(CourtCase::class);
    }

    public function documentType()
    {
        return $this->belongsTo(LegalDocumentType::class, 'document_type_id');
    }    
}
