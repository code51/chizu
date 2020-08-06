<?php

namespace Chizu\Controllers\Apis;

use Chizu\Context;
use Chizu\Controllers\BaseController;
use Chizu\KanjiProfileRepository;

/**
 * Class KanjisApiController
 * @package Chizu\Controllers\Apis
 * @path /kanjis
 */
class KanjisApiController extends BaseController
{
    /**
     * @path /
     */
    public function get(KanjiProfileRepository $repo)
    {
        return $repo->getAll();
    }

    /**
     * @path /rtks
     */
    public function getRtks(KanjiProfileRepository $repository)
    {
        return $repository->getRtkKanjis();
    }

    /**
     * @path /
     */
    public function post(KanjiProfileRepository $repository, Context $context)
    {
        $repository->add($context->param('kanji'));
    }

    public function groupKanji()
    {
        return KanjiApiController::class;
    }
}