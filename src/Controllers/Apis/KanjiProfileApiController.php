<?php

namespace Chizu\Controllers\Apis;

use Chizu\Controllers\BaseController;
use Chizu\KanjiProfileRepository;
use Exedra\Routeller\Controller\Controller;
use Exedra\Runtime\Context;

/**
 * Class KanjiProfileApiController
 * @path /:profile-id
 */
class KanjiProfileApiController extends BaseController
{
    public function middleware(Context $context)
    {
        $context->instance(KanjiProfileRepository::class, KanjiProfileRepository::createForProfile($context->app->getRootDir() . '/storage', $context->param('profile-id')));

        return $context->next($context);
    }

    public function groupKanjis()
    {
        return KanjisApiController::class;
    }
}