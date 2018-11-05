<?php

namespace vultrui;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Cmgmyr\Messenger\Traits\Messagable;


class User extends Authenticatable
{
    use Notifiable, HasRoles, Messagable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function prefer_slack(){

        if ( config('app.slack_webhook_url') !== FALSE && config('app.slack_webhook_url') !== '' )
        {
            
            return true;
        }

        return false;
    }

    public function slug(){

       return ( $this->firstname === '' || $this->lastname === '' ) ? $this->emailSlug() : ucwords( $this->firstname.' '.$this->lastname );
    }

    public function emailSlug(){

        $emailSlug = preg_match( "/^(?P<slug>([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9])\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/m", $this->email, $slug);

        if ( $emailSlug )
        {

            return '@'.$slug['slug'];
        }

        return $this->email;
    }


    public function routeNotificationForSlack() {

        return config('app.slack_webhook_url');

    }


}
