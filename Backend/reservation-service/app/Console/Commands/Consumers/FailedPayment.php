<?php

declare(strict_types=1);

namespace App\Console\Commands\Consumers;

use App\Enums\PaymentStatus;
use App\Messaging\Entities\Payments\Payment as PaymentEntity;
use App\Messaging\Enums\ExchangeName;
use App\Messaging\Enums\RoutingKey;
use App\Services\Payment\PaymentService;
use Illuminate\Console\Command;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command as CommandAlias;

class FailedPayment extends Command
{
    private const string QUEUE_NAME = 'payments';

    protected $signature = 'payment:consume:failed-payment';

    protected $description = 'Failed payment consumer';

    public function handle(AMQPStreamConnection $connection, PaymentService $paymentService): int
    {
        $channel = $connection->channel();

        $this->declareQueue($channel);

        $callback = function (AMQPMessage $message) use ($channel, $paymentService): void {
            $paymentData = json_decode($message->getBody(), true);

            if ($paymentData !== null) {
                $payment  = new PaymentEntity(
                    $paymentData['payment_id'],
                    $paymentData['reservation_id'],
                    PaymentStatus::tryFrom($paymentData['status'])
                );

                $paymentService->processPayment($payment);

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

        $channel->queue_bind(self::QUEUE_NAME, ExchangeName::PAYMENT, RoutingKey::PAYMENT_FAILED);
    }
}
