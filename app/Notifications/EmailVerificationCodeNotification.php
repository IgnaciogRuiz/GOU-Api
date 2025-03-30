<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationCodeNotification extends Notification
{
    use Queueable;

    public $emailCode;

    /**
     * Crear una nueva notificación.
     *
     * @param  int  $emailCode
     * @return void
     */
    public function __construct($emailCode)
    {
        $this->emailCode = $emailCode;
    }

    /**
     * Obtener el canal de entrega de la notificación.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];  // Solo usaremos el canal de correo para esta notificación
    }

    /**
     * Construir el mensaje de la notificación.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Código de Verificación de Email')
                    ->line('Tu código de verificación es: ' . $this->emailCode)
                    ->line('Este código expirará en 60 minutos.')
                    ->salutation('Saludos,');
    }
}
