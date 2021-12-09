<?php namespace App\Services\Mailers;

use App\Models\Order;
use App\Services\Repositories\Order\EloquentOrderRepository;
use App\Services\Subdomains\Config;
use Illuminate\Mail\Message;

class OrderMailer
{
    private $orderRepository;

    public function __construct(EloquentOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function sendClientCompleteEmail(Order $order)
    {
        $to = $order->email;
        $emailRules = ['to' => ['required', 'email']];

        if (\Validator::make(compact('to'), $emailRules)->passes()) {
            $orderData = $this->orderRepository->getPrintData($order);

            \Mail::send(
                'emails.order.client.complete',
                compact('order', 'orderData'),
                function (Message $message) use ($order, $to) {
                    $message->to($to);
                    $message->subject(
                        str_replace(
                            ['{root_url}'],
                            [\Request::server('HTTP_HOST')],
                            "Вы сделали заказ на сайте {root_url}"
                        )
                    );
                }
            );

            return true;
        }

        return false;
    }

    public function sendAdminCompleteEmail(Order $order)
    {
        $emails = \Helper::getValidEmails(config('mail.from.address'));
        if (count($emails) > 0) {
            $orderData = $this->orderRepository->getPrintData($order, true);

            foreach ($emails as $email) {
                \Mail::send(
                    'emails.order.admin.complete',
                    compact('order', 'orderData'),
                    function (Message $message) use ($order, $email) {
                        $message->to($email);
                        \Helper::setReplyToHeader($message, $order->email, $order->name);
                        $message->subject(
                            str_replace(
                                ['{root_url}'],
                                [\Request::server('HTTP_HOST')],
                                ($order->type == Order\TypeConstants::FAST ? 'Быстрый заказ' : 'Заказ') . " на сайте {root_url}"
                            )
                        );
                    }
                );
            }

            return true;
        }

        return false;
    }
}
