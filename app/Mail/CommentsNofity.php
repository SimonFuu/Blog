<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentsNofity extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     * @param $data
     */
    public function __construct($data = [])
    {
        $this -> data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('有人回复了您在' . env('APP_URL') . '发布的评论！')
            ->view('mail.commentNotify');
    }
}
