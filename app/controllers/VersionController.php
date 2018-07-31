<?php

namespace App\Controller;

use Phalcon\Config;

/**
 * Class VersionController
 * @property Config config
 * @package App\Controller
 */
class VersionController extends BaseController
{
    public function index()
    {
        $data = "Welcome to " . $this->config->appParams->appName . " V" . $this->config->appParams->appVersion;
        return $this->response->sendSuccess($data);
    }
}
