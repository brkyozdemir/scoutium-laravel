<?php

declare(strict_types=1);

namespace App\Mail;

use App\Interfaces\Repositories\Mail\IMailgunRepository;
use App\Interfaces\Services\Mail\IMailgunService;

class MailgunService implements IMailgunService
{
    /**
     * @var IMailgunRepository
     */
    private $mailgunRepository;

    /**
     * @param IMailgunRepository $mailgunRepository
     */
    public function __construct(IMailgunRepository $mailgunRepository)
    {
        $this->mailgunRepository = $mailgunRepository;
    }
}
