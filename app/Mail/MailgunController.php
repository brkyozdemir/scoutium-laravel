<?php

declare(strict_types=1);

namespace App\Mail;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\Mail\IMailgunService;

class MailgunController extends Controller
{
    /**
     * @var IMailgunService
     */
    private $mailgunService;

    /**
     * @param IMailgunService $mailgunService
     */
    public function __construct(IMailgunService $mailgunService)
    {
        $this->mailgunService = $mailgunService;
    }
}
