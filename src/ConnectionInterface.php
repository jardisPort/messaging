<?php

declare(strict_types=1);

namespace JardisPort\Messaging;

use JardisPort\Messaging\Exception\ConnectionException;

/**
 * Connection interface
 *
 * Defines the contract for message broker connections
 */
interface ConnectionInterface
{
    /**
     * Establish connection to the message broker
     *
     * @throws ConnectionException
     */
    public function connect(): void;

    /**
     * Close connection to the message broker
     */
    public function disconnect(): void;

    /**
     * Check if connected to the message broker
     *
     * @return bool True if connected
     */
    public function isConnected(): bool;
}
