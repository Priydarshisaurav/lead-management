<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
    'lead_id','product_name','quantity','rate',
    'gst_percentage','subtotal','gst_amount',
    'total_amount','valid_till','status'
];

public function lead()
{
    return $this->belongsTo(Lead::class, 'lead_id');
}

        // public function lead()
        // {
        //     return $this->belongsTo(Lead::class);
        // }

     // Auto-calculate totals before saving 
    public static function boot() {
        parent::boot();

        static::saving(function ($quotation) {
            $quotation->subtotal = $quotation->quantity * $quotation->rate;
            $quotation->gst_amount = ($quotation->subtotal * $quotation->gst_percentage) / 100;
            $quotation->total_amount = $quotation->subtotal + $quotation->gst_amount;
        });
    }

}
