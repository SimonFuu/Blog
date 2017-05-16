<?php

namespace App\Jobs;

use App\Mail\CommentsNofity;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCommentsNotifyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $toName;
    private $articleTitle;
    private $articleId;
    private $content;

    public function __construct($email = 'abc@fushupeng.com', $toName = '', $title = '', $id = 0, $content = '')
    {
        $this -> to = $email;
        $this -> toName = $toName;
        $this -> articleTitle = $title;
        $this -> articleId = $id;
        $this -> content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('start');
        Mail::to($this -> to)
            -> send(new CommentsNofity([
                'aid' => $this -> articleId,
                'title' => $this -> articleTitle,
                'name' => $this -> toName,
                'content' => $this -> content,
            ]));
    }
}
