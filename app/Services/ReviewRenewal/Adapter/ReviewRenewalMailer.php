<?php namespace App\Services\ReviewRenewal\Adapter;

use App\Services\Repositories\ReviewDateChange\EloquentReviewDateChangeRepository;
use App\Services\ReviewRenewal\ReportSender;
use Diol\LaravelMailer\Message;

class ReviewRenewalMailer implements ReportSender
{
    private $reportEmail;
    private $dateChangeRepository;

    public function __construct($reportEmail, EloquentReviewDateChangeRepository $dateChangeRepository)
    {
        $this->reportEmail = $reportEmail;
        $this->dateChangeRepository = $dateChangeRepository;
    }

    public function report($iteration)
    {
        $dateChangeList = $this->dateChangeRepository->allWithinIteration($iteration);
        if (is_array($this->reportEmail)) {
            $emailList = $this->reportEmail;
        } else {
            $emailList = array_map(function ($email) {
                return trim($email);
            }, explode(',', $this->reportEmail));
            $emailList = array_filter($emailList, function ($email) {
                return $email !== '';
            });
        }

        foreach ($emailList as $email) {

            $subject = "Автоматическое обновление дат отзывов на сайте " . route('home');

            \Mail::send(
                'emails.review.renewal_report',
                ['dateChangeList' => $dateChangeList, 'subject' => $subject],
                function (Message $message) use ($email, $subject) {
                    $message->to($email);
                    $message->subject($subject);
                }
            );
        }
    }
}
