<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardLetter extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        'contract_sum',            
        'date_awarded',
        'last_bank_ref_date',
        'reference_no',        
        'contractor_id',
        'contract_type_id',
        // 'project_location',
        'project_id',
        'approved_by',
        'contract_title',
        // 'contract_detail',
        'duration_id',
        // 'contract_category_id',
        'commencement_date',
        'due_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',        
        'contract_sum' => 'float',            
        'date_awarded' => 'date', 
        'last_bank_ref_date' => 'date',        
        'contractor_id' => 'integer',
        'contract_type_id' => 'integer',        
        'project_id' => 'integer',
        'approved_by' => 'integer',
        'duration_id' => 'integer',
        // 'contract_category_id' => 'integer',
        'commencement_date' => 'date',
        'due_date' => 'date',        
    ];

    public function bankReferences()
    {
        return $this->hasMany(BankReference::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }

    // public function contractCategory()
    // {
    //     return $this->belongsTo(ContractCategory::class);
    // }

    public function approvedBy()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function internalDocuments()
    {
        return $this->hasMany(AwardLetterInternalDocument::class);
    }

    public function contractDocumentSubmissions()
    {
        return $this->hasMany(ContractDocumentSubmission::class);
    }
}
