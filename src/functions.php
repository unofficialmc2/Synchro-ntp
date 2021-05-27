<?php
declare(strict_types=1);

namespace SynchroNtp;

/**
 * Retourne le timestamp UNIX actuel
 * @return int
 */
function time(): int
{
    return Time::get();
}
