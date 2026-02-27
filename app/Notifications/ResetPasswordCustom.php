<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCustom extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/reset-password/'.$this->token.'?email='.$notifiable->email);

        return (new MailMessage)
            ->subject('Reset Password Akun Anda')
            ->greeting('Halo '.$notifiable->name)
            ->line('Kami menerima permintaan untuk mengatur ulang password akun Anda.')
            ->line('Silakan klik tombol di bawah ini untuk melanjutkan.')
            ->action('Reset Password', $url)
            ->line('Link ini hanya berlaku selama 60 menit.')
            ->line('Jika Anda tidak merasa melakukan reset password, abaikan email ini.')
            ->salutation('Hormat kami, Tim SIMAKK ASN');
    }
}
