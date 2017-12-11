<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 010 10.12
 * Time: 15:24:21
 */

class WDateTest extends PHPUnit\Framework\TestCase
{
    public function testInit()
    {
        $arTest = [
            '01:00:05 21.07.2017',
            '01:05 21.07.2017',
            '01: 21.07.2017',
            '21.07.2017',
            '07.2017',
            '2017',
            '01:',
            '01:05',
            '01:05:17',
        ];
        foreach ($arTest as $item) {
            $date = new \App\WDate($item);
            $this->assertEquals($date->format(), $item, $item);
        }
    }

    public function testDiff()
    {

        $arTest = [
            '01:01:05 21.07.2017' => [
                '01:01:05 21.07.2017' => 0,
                '01:01:05 21.07.2016' => 1,
                '01:01:05 20.06.2017' => 1,
                '01:01:05 20.07.2017' => 1,
                '01:01:04 21.07.2017' => 1,
                '00:01:05 21.07.2017' => 1,
                '01:01:05 21.07.2018' => -1,
                '01:01:05 21.08.2017' => -1,
                '01:01:05 22.07.2017' => -1,
                '01:01:06 21.07.2017' => -1,
                '01:02:05 21.07.2017' => -1,
                '02:01:05 21.07.2017' => -1,
            ],
            '27.07' => [
                '27.07'      => 0,
                '28.07'      => -1,
                '27.08'      => -1,
                '26.07'      => 1,
                '27.06'      => 1,
                '27.06.2017' => 1,
            ],
            '10:02' => [
                '10:02' => 0,
                '10:01' => 1,
                '09:02' => 1,
                '11:02' => -1,
                '10:03' => -1,
            ],
        ];
        foreach ($arTest as $date => $dates) {
            $date = new App\WDate($date);
            foreach ($dates as $key => $value) {
                $diff = new \App\WDate($key);
                $this->assertEquals($date->diff($diff), $value, $diff->format() . ' ' . $date->format());
            }
        }
    }
}
