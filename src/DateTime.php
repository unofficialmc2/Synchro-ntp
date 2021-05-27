<?php
declare(strict_types=1);

namespace SynchroNtp;

use DateTimeZone;

/**
 * Class DateTime
 * @inheritDoc
 */
class DateTime extends \DateTime
{
    /**
     * DateTime constructor.
     * Surcharge du constructeur pour créer un date time à partir d'un serveur nts
     * @param string $datetime
     * @param DateTimeZone|null $timezone
     * @throws \Exception
     */
    public function __construct($datetime = 'now', DateTimeZone $timezone = null)
    {
        if ($datetime === 'now') {
            $time = time();
            $datetime = date('c', $time);
        }
        parent::__construct($datetime, $timezone);
    }
}
