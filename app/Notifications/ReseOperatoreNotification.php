<?php

namespace App\Notifications;


use App\Http\Controllers\Admin\UserTimelogController;
use App\Models\UserTimelog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\TransportManager;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReseOperatoreNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title = "";
    protected $rows = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $rows, $when=null)
    {
        $this->title = $title;
        $this->rows = $rows;
        if($when) $this->delay($when);
    }

    public function overrideMailerConfig(){

        $host = Config::get('mail.host');
        $port = Config::get('mail.port');
        $encryption = Config::get('mail.encryption');
        $username = Config::get('mail.username');
        $password = Config::get('mail.password');

        // create new mailer with new settings
        $transport = (new \Swift_SmtpTransport($host, $port))
            ->setUsername($username)
            ->setPassword($password)
            ->setEncryption($encryption);

        Mail::setSwiftMailer(new \Swift_Mailer($transport));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return [MailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {

        return (new MailMessage)
            ->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
            ->subject($this->title)
            ->view('emails.rese_operatore', [
                "title" => $this->title,
                "rows" => $this->rows
            ]);

    }
}
