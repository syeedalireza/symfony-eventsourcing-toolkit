# Projections

## What are Projections?

Projections build read models from domain events. They transform event streams into queryable data structures.

## Creating a Projection

```php
use Syeedalireza\EventSourcingToolkit\Projection\Projector;

final class AccountBalanceProjector extends Projector
{
    private array $balances = [];

    public function project(object $event): void
    {
        if ($event instanceof AccountOpened) {
            $this->balances[$event->accountId] = $event->initialBalance;
        }

        if ($event instanceof MoneyDeposited) {
            $this->balances[$event->accountId] += $event->amount;
        }

        if ($event instanceof MoneyWithdrawn) {
            $this->balances[$event->accountId] -= $event->amount;
        }
    }

    public function reset(): void
    {
        $this->balances = [];
    }

    public function getBalance(string $accountId): float
    {
        return $this->balances[$accountId] ?? 0.0;
    }
}
```

## Using Projection Manager

```php
use Syeedalireza\EventSourcingToolkit\Projection\ProjectionManager;

$manager = new ProjectionManager($eventStore);
$manager->register(new AccountBalanceProjector());

// Rebuild all projections
$manager->rebuild();
```

## Best Practices

1. **Keep projections simple** - One projection per read model
2. **Make them idempotent** - Can replay multiple times
3. **Handle all event types** - Or explicitly ignore some
4. **Rebuild capability** - Always support full rebuild
5. **Async processing** - Use message queue for large datasets

## Read Model Storage

```php
// Store projection in database
class UserListProjector extends Projector
{
    public function __construct(private Connection $db) {}

    public function project(object $event): void
    {
        if ($event instanceof UserRegistered) {
            $this->db->insert('user_list', [
                'id' => $event->userId,
                'email' => $event->email,
                'created_at' => $event->occurredAt,
            ]);
        }
    }

    public function reset(): void
    {
        $this->db->executeStatement('TRUNCATE user_list');
    }
}
```
