<?php
declare(strict_types=1);

namespace Test\Stubs;

/**
 * Class TimeStub
 * @package Test\Stubs
 */
class TimeStub extends \SynchroNtp\Time
{
    /**
     * methode rendu publique pour le test
     */
    public static function clearCache(): void
    {
        parent::clearCache();
    }

}