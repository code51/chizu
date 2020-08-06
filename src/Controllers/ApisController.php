<?php

namespace Chizu\Controllers;

use Chizu\Context;
use Chizu\Controllers\Apis\KanjiProfileApiController;

/**
 * Class ApisController
 * @package Chizu\Controllers
 * @path /apis
 */
class ApisController extends BaseController
{
    public function middleware(Context $context)
    {
        $context->addParams($context->request->getParams());

        $response = $context->next($context);

        if (is_array($response))
            return json_encode(['data' => $response]);

        return json_encode(['data' => null]);
    }

    public function groupKanjiProfile()
    {
        return KanjiProfileApiController::class;
    }
}