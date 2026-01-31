<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Syeedalireza\EventSourcingToolkit\Aggregate\AggregateRoot;

// Example Domain Events
class AccountOpened { public function __construct(public float $amount) {} }
class MoneyDeposited { public function __construct(public float $amount) {} }
class MoneyWithdrawn { public function __construct(public float $amount) {} }

// Bank Account Aggregate
class BankAccount extends AggregateRoot
{
    private string $id;
    private float $balance = 0;

    public function __construct(string $id, float $initialDeposit)
    {
        $this->id = $id;
        $this->recordThat(new AccountOpened($initialDeposit));
    }

    public function getAggregateId(): string { return $this->id; }

    public function deposit(float $amount): void
    {
        $this->recordThat(new MoneyDeposited($amount));
    }

    public function withdraw(float $amount): void
    {
        if ($this->balance < $amount) {
            throw new \DomainException('Insufficient funds');
        }
        $this->recordThat(new MoneyWithdrawn($amount));
    }

    protected function apply(object $event): void
    {
        match(true) {
            $event instanceof AccountOpened => $this->balance = $event->amount,
            $event instanceof MoneyDeposited => $this->balance += $event->amount,
            $event instanceof MoneyWithdrawn => $this->balance -= $event->amount,
            default => null
        };
    }

    public function getBalance(): float { return $this->balance; }
}

// Demo
echo "=== Event Sourcing Example ===\n\n";

$account = new BankAccount('acc-123', 1000);
$account->deposit(500);
$account->withdraw(200);

echo "Balance: $" . $account->getBalance() . "\n";
echo "Events: " . count($account->getRecordedEvents()) . "\n";
echo "\n✅ Event Sourcing works!\n";
