# Symfony Event Sourcing Toolkit

Event Sourcing and CQRS implementation for Symfony with PostgreSQL event store, projections, and snapshots.

## Features

- PostgreSQL-optimized Event Store
- CQRS Command/Query separation  
- Event versioning and upcasting
- Snapshot mechanism for performance
- Projection engine with rebuild
- Event replay functionality
- Symfony Messenger integration

## Installation

```bash
composer require syeedalireza/symfony-eventsourcing-toolkit
```

## Quick Start

```php
// Define your aggregate
class BankAccount extends AggregateRoot
{
    private Money $balance;

    public function deposit(Money $amount): void
    {
        $this->recordThat(new MoneyDeposited($amount));
    }

    protected function applyMoneyDeposited(MoneyDeposited $event): void
    {
        $this->balance = $this->balance->add($event->amount);
    }
}

// Use the event store
$eventStore->save($account);
$history = $eventStore->load($accountId);
```
