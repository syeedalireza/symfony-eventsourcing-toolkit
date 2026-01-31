# Getting Started

## Installation

```bash
composer require syeedalireza/symfony-eventsourcing-toolkit
```

## Basic Usage

### 1. Create Your Aggregate

```php
use Syeedalireza\EventSourcingToolkit\Aggregate\AggregateRoot;

class Order extends AggregateRoot
{
    private string $id;
    private string $status;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->recordThat(new OrderCreated($id));
    }

    public function getAggregateId(): string
    {
        return $this->id;
    }

    protected function apply(object $event): void
    {
        if ($event instanceof OrderCreated) {
            $this->status = 'pending';
        }
    }
}
```

### 2. Use Event Store

```php
$eventStore->append($order->getAggregateId(), $order->getRecordedEvents(), 0);
$events = $eventStore->load($orderId);
```

### 3. CQRS Buses

```php
// Command
$commandBus->register(CreateOrder::class, $handler);
$commandBus->dispatch(new CreateOrder($data));

// Query
$queryBus->register(GetOrder::class, $handler);
$result = $queryBus->ask(new GetOrder($id));
```
