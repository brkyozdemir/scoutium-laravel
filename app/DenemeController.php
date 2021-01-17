<?php

declare(strict_types=1);

namespace App;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\IDenemeService;

class DenemeController extends Controller
{
    /**
     * @var IDenemeService
     */
    private $denemeService;

    /**
     * @param IDenemeService $denemeService
     */
    public function __construct(IDenemeService $denemeService)
    {
        $this->denemeService = $denemeService;
    }
}
