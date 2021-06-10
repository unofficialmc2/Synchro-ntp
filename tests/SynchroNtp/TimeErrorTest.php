<?php
declare(strict_types=1);

namespace SynchroNtp;

use http\Exception\RuntimeException;
use Test\Stubs\TimeStub;
use Test\TestCase;

/**
 * Class TimeErrorTest
 * @package SynchroNtp
 */
class TimeErrorTest extends TestCase
{
    /**
     * test de Bad NTP server
     */
    public function testBadNtpServer(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectErrorMessage(
            'Un problème est survenu lors de la récupération de l\'heure d\'un serveur horloge, impossible de se '
            . 'connecter au serveur horloge'
        );
        $ts = Time::getTimeFromNTP('azeaze', 1);
    }
}
