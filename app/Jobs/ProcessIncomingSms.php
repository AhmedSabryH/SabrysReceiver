<?php

namespace App\Jobs;

use App\Events\MessageForwarded;
use App\Models\SmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessIncomingSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = SmsMessage::create([
            'sender' => $this->data['from'] ?? null,
            'content' => $this->data['content'],
            'received_at' => now(),
        ]);

        broadcast(new MessageForwarded($sms));
    }
}
