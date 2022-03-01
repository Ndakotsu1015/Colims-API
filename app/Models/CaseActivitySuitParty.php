<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseActivitySuitParty extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_activity_id',
        'suit_party_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'case_activity_id' => 'integer',
        'suit_party_id' => 'integer',
    ];

    public function caseActivity()
    {
        return $this->belongsTo(CaseActivity::class);
    }

    public function suitParty()
    {
        return $this->belongsTo(SuitParty::class);
    }
}
