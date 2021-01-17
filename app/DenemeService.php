<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\Repositories\IDenemeRepository;
use App\Interfaces\Services\IDenemeService;

class DenemeService implements IDenemeService
{
    /**
     * @var IDenemeRepository
     */
    private $denemeRepository;

    /**
     * @param IDenemeRepository $denemeRepository
     */
    public function __construct(IDenemeRepository $denemeRepository)
    {
        $this->denemeRepository = $denemeRepository;
    }
}
