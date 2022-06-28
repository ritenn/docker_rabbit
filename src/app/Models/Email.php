<?php

namespace App\Models;

use App\Dictionary\EmailStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Email extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $appends = ['status_text'];

    /**
     * @param $notification
     *
     * @return mixed
     */
    public function routeNotificationForMail($notification)
    {
        return $this->recipient;
    }

    //Attributes

    /**
     * @return string|null
     */
    public function getStatusTextAttribute() : ?string
    {
        return EmailStatus::get($this->status);
    }
}
