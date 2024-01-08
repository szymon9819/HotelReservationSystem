<?php

declare(strict_types=1);

namespace App\Messaging\Producers;

use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\ExchangeType;
use App\Messaging\Enums\RoutingKey;
use App\Models\Payment;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SuccessfulPaymentProducer
{
    private readonly AMQPChannel $channel;

    public function __construct(
        private readonly AMQPStreamConnection $connection,
    ) {
        $this->channel = $this->connection->channel();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function publishMessage(Payment $payment): void
    {
        $this->declareExchangeType();

        $this->channel->basic_publish(
            $this->getMessage($payment),
            ExchangeName::PAYMENT,
            RoutingKey::PAYMENT_SUCCEEDED
        );
    }

    private function getMessage(Payment $payment): AMQPMessage
    {
        return new AMQPMessage(json_encode([
            'payment_id' => $payment->getId(),
            'status' => $payment->getStatus(),
        ]));
    }

    private function declareExchangeType(): void
    {
        $this->channel->exchange_declare(
            ExchangeName::PAYMENT,
            ExchangeType::DIRECT,
            false,
            true,
            false
        );
    }
}
