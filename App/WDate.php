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
    private $day;
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


    public function __construct($date)
    {
        $this->parse($date);
    }

    /**
     * Парсинг даты
     * @param $date - дата
     * @return $this
     */
    public function parse($date)
    {
        $posPoint = strpos($date, '.');
        $posColon = strpos($date, ':');
        if ($posPoint !== false && $posColon !== false) {
            $date = explode(' ', $date);
            if ($posPoint > $posColon) {
                $this->parseTime($date[0])->parseDate($date[1]);
            } else {
                $this->parseTime($date[1])->parseDate($date[0]);
            }
        } elseif ($posColon !== false) {
            $this->parseTime($date);
        } else {
            $this->parseDate($date);
        }

        return $this;
    }

    /**
     * Парсинг даты
     * @param string $date
     * @return $this
     * @throws \App\WDateException
     */
    private function parseDate($date)
    {
        $date = explode('.', $date);
        $countDate = count($date);
        if ($countDate === 3) {
            if (!empty($date[1])) {
                if ((int)$date[1] > 12) {
                    throw new WDateException('Месяц не может быть больше 12');
                }
                $this->month = (int)$date[1];
            }
            if (!empty($date[2])) {
                $this->year = (int)$date[2];
            }
            if (!empty($date[0])) {
                switch ($this->month) {
                    case 1:
                    case 3:
                    case 5:
                    case 7:
                    case 8:
                    case 10:
                    case 12:
                    default:
                        if ((int)$date[0] > 31) {
                            throw new WDateException("Дней в {$this->month} месяце не может быть больше 31");
                        }
                        break;
                    case 2:
                        if (!$this->year) {
                            if ((int)$date[0] > 29) {
                                throw new WDateException("Дней в феврале не может быть больше 29");
                            }
                        } else {
                            if ($this->year % 4 === 0) {
                                if ((int)$date[0] > 29) {
                                    throw new WDateException("Дней в феврале,{$this->year} не может быть больше 29");
                                }
                            } else {
                                if ((int)$date[0] > 28) {
                                    throw new WDateException("Дней в феврале,{$this->year} не может быть больше 28");
                                }
                            }
                        }
                        break;
                    case 4:
                    case 6:
                    case 9:
                    case 11:
                        if ((int)$date[0] > 30) {
                            throw new WDateException("Дней в {$this->month} месяце не может быть больше 30");
                        }
                        break;
                }
                $this->day = (int)$date[0];
            }
        } elseif ($countDate === 2) {
            if (strlen($date[1]) > 2) {
                if (!empty($date[0])) {
                    $this->month = (int)$date[0];
                }
                if (!empty($date[1])) {
                    $this->year = (int)$date[1];
                }
            } else {
                if (!empty($date[0])) {
                    $this->day = (int)$date[0];
                }
                if (!empty($date[1])) {
                    $this->month = (int)$date[1];
                }
            }
        } else {
            if (!empty($date[0])) {
                if (strlen($date[1]) > 2) {
                    $this->year = (int)$date[0];
                } else {
                    $this->day = (int)$date[0];
                }
            }
        }
        return $this;
    }

    /**
     * Парсинг времени
     * @param string $time строка со временем
     * @return $this
     * @throws \App\WDateException
     */
    private function parseTime($time)
    {
        $time = explode(':', $time);
        if (!empty($time[0])) {
            if ((int)$time[0] > 23) {
                throw new WDateException('Часов не может быть больше 23');
            }
            $this->hour = (int)$time[0];
        }
        if (!empty($time[1])) {
            if ((int)$time[1] > 59) {
                throw new WDateException('Минут не может быть больше 59');
            }
            $this->minute = (int)$time[1];
        }
        if (!empty($time[2])) {
            if ((int)$time[2] > 59) {
                throw new WDateException('Секунд не может быть больше 59');
            }
            $this->second = (int)$time[2];
        }
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
        if (!is_null($this->day)) {
            if (!empty($result)) {
                $result .= ' ';
            }
            $result .= $this->addZero($this->day);
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

    /**
     * Сравниваем текущую дату с поданой
     * @param \App\WDate $diff
     * @return int  -1  поданая дата больше текущей
     *              1   текущая дата больше поданой
     *              0   даты равны
     */
    public function diff(WDate $diff)
    {
        $result = $this->diffInt($this->year, $diff->getYear());
        if ($result !== 0) {
            return $result;
        }
        $result = $this->diffInt($this->month, $diff->getMonth());
        if ($result !== 0) {
            return $result;
        }
        $result = $this->diffInt($this->day, $diff->getDay());
        if ($result !== 0) {
            return $result;
        }
        $result = $this->diffInt($this->hour, $diff->getHour());
        if ($result !== 0) {
            return $result;
        }
        $result = $this->diffInt($this->minute, $diff->getMinute());
        if ($result !== 0) {
            return $result;
        }
        $result = $this->diffInt($this->second, $diff->getSecond());
        return $result;
    }

    /**
     * Сравнение чисел для сравнения даты
     * @param int|null $current
     * @param int|null $diff
     * @return int
     */
    private function diffInt($current, $diff)
    {
        if (!is_null($current) && !is_null($diff)) {
            if ($current != $diff) {
                return $current > $diff ? 1 : -1;
            }
        }
        return 0;
    }

    /**
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     * @return \App\WDate
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     * @return \App\WDate
     */
    public function setMonth($month)
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int|null $day
     * @return \App\WDate
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param int|null $hour
     * @return \App\WDate
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param int|null $minute
     * @return \App\WDate
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @param int|null $second
     * @return \App\WDate
     */
    public function setSecond($second): self
    {
        $this->second = $second;
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
}
