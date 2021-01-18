<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\IMailgunService;

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
