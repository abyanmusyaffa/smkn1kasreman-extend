<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WhatsAppQueueService
{
    protected $queueFile;

    public function __construct()
    {
        $this->queueFile = storage_path('app/whatsapp_queue.json');
        
        // Ensure directory exists
        if (!file_exists(storage_path('app'))) {
            mkdir(storage_path('app'), 0755, true);
        }
    }

    /**
     * Add notification to queue
     */
    public function addToQueue($phone, $message, $metadata = [])
    {
        try {
            // Read existing queue
            $queue = $this->readQueue();
            
            // Add new item
            $queue[] = [
                'phone' => $phone,
                'message' => $message,
                'metadata' => $metadata,
                'queued_at' => now()->toDateTimeString(),
                'retry_count' => 0,
            ];
            
            // Save queue
            $this->saveQueue($queue);
            
            Log::info('WhatsApp notification queued', [
                'phone' => $phone,
                'queue_size' => count($queue)
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to add to WhatsApp queue', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Add multiple notifications to queue
     */
    public function addBulkToQueue($items)
    {
        try {
            $queue = $this->readQueue();
            
            foreach ($items as $item) {
                if (isset($item['phone']) && isset($item['message'])) {
                    $queue[] = [
                        'phone' => $item['phone'],
                        'message' => $item['message'],
                        'metadata' => $item['metadata'] ?? [],
                        'queued_at' => now()->toDateTimeString(),
                        'retry_count' => 0,
                    ];
                }
            }
            
            $this->saveQueue($queue);
            
            Log::info('WhatsApp bulk notifications queued', [
                'count' => count($items),
                'queue_size' => count($queue)
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to add bulk to WhatsApp queue', [
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Get queue size
     */
    public function getQueueSize()
    {
        $queue = $this->readQueue();
        return count($queue);
    }

    /**
     * Clear queue
     */
    public function clearQueue()
    {
        try {
            file_put_contents($this->queueFile, json_encode([]));
            Log::info('WhatsApp queue cleared');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear WhatsApp queue', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Read queue from file
     */
    protected function readQueue()
    {
        if (!file_exists($this->queueFile)) {
            return [];
        }
        
        $content = file_get_contents($this->queueFile);
        $queue = json_decode($content, true);
        
        return is_array($queue) ? $queue : [];
    }

    /**
     * Save queue to file
     */
    protected function saveQueue($queue)
    {
        file_put_contents($this->queueFile, json_encode($queue, JSON_PRETTY_PRINT));
    }
}