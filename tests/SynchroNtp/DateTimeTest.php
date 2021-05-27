<?php
declare(strict_types=1);

namespace SynchroNtp;

use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeTest
 * @package SynchroNtp
 */
class DateTimeTest extends TestCase
{
    /**
     * test si DateTime est bien une interface de DateTime
     */
    public function testInterface(): void
    {
        self::assertInstanceOf(\DateTimeInterface::class, new DateTime());
    }
}
