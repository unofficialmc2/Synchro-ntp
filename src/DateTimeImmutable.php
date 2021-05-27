<?php


namespace SynchroNtp;

use DateTimeZone;

class DateTimeImmutable extends \DateTimeImmutable
{
    /**
     * DateTimeImmutable constructor.
     * Surcharge du constructeur pour créer un date time immutable à partir d'un serveur nts
     * @param string $datetime
     * @param DateTimeZone|null $timezone
     * @throws \Exception
     */
    public function __construct($datetime = "now", DateTimeZone $timezone = null)
    {
        if ($datetime === 'now') {
            $time = time();
            $datetime = date('c', $time);
        }
        parent::__construct($datetime, $timezone);
    }
}
