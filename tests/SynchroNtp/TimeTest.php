<?php
declare(strict_types=1);

namespace SynchroNtp;

use Test\Stubs\TimeStub;
use Test\TestCase;

/**
 * Class TimeTest
 * @package SynchroNtp
 */
class TimeTest extends TestCase
{
    /**
     * test de get
     */
    public function testGet(): void
    {
        self::assertLessThanOrEqual(1, \time() - Time::get());
    }

    /**
     *
     */
    public function testCache(): void
    {
        TimeStub::clearCache();
        TimeStub::get();
        TimeStub::get();
        $ts = TimeStub::get();
        self::assertIsInt($ts);
        TimeStub::clearCache();
        TimeStub::get();
        TimeStub::get();
        $ts = TimeStub::get();
        self::assertIsInt($ts);
    }
}
