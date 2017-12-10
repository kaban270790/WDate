<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 010 10.12
 * Time: 15:24:21
 */

class WDateTest extends PHPUnit\Framework\TestCase
{
    public function test()
    {
        $arTest = [
            [
                'date'       => '01:00:05 21.07.2017',
                'formatIn'   => 'HH:II:SS DD.MM.YYYY',
                'resultDate' => '01:00:05 21.07.2017',
            ],
            [
                'date'       => '01:05 21.07.2017',
                'formatIn'   => 'HH:II DD.MM.YYYY',
                'resultDate' => '01:05 21.07.2017',
            ],
            [
                'date'       => '01: 21.07.2017',
                'formatIn'   => 'HH: DD.MM.YYYY',
                'resultDate' => '01: 21.07.2017',
            ],
            [
                'date'       => '21.07.2017',
                'formatIn'   => 'DD.MM.YYYY',
                'resultDate' => '21.07.2017',
            ],
            [
                'date'       => '07.2017',
                'formatIn'   => 'MM.YYYY',
                'resultDate' => '07.2017',
            ],
            [
                'date'       => '2017',
                'formatIn'   => 'YYYY',
                'resultDate' => '2017',
            ],
            [
                'date'       => '01:',
                'formatIn'   => 'HH:',
                'resultDate' => '01:',
            ],
            [
                'date'       => '01:05',
                'formatIn'   => 'HH:II',
                'resultDate' => '01:05',
            ],
            [
                'date'       => '01:05:17',
                'formatIn'   => 'HH:II:SS',
                'resultDate' => '01:05:17',
            ],
        ];
        foreach ($arTest as $item) {
            $date = new \App\WDate($item['date'], $item['formatIn']);
            $this->assertEquals($date->format(), $item['resultDate'], $item['resultDate']);
        }
    }
}
