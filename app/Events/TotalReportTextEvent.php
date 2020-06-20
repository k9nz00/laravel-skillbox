<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TotalReportTextEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $dataToReport;
    public string $textToReport;

    /**
     * Create a new event instance.
     *
     * @param array $dataToReport
     */
    public function __construct(array $dataToReport)
    {
        $this->dataToReport = $dataToReport;
        $this->textToReport = $this->generateTextForReportToOnDisplay();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('reportText');
    }

    public function generateTextForReportToOnDisplay()
    {
        $message = 'По вашему запросу был сформироваан отчет с подсчетом количества разлиных сущностей на сайте.' . PHP_EOL;

        foreach ($this->dataToReport as $item) {
            $message .= $item[0] . '-' . $item[1] . PHP_EOL;
        }
        return $message;
    }
}
