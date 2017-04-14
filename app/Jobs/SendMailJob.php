<?php

namespace App\Jobs;

use App\Mail\BindConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $content;
    /**
     * Create a new job instance.
     * @param $to
     * @param $content
     * @param $isRaw
     */
    public function __construct($to = 'abc@fushupeng.com', $content = [])
    {
        $this -> to = $to;
        $this -> content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this -> content['source']) {
            case 'github':
                $this -> content['source'] = 'GitHub';
                break;
            case 'weibo':
                $this -> content['source'] = '微博';
                break;
            case 'weixin':
                $this -> content['source'] = '微信';
                break;
            case 'qq':
                $this -> content['source'] = 'QQ';
                break;
            default:
                $this -> content['source'] = '';
                break;
        }
        $this -> content['url'] =
            sprintf(env('APP_URL') . env('BIND_EMAIL_URL_PREFIX'), $this -> content['id']);
        Mail::to($this -> to)
            -> send(new BindConfirmation($this -> content));
    }
}
