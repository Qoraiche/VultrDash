<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SnapshotAdded extends Notification
{
    use Queueable;

    protected $snapshot;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($snapshot)
    {
        $this->snapshot = $snapshot;
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
                ->content('A new snapshot taken - ('.$notifiable->slug().')')
                ->attachment(function ($attachment) {
                    $attachment->title('Snapshot '.$this->snapshot['SNAPSHOTID'])
                               ->fields($this->snapshot);
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
        return $this->snapshot;
    }
}
