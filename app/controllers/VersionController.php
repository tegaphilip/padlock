<?php

namespace App\Controllers;

use Phalcon\Config;

/**
 * Class VersionController
 * @property Config config
 * @package App\Controllers
 */
class VersionController extends BaseController
{
    public function index()
    {
        $data = "Welcome to " . $this->config->appParams->appName . " V" . $this->config->appParams->appVersion;
        return $this->response->sendSuccess($data);
    }
}
