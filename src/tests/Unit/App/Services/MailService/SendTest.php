<?php

namespace Tests\Unit\App\Services\MailService;


use App\Dictionary\EmailStatus;
use App\Models\Email;
use App\Notifications\SendEmailNotification;
use App\Services\MailService;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function notFound()
    {
        Notification::fake();
        Notification::assertNothingSent();
        Notification::shouldReceive('send')->andThrows(new \Exception('invalid recipient'));

        $service = app()->make(MailService::class);
        $data = Email::factory()->make()->getAttributes();
        $mail = $service->store($data);

        $this->assertEquals(EmailStatus::ERROR->value, $mail->status);
    }

    /**
     * @test
     * @return void
     */
    public function valid()
    {
        Notification::fake();

        $service = app()->make(MailService::class);
        $data = Email::factory()->make()->getAttributes();
        $mail = $service->store($data);

        Notification::assertSentTo(
            [$mail],
            SendEmailNotification::class
        );

        $this->assertEquals(EmailStatus::SENDING->value, $mail->status);
    }
}
