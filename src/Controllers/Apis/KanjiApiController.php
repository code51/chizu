<?php

namespace Chizu\Controllers\Apis;

use Chizu\Context;
use Chizu\Controllers\BaseController;
use Chizu\KanjiProfileRepository;

/**
 * Class KanjiApiController
 * @package Chizu\Controllers\Apis
 * @path /:kanji
 */
class KanjiApiController extends BaseController
{
    /**
     * @path /
     */
    public function get(KanjiProfileRepository $repository, Context $context)
    {
        return $repository->get($context->param('kanji'));
    }

    /**
     * @path /
     */
    public function post(KanjiProfileRepository $repository, Context $context)
    {
        $kanji = urldecode($context->param('kanji'));

        $repository->add($kanji);

        if ($context->hasParam('story')) {
            $repository->set($kanji, 'story', $context->param('story'));
        }

        if ($context->hasParam('relations'))
            $repository->relate($kanji, $context->param('relations'));
    }

    /**
     * @path /
     */
    public function postRelation(KanjiProfileRepository $repository, Context $context)
    {
        $repository->relate(urldecode($context->param('kanji')), $context->param('relations'));
    }
}