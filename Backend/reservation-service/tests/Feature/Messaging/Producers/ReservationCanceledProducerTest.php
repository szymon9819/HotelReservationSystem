<?php

declare(strict_types=1);

namespace Tests\Feature\Messaging\Producers;

use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\ExchangeType;
use App\Messaging\Enums\RoutingKey;
use App\Messaging\Producers\ReservationCanceledProducer;
use App\Models\Reservation;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

class ReservationCanceledProducerTest extends TestCase
{
    private AMQPStreamConnection $connectionMock;

    private AMQPChannel $channelMock;

    private Reservation $reservationMock;

    private ReservationCanceledProducer $reservationCanceledProducer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connectionMock = $this->createMock(AMQPStreamConnection::class);
        $this->channelMock = $this->createMock(AMQPChannel::class);
        $this->reservationMock = $this->createMock(Reservation::class);

        $this->connectionMock->expects($this->any())
            ->method('channel')
            ->willReturn($this->channelMock);

        $this->reservationCanceledProducer = new ReservationCanceledProducer(
            $this->connectionMock
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset(
            $this->connectionMock,
            $this->channelMock,
            $this->priceServiceMock,
            $this->reservationMock,
            $this->reservationCanceledProducer
        );
    }

    public function test_publishMessage(): void
    {
        $this->channelMock->expects($this->once())
            ->method('exchange_declare')
            ->with(
                ExchangeName::RESERVATION,
                ExchangeType::DIRECT,
                false,
                true,
                false
            );

        $this->reservationMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $this->channelMock->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->isInstanceOf(AMQPMessage::class),
                ExchangeName::RESERVATION,
                RoutingKey::RESERVATION_CANCELLED
            );

        $this->reservationCanceledProducer->publishMessage($this->reservationMock);
    }
}
