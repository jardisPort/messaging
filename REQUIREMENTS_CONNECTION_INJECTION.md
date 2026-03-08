# Requirement: Connection Injection — jardisport/messaging

## Kontext

Im Rahmen der uebergreifenden Connection-Injection-Refactoring-Initiative wird die Connection-Verwaltung aus den Adapter-Packages herausgeloest. Das neue Package `jardisport/connection` stellt das Basis-Interface `ConnectionInterface` bereit. Dieses Requirement beschreibt die Aenderungen am Port-Package `jardisport/messaging`.

## Abhaengigkeit

- **Voraussetzung:** `jardisport/connection` v1.0.0 muss veroeffentlicht sein

## Aenderungen

### Phase 1: ConnectionInterface entfernen

**Datei:** `src/ConnectionInterface.php`

- **Aktion:** Datei entfernen
- **Grund:** Das Interface ist identisch mit `JardisPort\Connection\ConnectionInterface` und wird dort zentral gepflegt
- **Breaking Change:** Ja — alle Implementierungen muessen auf `JardisPort\Connection\ConnectionInterface` umgestellt werden

### Phase 2: getConnection() auf Publisher/Consumer Interfaces

**Datei:** `src/PublisherInterface.php`

Neue Methode hinzufuegen:

```php
use JardisPort\Connection\ConnectionInterface;

public function getConnection(): ConnectionInterface;
```

**Datei:** `src/ConsumerInterface.php`

Neue Methode hinzufuegen:

```php
use JardisPort\Connection\ConnectionInterface;

public function getConnection(): ConnectionInterface;
```

**Grund:** Jeder Publisher/Consumer hat eine Connection. Durch das Interface wird der Zugriff standardisiert und der `method_exists()`-Hack in `MessagePublisher`/`MessageConsumer` entfaellt.

### Phase 3: Exception-Klassen — ConnectionException

**Datei:** `src/ConnectionException.php`

- **Pruefen:** Ob `ConnectionException` hier verbleibt oder nach `jardisport/connection` migriert wird
- **Empfehlung:** Hier belassen — Messaging-spezifische Exceptions gehoeren zum Messaging-Port

### Phase 4: composer.json aktualisieren

```json
{
    "require": {
        "php": ">=8.2",
        "jardisport/connection": "^1.0"
    }
}
```

**Version:** Major-Bump auf `2.0.0` (Breaking Change durch Interface-Entfernung und Interface-Erweiterung)

## Betroffene Dateien

| Datei | Aktion |
|-------|--------|
| `src/ConnectionInterface.php` | Entfernen |
| `src/PublisherInterface.php` | `getConnection()` hinzufuegen |
| `src/ConsumerInterface.php` | `getConnection()` hinzufuegen |
| `composer.json` | Dependency + Version Bump |

## Auswirkungen auf Adapter-Packages

Alle Adapter die `JardisPort\Messaging\ConnectionInterface` implementieren, muessen auf `JardisPort\Connection\ConnectionInterface` umgestellt werden:

- `jardisadapter/messaging` — alle Connection-Klassen
- `jardisadapter/logger` — Handler-Connections (falls vorhanden)
- `jardisadapter/cache` — Cache-Connections (falls vorhanden)

Alle Publisher/Consumer-Implementierungen muessen `getConnection()` implementieren.

## Implementierungsreihenfolge

1. `jardisport/connection` v1.0.0 veroeffentlichen
2. Dieses Package aktualisieren (v2.0.0)
3. Adapter-Packages auf neue Interfaces umstellen
