<?php

declare(strict_types=1);

namespace Tests\Feature\Messaging\Producers;

use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\ExchangeType;
use App\Messaging\Enums\RoutingKey;
use App\Messaging\Producers\ReservationCreatedProducer;
use App\Models\Reservation;
use App\Services\Room\RoomPriceService;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

class ReservationCreatedProducerTest extends TestCase
{
    private AMQPStreamConnection $connectionMock;

    private AMQPChannel $channelMock;

    private RoomPriceService $priceServiceMock;

    private Reservation $reservationMock;

    private ReservationCreatedProducer $reservationProducer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connectionMock = $this->createMock(AMQPStreamConnection::class);
        $this->channelMock = $this->createMock(AMQPChannel::class);
        $this->priceServiceMock = $this->createMock(RoomPriceService::class);
        $this->reservationMock = $this->createMock(Reservation::class);

        $this->connectionMock->expects($this->any())
            ->method('channel')
            ->willReturn($this->channelMock);

        $this->reservationProducer = new ReservationCreatedProducer(
            $this->connectionMock,
            $this->priceServiceMock
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
            $this->reservationProducer
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

        $this->priceServiceMock->expects($this->once())
            ->method('getPriceForReservation')
            ->willReturn(100.0);

        $this->channelMock->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->isInstanceOf(AMQPMessage::class),
                ExchangeName::RESERVATION,
                RoutingKey::RESERVATION_CREATED
            );

        $this->reservationProducer->publishMessage($this->reservationMock);
    }
}
