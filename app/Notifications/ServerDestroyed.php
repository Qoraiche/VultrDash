<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ServerDestroyed extends Notification
{
    use Queueable;

    protected $server_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($server_id)
    {
        $this->server_id = $server_id;
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
     */
    /*

        public function toMail($notifiable){
            return (new MailMessage)
                        ->line('Server Destroyed')
                        ->action('Notification Action', url('/'))
                        ->line('Thank you for using our application!');
        }
        */

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
                ->warning()
                ->content('Server (ID: '.$this->server_id.') has been destroyed - ('.$notifiable->slug().')');
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
            'server_id' => $this->server_id,
        ];
    }
}
