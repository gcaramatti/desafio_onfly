<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Expense;
use App\Models\User;

class SendMailNotification extends Notification
{
    use Queueable;
    private $expense;

    /**
     * Create a new notification instance.
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'mail-queue',
            'slack' => 'slack-queue',
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(string $notifiable): MailMessage
    {
        $expenseLinkedUser = User::find($this->expense->user_id);

        return (new MailMessage)
            ->subject('Despesa cadastrada')
            ->greeting('Ola! Você tem uma nova despesa cadastrada')
            ->line('Descrição: ' . $this->expense->description)
            ->line('Valor: R$' . $this->expense->price)
            ->line('Usuário vinculado: ' . $expenseLinkedUser->name)
            ->salutation('Até a próxima!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
