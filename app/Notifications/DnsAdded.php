<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class DnsAdded extends Notification
{
    use Queueable;


    protected $dns;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $dns )
    {
        $this->dns = $dns;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->prefer_slack() ? ['slack'] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    */


    public function toSlack($notifiable)
    {

        return (new SlackMessage)
                ->success()
                ->content('A new DNS added - ('.$notifiable->email.')' )
                ->attachment(function ($attachment) {
                    $attachment->title( 'DNS '. $this->dns['domain'] )
                               ->fields( $this->dns );
                });

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->dns;
    }
}
