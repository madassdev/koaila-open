<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;

class OragnizationMemberInvitedNotification extends Notification
{
    use Queueable;

    public $user;
    public $generatedPassword;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, string $generatedPassword)
    {
        $this->user = $user;
        $this->generatedPassword = $generatedPassword;
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
        $email = $notifiable->email;
        // Prepare HTML content
        $loginDetailsContent = new HtmlString(
            "<div>
                <p>
                    Email: <strong>" . $email . "</strong>
                </p>
                <p>
                    Password: <strong>" . $this->generatedPassword . "</strong>
                </p>
            </div>"
        );

        return (new MailMessage)
            ->subject(ucfirst($this->user->company_name) . " - Invitation to collaborate")
            ->greeting('Accept invitation.')
            ->markdown('mail.notification.organization_member_invitation', ['user' => $this->user, 'generated_password' => $this->generatedPassword]);

    }
}