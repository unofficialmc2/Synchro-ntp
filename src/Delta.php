<?php
declare(strict_types=1);

namespace SynchroNtp;

use DateTimeInterface;

/**
 * Class Delta
 * mesure d'un delta et date de la prise de mesure
 * @package SynchroNtp
 */
class Delta
{
    private float $value;
    private DateTimeInterface $mesuredOn;

    /**
     * Delta constructor.
     * @param float $value
     * @param DateTimeInterface $mesuredOn
     */
    public function __construct(float $value, DateTimeInterface $mesuredOn)
    {
        $this->value = $value;
        $this->mesuredOn = $mesuredOn;
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * @return DateTimeInterface
     */
    public function mesuredOn(): DateTimeInterface
    {
        return $this->mesuredOn;
    }
}
