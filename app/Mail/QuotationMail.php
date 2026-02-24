<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Quotation;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $pdfContent;

    public function __construct(Quotation $quotation, $pdfContent)
    {
        $this->quotation = $quotation;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Your Quotation')
                    ->view('emails.quotation')
                    ->attachData(
                        $this->pdfContent,
                        'quotation-'.$this->quotation->id.'.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
