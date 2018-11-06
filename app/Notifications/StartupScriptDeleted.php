<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class StartupScriptDeleted extends Notification
{
    use Queueable;

    protected $startupscript_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(  $startupscript_id )
    {
        $this->startupscript_id = $startupscript_id;
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
                ->warning()
                ->content('Startup script (ID: '.$this->startupscript_id.') has been deleted - ('.$notifiable->slug().')' );
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
            'startupscript_id' => $this->startupscript_id
        ];
    }
}
