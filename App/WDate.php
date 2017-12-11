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
            $this->setYear($date[2])
                ->setMonth($date[1])
                ->setDay($date[0]);
        } elseif ($countDate === 2) {
            if (strlen($date[1]) > 2) {
                $this->setYear($date[1])
                    ->setMonth($date[0]);
            } else {
                $this->setDay($date[0])
                    ->setMonth($date[1]);
            }
        } else {
            if (!empty($date[0])) {
                if (strlen($date[0]) > 2) {
                    $this->setYear($date[0]);
                } else {
                    $this->setDay($date[0]);
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
        $this->setHour($time[0])
            ->setMinute($time[1])
            ->setSecond($time[2]);
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
     * @return int  -1  поданая дата больше текущей
     *              1   текущая дата больше поданой
     *              0   даты равны
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
     * @throws \App\WDateException
     */
    public function setYear($year)
    {
        if (empty($year)) {
            $year = null;
        }
        if (!is_null($year)) {
            $year = (int)$year;
            if ($year < 0) {
                throw new WDateException('Год не может быть отрицательным');
            }
            if (!is_null($this->day)) {
                $this->checkDay($this->day);
            }
        }
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
     * @throws \App\WDateException
     */
    public function setMonth($month)
    {
        if (empty($month)) {
            $month = null;
        }
        if (!is_null($month)) {
            $month = (int)$month;
            if ($month <= 0) {
                throw new WDateException('Месяц не может быть отрицательным и равным нулю');
            }
            if ($month > 12) {
                throw new WDateException('Месяц не может быть больше 12');
            }
            if (!is_null($this->day)) {
                $this->checkDay($this->day);
            }
        }
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
     * Проверка дня месяца
     * @param int $day
     * @throws \App\WDateException
     */
    private function checkDay($day)
    {
        switch ($this->month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
            default:
                if ($day > 31) {
                    throw new WDateException("Дней в {$this->month} месяце не может быть больше 31");
                }
                break;
            case 2:
                if (!$this->year) {
                    if ($day > 29) {
                        throw new WDateException("Дней в феврале не может быть больше 29");
                    }
                } else {
                    if ($this->year % 4 === 0) {
                        if ($day > 29) {
                            throw new WDateException("Дней в феврале,{$this->year} не может быть больше 29");
                        }
                    } else {
                        if ($day > 28) {
                            throw new WDateException("Дней в феврале,{$this->year} не может быть больше 28");
                        }
                    }
                }
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                if ($day > 30) {
                    throw new WDateException("Дней в {$this->month} месяце не может быть больше 30");
                }
                break;
        }
    }

    /**
     * @param int|null $day
     * @return \App\WDate
     * @throws \App\WDateException
     */
    public function setDay($day)
    {
        if (empty($day)) {
            $day = null;
        }
        if (!is_null($day)) {
            $day = (int)$day;
            if ($day <= 0) {
                throw new WDateException('День не может быть отрицательным и равным нулю');
            }
            $this->checkDay($day);
        }
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
     * @throws \App\WDateException
     */
    public function setHour($hour)
    {
        if (empty($hour)) {
            $hour = null;
        }
        if (!is_null($hour)) {
            $hour = (int)$hour;
            if ($hour < 0) {
                throw new WDateException('Час не может быть отрицательным');
            }
            if ($hour > 23) {
                throw new WDateException('Часов не может быть больше 23');
            }
        }
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
     * @throws \App\WDateException
     */
    public function setMinute($minute)
    {
        if (empty($minute)) {
            $minute = null;
        }
        if (!is_null($minute)) {
            $minute = (int)$minute;
            if ($minute < 0) {
                throw new WDateException('Минута не может быть отрицательной');
            }
            if ($minute > 59) {
                throw new WDateException('Минута не может быть больше 59');
            }
        }
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
     * @throws \App\WDateException
     */
    public function setSecond($second)
    {
        if (empty($second)) {
            $second = null;
        }
        if (!is_null($second)) {
            $second = (int)$second;
            if ($second < 0) {
                throw new WDateException('Секунда не может быть отрицательной');
            }
            if ($second > 59) {
                throw new WDateException('Секунда не может быть больше 59');
            }
        }
        $this->second = $second;
        return $this;
    }
}
