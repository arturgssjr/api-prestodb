<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Presto\Client as PrestoClient;

class ApiBigDataBaseController extends Controller
{
    private $prestoClient;

    public function __construct()
    {
        $this->prestoClient = new PrestoClient();
    }

    public function getPrestoClient(): PrestoClient
    {
        return $this->prestoClient;
    }
}
