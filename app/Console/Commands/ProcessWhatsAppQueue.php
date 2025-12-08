<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppService;

class ProcessWhatsAppQueue extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'whatsapp:process-queue';

    /**
     * The console command description.
     */
    protected $description = 'Process pending WhatsApp notifications from queue file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queueFile = storage_path('app/whatsapp_queue.json');
        $lockFile = storage_path('app/whatsapp_queue.lock');
        
        // Check if another process is running
        if (file_exists($lockFile)) {
            $lockTime = filemtime($lockFile);
            $currentTime = time();
            
            // If lock is older than 5 minutes, remove it (stuck process)
            if (($currentTime - $lockTime) > 300) {
                unlink($lockFile);
                Log::warning('Removed stuck WhatsApp queue lock file');
            } else {
                $this->info('Another process is running. Skipping...');
                return;
            }
        }
        
        // Create lock file
        file_put_contents($lockFile, time());
        
        try {
            // Check if queue file exists
            if (!file_exists($queueFile)) {
                $this->info('No pending WhatsApp notifications');
                unlink($lockFile);
                return;
            }
            
            // Read queue
            $queue = json_decode(file_get_contents($queueFile), true);
            
            if (empty($queue) || !is_array($queue)) {
                $this->info('Queue is empty');
                unlink($lockFile);
                return;
            }
            
            $this->info('Processing ' . count($queue) . ' notifications...');
            
            $whatsapp = app(WhatsAppService::class);
            $processed = [];
            $failed = [];
            
            // Process max 50 items per run (prevent timeout)
            $itemsToProcess = array_slice($queue, 0, 50);
            
            foreach ($itemsToProcess as $index => $item) {
                try {
                    // Validate item structure
                    if (!isset($item['phone']) || !isset($item['message'])) {
                        $this->error("Invalid item at index {$index}");
                        $processed[] = $index;
                        continue;
                    }
                    
                    // Send WhatsApp
                    $result = $whatsapp->send($item['phone'], $item['message']);
                    
                    if ($result) {
                        $this->info("✓ Sent to {$item['phone']}");
                        $processed[] = $index;
                    } else {
                        $this->error("✗ Failed to send to {$item['phone']}");
                        
                        // Check retry count
                        $retryCount = $item['retry_count'] ?? 0;
                        
                        if ($retryCount < 3) {
                            // Keep in queue with incremented retry count
                            $queue[$index]['retry_count'] = $retryCount + 1;
                            $queue[$index]['last_retry'] = now()->toDateTimeString();
                        } else {
                            // Max retries reached, remove from queue
                            $this->error("Max retries reached for {$item['phone']}");
                            $processed[] = $index;
                            $failed[] = $item;
                        }
                    }
                    
                    // Small delay to prevent rate limiting
                    usleep(100000); // 0.1 second
                    
                } catch (\Exception $e) {
                    $this->error("Exception for {$item['phone']}: " . $e->getMessage());
                    
                    Log::error('WhatsApp queue item failed', [
                        'item' => $item,
                        'error' => $e->getMessage()
                    ]);
                    
                    // Keep in queue for retry
                    $retryCount = $item['retry_count'] ?? 0;
                    if ($retryCount < 3) {
                        $queue[$index]['retry_count'] = $retryCount + 1;
                    } else {
                        $processed[] = $index;
                        $failed[] = $item;
                    }
                }
            }
            
            // Remove processed items
            foreach (array_reverse($processed) as $index) {
                unset($queue[$index]);
            }
            
            // Re-index array
            $queue = array_values($queue);
            
            // Save updated queue
            file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));
            
            // Log failed items
            if (!empty($failed)) {
                $failedFile = storage_path('app/whatsapp_failed.json');
                $existingFailed = [];
                
                if (file_exists($failedFile)) {
                    $existingFailed = json_decode(file_get_contents($failedFile), true) ?? [];
                }
                
                $existingFailed = array_merge($existingFailed, $failed);
                file_put_contents($failedFile, json_encode($existingFailed, JSON_PRETTY_PRINT));
            }
            
            $this->info('Processed: ' . count($processed));
            $this->info('Failed: ' . count($failed));
            $this->info('Remaining: ' . count($queue));
            
            Log::info('WhatsApp queue processed', [
                'processed' => count($processed),
                'failed' => count($failed),
                'remaining' => count($queue)
            ]);
            
        } catch (\Exception $e) {
            $this->error('Fatal error: ' . $e->getMessage());
            
            Log::error('WhatsApp queue processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        } finally {
            // Always remove lock file
            if (file_exists($lockFile)) {
                unlink($lockFile);
            }
        }
        
        return 0;
    }
}