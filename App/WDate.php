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

}
