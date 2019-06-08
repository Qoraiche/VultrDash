<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class BlockStorageAdded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $blockstorage;

    public function __construct($blockstorage)
    {
        $this->blockstorage = $blockstorage;
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
     *
     * public function toMail($notifiable)
     * {
     * return (new MailMessage)
     * ->line('The introduction to the notification.')
     * ->action('Notification Action', url('/'))
     * ->line('Thank you for using our application!');
     * }
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage())
                ->success()
                ->content('A new block storage has been added - ('.$notifiable->slug().')')
                ->attachment(function ($attachment) use ($notifiable) {
                    $attachment->title('Block Storage '.$this->blockstorage['SUBID'])
                               ->fields($this->blockstorage);
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
        return $this->blockstorage;
    }
}
