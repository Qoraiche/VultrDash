<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ServerDeployed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $server;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($server)
    {
        $this->server = $server;
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
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line('A new server has been deployed!')
                    ->action('View server', url('/servers/'. $this->server['SUBID'] ))
                    ->line('Thank you for using our application!');*/
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
                ->success()
                ->content('A new server deployed - ('.$notifiable->slug().')')
                ->attachment(function ($attachment) use ($notifiable) {
                    $attachment->title('Server '.$this->server['SUBID'], url('/servers/'.$this->server['SUBID']))
                               ->fields($this->server);
                });
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
        return $this->server;
    }
}
