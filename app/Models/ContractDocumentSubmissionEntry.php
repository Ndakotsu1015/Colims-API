<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractDocumentSubmissionEntry extends Model
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
        'is_approved',
        'entry_id',
        'document_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_approved' => 'boolean',
        'entry_id' => 'integer',
        'document_type_id' => 'integer',
    ];

    public function entry()
    {
        return $this->belongsTo(ContractDocumentSubmission::class);
    }

    public function contractDocumentType()
    {
        return $this->belongsTo(ContractDocumentType::class, 'document_type_id');
    }
}
