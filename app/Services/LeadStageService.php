<?php

namespace App\Services;

use App\Models\Lead;

class LeadStageService
{
    public static $stages = [
        'New Lead',
        'Contacted',
        'Requirement Received',
        'Quotation Sent',
        'Negotiation',
        'Won',
        'Lost'
    ];

    public static function canMove(Lead $lead, $newStage)
    {
        // Stage must exist
        if (!in_array($newStage, self::$stages)) {
            return false;
        }

        // Final stages cannot change
      if ($newStage === 'Won') {
    $quotation = $lead->quotation()->first();

    if (!$quotation || $quotation->status !== 'Accepted') {
        return false;
    }
}


        $currentIndex = array_search($lead->stage, self::$stages);
        $newIndex = array_search($newStage, self::$stages);

        // LOST can be moved anytime (except from final stage handled above)
        if ($newStage === 'Lost') {
            return true;
        }

        // Must move sequentially (next only)
        if ($newIndex !== $currentIndex + 1) {
            return false;
        }

        // Quotation must exist before Quotation Sent
        if ($newStage === 'Quotation Sent' && !$lead->quotation) {
            return false;
        }

        // Quotation must be Accepted before Won
        if ($newStage === 'Won') {
            if (!$lead->quotation || $lead->quotation->status !== 'Accepted') {
                return false;
            }
        }

        return true;
    }
}
