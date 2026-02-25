# JardisPort Messaging

![Build Status](https://github.com/JardisPort/messaging/actions/workflows/ci.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-success.svg)](phpstan.neon)
[![PSR-4](https://img.shields.io/badge/autoload-PSR--4-blue.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR-12](https://img.shields.io/badge/code%20style-PSR--12-orange.svg)](phpcs.xml)

A PHP library providing async messaging interfaces for domain-driven design (DDD) applications.

## Overview

This package offers a set of standardized interfaces for implementing message-based communication patterns in PHP applications. It provides abstractions for publishers, consumers, message handlers, and connections to message brokers, allowing you to build decoupled, event-driven architectures.

## Requirements

- PHP >= 8.2

## Installation

Install via Composer:

```bash
composer require jardisport/messaging
```

## Interfaces

### Core Interfaces

#### MessagingServiceInterface

Unified interface combining both publisher and consumer functionality in one service.

```php
public function publish(string $topic, string|object|array $message, array $options = []): bool;
public function consume(string $topic, MessageHandlerInterface $handler, array $options = []): void;
public function getPublisher(): MessagePublisherInterface;
public function getConsumer(): MessageConsumerInterface;
```

#### ConnectionInterface

Manages connections to message brokers.

```php
public function connect(): void;
public function disconnect(): void;
public function isConnected(): bool;
```

### Publishing Interfaces

#### PublisherInterface

Low-level interface for publishing messages to topics, channels, or queues.

```php
public function publish(string $topic, string $message, array $options = []): bool;
```

#### MessagePublisherInterface

High-level interface for application-specific message publishing.

```php
public function publish(string|object|array $message): bool;
```

### Consumption Interfaces

#### ConsumerInterface

Low-level interface for consuming messages from topics, channels, or queues.

```php
public function consume(string $topic, callable $callback, array $options = []): void;
public function stop(): void;
```

#### MessageConsumerInterface

High-level interface for application-specific message consumption.

```php
public function consume(MessageHandlerInterface $handler): void;
```

#### MessageHandlerInterface

Handles received messages with acknowledgment control.

```php
public function handle(string|array $message, array $metadata): bool;
```

## Exceptions

The library provides specific exceptions for different error scenarios:

- `ConnectionException` - Connection-related errors
- `PublishException` - Publishing failures
- `ConsumerException` - Consumption errors
- `MessageException` - Message handling errors

## Usage Examples

### Using MessagingServiceInterface (Recommended)

The unified service interface simplifies implementation by combining publisher and consumer:

```php
use JardisPort\Messaging\MessagingServiceInterface;
use JardisPort\Messaging\MessageHandlerInterface;

class MyMessagingService implements MessagingServiceInterface {
    public function publish(string $topic, string|object|array $message, array $options = []): bool {
        // Publish message to your broker
        return true;
    }

    public function consume(string $topic, MessageHandlerInterface $handler, array $options = []): void {
        // Start consuming messages
    }

    public function getPublisher(): MessagePublisherInterface {
        // Return publisher instance
    }

    public function getConsumer(): MessageConsumerInterface {
        // Return consumer instance
    }
}

// Usage
$service = new MyMessagingService();
$service->publish('orders', ['order_id' => 123, 'status' => 'created']);
$service->consume('orders', new MyMessageHandler());
```

### Using Individual Interfaces

For more granular control, implement the interfaces separately:

```php
use JardisPort\Messaging\PublisherInterface;
use JardisPort\Messaging\ConsumerInterface;
use JardisPort\Messaging\MessageHandlerInterface;

class MyPublisher implements PublisherInterface {
    public function publish(string $topic, string $message, array $options = []): bool {
        // Implementation for your message broker
        return true;
    }
}

class MyMessageHandler implements MessageHandlerInterface {
    public function handle(string|array $message, array $metadata): bool {
        // Process the message
        // Return true to acknowledge, false to reject/requeue
        return true;
    }
}

class MyConsumer implements ConsumerInterface {
    public function consume(string $topic, callable $callback, array $options = []): void {
        // Implementation for your message broker
    }

    public function stop(): void {
        // Stop consuming
    }
}
```

## Development

### Code Quality Tools

The project includes PHPStan and PHP_CodeSniffer for maintaining code quality:

```bash
# Run PHPStan
composer exec phpstan analyse

# Run PHP_CodeSniffer
composer exec phpcs
```

### Git Hooks

A pre-commit hook is automatically installed via Composer to ensure code quality before commits.

## License

MIT License - see [LICENSE](LICENSE) file for details.

## Support

- **Issues**: [GitHub Issues](https://github.com/JardisPort/messaging/issues)
- **Email**: jardisCore@headgent.dev

## Authors

Jardis Core Development - [jardisCore@headgent.dev](mailto:jardisCore@headgent.dev)

## Keywords

messaging, interfaces, JardisPort, Headgent, DDD
