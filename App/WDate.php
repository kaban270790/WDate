<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 010 10.12
 * Time: 15:23:25
 */

namespace App;

class WDate
{
    /**
     * @var int|null число даты от начала месяца
     */
    private $date;
    /**
     * @var int|null число месяца от начала года
     */
    private $month;
    /**
     * @var int|null номер года от рождества Христово :)
     */
    private $year;
    /**
     * @var int|null час от начала суток
     */
    private $hour;
    /**
     * @var int|null минут от начала часа
     */
    private $minute;
    /**
     * @var int|null секунд от начала минуты
     */
    private $second;


    public function __construct($date, $format = 'HH:II:SS DD.MM.YYYY')
    {
        $this->parse($date, $format);
    }

    /**
     * Парсинг даты
     * @param $date - дата
     * @param string $format - формат
     * @return $this
     */
    public function parse($date, $format = 'HH:II:SS DD.MM.YYYY')
    {
        $format = str_split(strtoupper($format));
        $this->hour = $this->parseValue('H', $date, $format);
        $this->minute = $this->parseValue('I', $date, $format);
        $this->second = $this->parseValue('S', $date, $format);
        $this->date = $this->parseValue('D', $date, $format);
        $this->month = $this->parseValue('M', $date, $format);
        $this->year = $this->parseValue('Y', $date, $format);
        return $this;
    }

    /**
     * @param string $code - код который вытаскиваем. H - час, I - минута, S - секунда, D - день, M - месяц, Y - год
     * @param string $date - текущая дата
     * @param array $format формат разбитый на массив
     * @return null|int
     */
    private function parseValue($code, $date, array $format)
    {
        $pos = null;
        $count = null;
        for ($i = 0, $l = count($format); $i < $l; $i++) {
            if ($format[$i] === $code) {
                if (is_null($pos)) {
                    $pos = $i;
                }
                $count++;
            } else {
                if (!is_null($pos)) {
                    break;
                }
            }
        }
        if (is_null($pos)) {
            return null;
        }
        $result = substr($date, $pos, $count);
        if ($result === false) {
            return null;
        }
        return (int)$result;
    }

    /**
     * @return int|null
     */
    public function getDate(): ?int
    {
        return $this->date;
    }

    /**
     * @param int|null $date
     * @return \App\WDate
     */
    public function setDate(?int $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMonth(): ?int
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     * @return \App\WDate
     */
    public function setMonth(?int $month): self
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     * @return \App\WDate
     */
    public function setYear(?int $year): self
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHour(): ?int
    {
        return $this->hour;
    }

    /**
     * @param int|null $hour
     * @return \App\WDate
     */
    public function setHour(?int $hour): self
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinute(): ?int
    {
        return $this->minute;
    }

    /**
     * @param int|null $minute
     * @return \App\WDate
     */
    public function setMinute(?int $minute): self
    {
        $this->minute = $minute;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecond(): ?int
    {
        return $this->second;
    }

    /**
     * @param int|null $second
     * @return \App\WDate
     */
    public function setSecond(?int $second): self
    {
        $this->second = $second;
        return $this;
    }

    /**
     * Получение полной даты
     * @return string
     */
    public function format()
    {
        $result = '';
        if (!is_null($this->hour)) {
            $result .= $this->addZero($this->hour);
            $result .= ':';
        }
        if (!is_null($this->minute)) {
            $result .= $this->addZero($this->minute);
        }
        if (!is_null($this->second)) {
            $result .= ':';
            $result .= $this->addZero($this->second);
        }
        if (!is_null($this->date)) {
            if (!empty($result)) {
                $result .= ' ';
            }
            $result .= $this->addZero($this->date);
        }
        if (!is_null($this->month)) {
            if (!empty($result)) {
                $result .= '.';
            }
            $result .= $this->addZero($this->month);
        }
        if (!is_null($this->year)) {
            if (!empty($result)) {
                $result .= '.';
            }
            $result .= $this->year;
        }

        return $result;
    }

    /**
     * @param string|int $str строка, число которое увеличиваем
     * @param int $length до какой длинны увеличиваем
     * @return string
     */
    private function addZero($str = '', $length = 2)
    {
        return str_pad($str, $length, '0', STR_PAD_LEFT);
    }


}
