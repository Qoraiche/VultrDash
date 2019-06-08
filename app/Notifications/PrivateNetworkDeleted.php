<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PrivateNetworkDeleted extends Notification
{
    use Queueable;

    protected $network_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($network_id)
    {
        $this->network_id = $network_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->prefer_slack() ? ['slack'] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     *                                                        public function toMail($notifiable)
     *                                                        {
     *                                                        return (new MailMessage)
     *                                                        ->line('The introduction to the notification.')
     *                                                        ->action('Notification Action', url('/'))
     *                                                        ->line('Thank you for using our application!');
     *                                                        }
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage())
                ->warning()
                ->content('Private Network (ID: '.$this->network_id.') has been destroyed - ('.$notifiable->slug().')');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'network_id' => $this->network_id,
        ];
    }
}
