<?php

namespace Chizu\Controllers;

use Chizu\Context;
use Twig\Environment;

class RootController extends BaseController
{
    /**
     * @path /
     */
    public function getIndex(Environment $twig)
    {
        return $twig->render('index.twig');
    }

    public function groupApis()
    {
        return ApisController::class;
    }
}