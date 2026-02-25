<?php

declare(strict_types=1);

namespace JardisPort\Messaging;

/**
 * Messaging service interface
 *
 * Unified interface for publishing and consuming messages
 * Combines both publisher and consumer functionality in one service
 */
interface MessagingServiceInterface
{
    /**
     * Publish a message to the specified topic/channel/queue
     *
     * @param string $topic The topic, channel or queue name
     * @param string|object|array<mixed> $message The message payload
     * @param array<string, mixed> $options Publisher-specific options
     * @return bool True on success
     * @throws \JardisPort\Messaging\Exception\PublishException if publishing fails
     */
    public function publish(string $topic, string|object|array $message, array $options = []): bool;

    /**
     * Start consuming messages with a handler
     *
     * @param string $topic The topic, channel or queue name
     * @param MessageHandlerInterface $handler Message handler
     * @param array<string, mixed> $options Consumer-specific options
     * @return void
     * @throws \JardisPort\Messaging\Exception\ConsumerException if consuming fails
     */
    public function consume(string $topic, MessageHandlerInterface $handler, array $options = []): void;

    /**
     * Get the underlying publisher instance (creates it if not yet instantiated)
     *
     * @return MessagePublisherInterface
     */
    public function getPublisher(): MessagePublisherInterface;

    /**
     * Get the underlying consumer instance (creates it if not yet instantiated)
     *
     * @return MessageConsumerInterface
     */
    public function getConsumer(): MessageConsumerInterface;
}
