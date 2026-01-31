# Architecture

## Event Sourcing Fundamentals

Event Sourcing ensures that all changes to application state are stored as a sequence of events.

## Components

### 1. Event Store
Persists domain events in PostgreSQL with optimized schema.

### 2. Aggregate Root
Domain entities that produce events.

### 3. Command Bus
Handles commands that modify aggregates.

### 4. Query Bus
Handles queries against read models.

### 5. Projections
Build read models from events.

### 6. Snapshots
Optimize aggregate reconstruction.

## Event Flow

```
Command → Aggregate → Events → Event Store → Projections → Read Model
```
