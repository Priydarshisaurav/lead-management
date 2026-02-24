<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'source',
        'stage',
        'assigned_to',
        'expected_value',
        'remarks',
        'lost_reason',
        'created_by'
    ];

    public static function stages()
{
    return [
        'New',
        'Contacted',
        'Requirement',
        'Negotiation',
        'Won',
        'Lost'
    ];
}


    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'lead_id');
    }
    public function quotation()
    {
        return $this->hasOne(\App\Models\Quotation::class);
    }



    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
