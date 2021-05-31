# synchro-ntp

Synchro-ntp est un librairie qui surcharge les classes et fonction de base PHP afin d'avoir une heure synchronisé avec un serveur NTP.

## Installation

```shell
composer require fzed51/synchr-ntp
```

## Utilisation

avant : 
```php
<?php
$timestamp = time();
$DateTime1 = new DateTime();
$DateTime2 = new DateTimeImmutable();
```

après :
```php
<?php
use function \SynchroNtp\time;
use \SynchroNtp\DateTimeImmutable;
use \SynchroNtp\DateTime;
$timestamp = time();
$DateTime1 = new DateTime();
$DateTime2 = new DateTimeImmutable();
```

## Paramètrage

- `SYNCHRO_NTP_DIRECTORY` : chemin du dossier où est enregistré le fichier `SynchroNtp_delta`.
- `SYNCHRO_NTP_INTERVAL` : interval de temps (au format DateInterval) entre les synchronisations avec un serveur Ntp.
