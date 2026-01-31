# Snapshots

## Why Snapshots?

Snapshots optimize aggregate reconstruction by storing the current state at specific intervals.

## How It Works

Instead of replaying 1000 events, replay from snapshot (event 900) + 100 events.

## Usage

```php
// Save snapshot every 100 events
if ($aggregate->getVersion() % 100 === 0) {
    $snapshotStore->save(
        $aggregate->getAggregateId(),
        $aggregate,
        $aggregate->getVersion()
    );
}

// Load from snapshot
$snapshot = $snapshotStore->load($aggregateId);
if ($snapshot) {
    $aggregate = $snapshot['aggregate'];
    $events = $eventStore->loadAfterVersion($aggregateId, $snapshot['version']);
}
```

## Configuration

```yaml
event_sourcing:
    snapshots:
        enabled: true
        interval: 100  # Save snapshot every 100 events
```
