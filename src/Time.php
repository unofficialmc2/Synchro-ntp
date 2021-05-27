<?php
declare(strict_types=1);

namespace SynchroNtp;

use DateInterval;
use DateTime as PhpDateTime;
use Exception;
use RuntimeException;
use Throwable;

/**
 * Class Time
 * class static permetant de donner un time stamp corriger pour approcher l'heure d'un serveur NTP
 * @package SynchroNtp
 */
class Time
{
    private const DELTA_FILE_NAME = "SynchroNtp_delta";

    private static ?float $deltaNtp = null;

    /**
     * GitHub Gist
     * bohwaz/get_time_from_ntp.php
     * @link  https://gist.github.com/bohwaz/6d01bf00fdb4721a601c4b9fc1007d81
     * @param string $host
     * @param int $timeout
     * @return int
     */
    private static function getTimeFromNTP(string $host = 'pool.ntp.org', int $timeout = 10): int
    {
        try {
            $socket = stream_socket_client('udp://' . $host . ':123', $errno, $errstr, (int)$timeout);
            if ($socket === false) {
                throw new Exception("inpossible de se connecter au serveur horloge");
            }
            $msg = "\010" . str_repeat("\0", 47);
            fwrite($socket, $msg);
            $response = fread($socket, 48);
            fclose($socket);
            // unpack to unsigned long
            $data = unpack('N12', $response);
            if ($data === false) {
                throw new Exception("les données reçus ne sont pas valide");
            }
            // 9 =  Receive Timestamp (rec): Time at the server when the request arrived
            // from the client, in NTP timestamp format.
            $timestamp = (int)sprintf('%u', $data[9]);
            // NTP = number of seconds since January 1st, 1900
            // Unix time = seconds since January 1st, 1970
            // remove 70 years in seconds to get unix timestamp from NTP time
            $timestamp -= 2208988800;
            return $timestamp;
        } catch (Throwable $t) {
            throw new RuntimeException("Un problème est survenu lors de la récupération de l'heure d'un serveur horloge", $t->getCode(), $t);
        }
    }

    /**
     * retourne le timestamp UNIX synchro avec les serveur NTP
     * @return int
     */
    public static function get(): int
    {
        return (int)round(\time() + self::getDeltaCachedMemory());
    }

    /**
     * retourne le delta enregistré dans la mémoire
     * sinon, celui enregistré dans le fichier
     * @return float
     */
    private static function getDeltaCachedMemory(): float
    {
        if (self::$deltaNtp === null) {
            self::$deltaNtp = self::getDeltaCachedFile();
        }
        return (float)self::$deltaNtp;
    }

    /**
     * retourne le delta enregistré dans le fichier de cache
     * @return float
     */
    private static function getDeltaCachedFile(): float
    {
        $regexInterval = "/^P(?:-?\d+Y)?(?:-?\d+M)?(?:-?\d+D)?(?:T(?:-?\d+H)?(?:-?\d+M)?(?:-?\d+S)?)?$/";
        $interval = "PT6H";
        if (
            defined('SYNCHRO_NTP_INTERVAL')
            && preg_match(, $regexInterval, SYNCHRO_NTP_INTERVAL) > 0
        ) {
            $interval = SYNCHRO_NTP_INTERVAL;
        }
        $deltaFile = self::getDeltaFile();
        $validity = (new PhpDateTime())->sub(new DateInterval(self::DELTA_FILE_VALIDITY));
        if ($deltaFile === null || $deltaFile->mesuredOn() < $validity) {
            $deltaFile = self::setDeltaFile();
        }
        return $deltaFile->value();
    }

    /**
     * chemin complet vers le fichier où est enregistré le delta
     * @return string
     */
    private static function getDeltaFileanme(): string
    {
        $tempDir = sys_get_temp_dir();
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        /** @noinspection OneTimeUseVariablesInspection */
        $filename = $tempDir . DIRECTORY_SEPARATOR . self::DELTA_FILE_NAME;
        // error_log($filename);
        return $filename;
    }

    /**
     * lit le delta enregistré dans un fichier
     * @return Delta|null
     */
    private static function getDeltaFile(): ?Delta
    {
        $deltaFileanme = self::getDeltaFileanme();
        if (!is_file($deltaFileanme)) {
            return null;
        }
        $lastModified = filemtime($deltaFileanme);
        if ($lastModified === false) {
            return null;
        }
        $created = PhpDateTime::createFromFormat('U', (string)$lastModified);
        $value = (float)file_get_contents($deltaFileanme);
        return new Delta($value, $created);
    }

    /**
     * mesure et enregistre le delta dans un fichier
     * @return Delta
     */
    private static function setDeltaFile(): Delta
    {
        // mesure du delta
        $start = \time();
        $ntp = self::getTimeFromNTP('ntp.unice.fr', 1);
        $end = \time();
        $local = (float)(($start + $end) / 2);
        $delta = $ntp - $local;
        // enregistrement du delta
        $deltaFileanme = self::getDeltaFileanme();
        file_put_contents($deltaFileanme, $delta);

        return new Delta($delta, new DateTime());
    }

    /**
     * supprime le delta enregistré en cache
     */
    protected static function clearCache(): void
    {
        self::$deltaNtp = null;
        unlink(self::getDeltaFileanme());
    }
}