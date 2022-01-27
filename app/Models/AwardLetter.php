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
        'unit_price',
        'contract_sum',
        'no_units',
        'no_rooms',
        'date_awarded',
        'reference_no',
        'award_no',
        'volume_no',
        'contractor_id',
        'contract_type_id',
        'state_id',
        'project_id',
        'approved_by',
        'contract_title',
        'contract_detail',
        'duration_id',
        'contract_category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_price' => 'float',
        'contract_sum' => 'float',
        'no_units' => 'integer',
        'no_rooms' => 'integer',
        'date_awarded' => 'date',
        'award_no' => 'integer',
        'volume_no' => 'integer',
        'contractor_id' => 'integer',
        'contract_type_id' => 'integer',
        'state_id' => 'integer',
        'project_id' => 'integer',
        'approved_by' => 'integer',
        'duration_id' => 'integer',
        'contract_category_id' => 'integer',
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
        return $this->belongsTo(contractType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }

    public function contractCategory()
    {
        return $this->belongsTo(ContractCategory::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
