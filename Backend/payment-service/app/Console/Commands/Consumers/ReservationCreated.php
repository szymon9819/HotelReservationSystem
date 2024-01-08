<?php

declare(strict_types=1);

namespace App\Console\Commands\Consumers;

use App\Messaging\Entities\ReservationCreated as ReservationEntity;
use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\RoutingKey;
use App\Services\Reservations\ReservationCreatedService;
use Illuminate\Console\Command;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ReservationCreated extends Command
{
    private const string QUEUE_NAME = 'reservations';

    protected $signature = 'payment:consume:reservation-created';

    protected $description = 'Reservation created consumer';

    public function handle(AMQPStreamConnection $connection, ReservationCreatedService $reservationCreatedService): int
    {
        $channel = $connection->channel();

        $this->declareQueue($channel);

        $callback = function (AMQPMessage $message) use ($channel, $reservationCreatedService): void {
            $reservationData = json_decode($message->getBody(), true);

            if ($reservationData !== null) {
                $reservation = new ReservationEntity(
                    $reservationData['reservation_id'],
                    $reservationData['price']
                );

                $reservationCreatedService->createPayment($reservation);

                $channel->basic_ack($message->getDeliveryTag());
            } else {
                $channel->basic_nack($message->getDeliveryTag());
            }
        };

        $channel->basic_consume(
            self::QUEUE_NAME,
            '',
            false,
            false,
            false,
            false,
            $callback
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();

        return CommandAlias::SUCCESS;
    }

    private function declareQueue(AMQPChannel $channel): void
    {
        $channel->queue_declare(
            self::QUEUE_NAME,
            false,
            true,
            false,
            false
        );

        $channel->queue_bind(self::QUEUE_NAME, ExchangeName::RESERVATION, RoutingKey::RESERVATION_CREATED);
    }
}
