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
        'no_units',
        'no_rooms',
        'date_awarded',
        'reference_no',
        'award_no',
        'volume_no',
        'contractor_id',
        'property_type_id',
        'state_id',
        'project_id',
        'posted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_price' => 'float',
        'no_units' => 'integer',
        'no_rooms' => 'integer',
        'date_awarded' => 'date',
        'award_no' => 'integer',
        'volume_no' => 'integer',
        'contractor_id' => 'integer',
        'property_type_id' => 'integer',
        'state_id' => 'integer',
        'project_id' => 'integer',
        'posted_by' => 'integer',
    ];

    public function bankReferences()
    {
        return $this->hasMany(BankReference::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
