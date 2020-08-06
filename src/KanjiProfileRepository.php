<?php

namespace Chizu;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class KanjiProfileRepository
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var array
     */
    private $rtks;

    public function __construct(Filesystem $filesystem, array $rtks)
    {
        $this->filesystem = $filesystem;
        $this->rtks = $rtks;
    }

    public static function createForProfile($baseDir, $profile)
    {
        return new static(new Filesystem(new Local($baseDir . '/' . $profile)), explode(' ', file_get_contents($baseDir . '/rtk2000.txt')));
    }

    public function getRtkKanjis()
    {
        return $this->rtks;
    }

    public function getAll()
    {
        if (!$this->filesystem->has('kanjis.json'))
            return [];

        return json_decode($this->filesystem->read('kanjis.json'), true);
    }

    public function persistAll(array $kanjis)
    {
        $this->filesystem->put('kanjis.json', json_encode($kanjis));
    }

    public function set($kanji, $field, $value)
    {
        $kanjis = $this->getAll();

        if ((strlen($kanji) == strlen(utf8_decode($kanji)))) {
           return;
        }

//        if (!in_array($kanji, $this->rtks)) {
//
////            var_dump($kanji);
////            var_dump($this->rtks);
//
//            return;
//        }


        if (!isset($kanjis[$kanji]))
            $kanjis[$kanji] = [
                'symbol' => $kanji,
                'relations' => [],
                'story' => ''
            ];

        $kanjis[$kanji][$field] = $value;

        $this->persistAll($kanjis);
    }

    /**
     * @param $kanji
     * @param array $kanjis
     */
    public function relate($kanji, $kanjis = [])
    {
        $kanji = $this->get($kanji);

        $this->set($kanji, 'relations', $kanjis);
    }

    /**
     * @param $kanji
     * @return array|mixed
     */
    public function get($kanji)
    {
        $kanjis = $this->getAll();

        if (!isset($kanjis[$kanji]))
            return [
                'symbol' => $kanji,
                'relations' => [],
                'story' => ''
            ];

        return $kanjis[$kanji];
    }

    public function add($kanji)
    {
        $kanji = urldecode($kanji);

        $this->set($kanji, 'symbol', $kanji);
    }
}