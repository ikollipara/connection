<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SurveyReminder extends Notification
{
    use Queueable;

    private User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[conneCTION] Survey Completion Reminder')
            ->greeting('Hello!')
            ->line('Thank you for being apart of conneCTION.')
            ->line(
                'If you didn\'t know, conneCTION is not just a platform for community, but also a platform for CS Education Research.',
            )
            ->line(
                'Since you consented for the research, we would like to remind you to complete the survey.',
            )
            ->line(
                'For every 20 surveys completed, a raffle will be held to determine who gets a $50 Amazon Gift Card.',
            )
            ->line('please complete the surveys previously sent')
            ->line(
                'In case you have lost those emails, you can find the surveys here:',
            )
            ->action(
                'CT-CAST',
                "https://unlcorexmuw.qualtrics.com/jfe/form/SV_77fiKxeee2WFRVs?userId={$this->user->id}"
            )
            ->action(
                'Interest and Self-Efficacy Scales',
                "https://unlcorexmuw.qualtrics.com/jfe/form/SV_9srNvEgI4qtTNYO?userId={$this->user->id}"
            )
            ->salutation('Thank you for your participation in the research.');
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
