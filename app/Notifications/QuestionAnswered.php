<?php

namespace App\Notifications;

use App\Models\FrequentlyAskedQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAnswered extends Notification
{
    use Queueable;

    public FrequentlyAskedQuestion $question;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FrequentlyAskedQuestion $question)
    {
        $this->question = $question;
        $question->load("user");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ["mail"];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting("Hello " . $notifiable->full_name)
            ->line("Your question has been answered.")
            ->lines([
                "Question: " . $this->question->title,
                "Answer: " . $this->question->answer,
            ])
            ->salutation(
                "We hope this helps! If you have any more questions, feel free to ask.",
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
