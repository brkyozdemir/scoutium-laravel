<?php


namespace App\Services;

use App\Interfaces\Repositories\IMailgunRepository;
use App\Interfaces\Services\IMailgunService;

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
