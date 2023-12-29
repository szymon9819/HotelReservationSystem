<?php

declare(strict_types=1);

namespace App\Messaging\Producers;

use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\ExchangeType;
use App\Messaging\Enums\RoutingKey;
use App\Models\Reservation;
use App\Services\Room\RoomPriceService;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ReservationCreatedProducer
{
    private AMQPChannel $channel;

    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly RoomPriceService $priceService,
    ) {
        $this->channel = $this->connection->channel();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function publishMessage(Reservation $reservation): void
    {
        $this->declareExchangeType();

        $this->channel->basic_publish(
            $this->getMessage($reservation),
            ExchangeName::RESERVATION,
            RoutingKey::RESERVATION_CREATED
        );
    }

    private function getMessage(Reservation $reservation): AMQPMessage
    {
        return new AMQPMessage(json_encode([
            'reservation_id' => $reservation->getId(),
            'price' => $this->priceService->getPriceForReservation($reservation),
        ]));
    }

    private function declareExchangeType(): void
    {
        $this->channel->exchange_declare(
            ExchangeName::RESERVATION,
            ExchangeType::DIRECT,
            false,
            true,
            false
        );
    }
}
