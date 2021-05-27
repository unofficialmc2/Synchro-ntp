<?php
declare(strict_types=1);

namespace SynchroNtp;

use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeImmutableTest
 * @package SynchroNtp
 */
class DateTimeImmutableTest extends TestCase
{
    /**
     * test si DateTimeImmutable est bien une interface de DateTime
     */
    public function testInterface(): void
    {
        self::assertInstanceOf(\DateTimeInterface::class, new DateTimeImmutable());
    }
}
