<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class StartupScriptAdded extends Notification
{
    use Queueable;

    protected $startupscript;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $startupscript )
    {
        $this->startupscript = $startupscript;
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


    public function toSlack($notifiable)
    {

        return (new SlackMessage)
                ->success()
                ->content('A new startup script added - ('.$notifiable->email.')' )
                ->attachment(function ($attachment) {
                    $attachment->title( 'Startup Script '. $this->startupscript['SCRIPTID'] )
                               ->fields( $this->startupscript );
                });

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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    
    public function toArray($notifiable)
    {

        return $this->startupscript;
    }
}
