<?php
declare(strict_types=1);

namespace Test\Divers;

use PHPUnit\Framework\TestCase;

/**
 * Class TimeTest
 * @package Test\Divers
 */
class TimeTest extends TestCase
{
    /**
     * test de ConvertionDeDate
     */
    public function testConvertionDeDate(): void
    {
        $ts = 1622107630;
        self::assertEquals('2021-05-27T11:27:10+02:00', date('c', $ts));
    }
}
