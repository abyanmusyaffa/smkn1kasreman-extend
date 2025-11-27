<?php

namespace App\Events;

use Log;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\StudentHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendanceRecorded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        // public Attendance $attendance,
        // public Student $student,
        // public StudentHistory $studentHistory,
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('attendance-updates')
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    // public function broadcastAs(): string
    // {
    //     return 'AttendanceRecorded';
    // }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    // public function broadcastWith(): array
    // {
    //     return [
    //         'student' => [
    //             'id' => $this->student->id,
    //             'nis' => $this->student->nis,
    //             'name' => $this->student->name,
    //             'photo' => $this->student->photo,
    //             'class' => $this->studentHistory->groups->name ?? '-',
    //         ],
    //         'attendance' => [
    //             'id' => $this->attendance->id,
    //             'check_in_time' => $this->attendance->check_in_time 
    //                 ? $this->attendance->check_in_time->timezone('Asia/Jakarta')->format('H:i:s')
    //                 : null,
    //             'check_out_time' => $this->attendance->check_out_time 
    //                 ? $this->attendance->check_out_time->timezone('Asia/Jakarta')->format('H:i:s')
    //                 : null,
    //             'status' => $this->attendance->status,
    //         ],
    //         'timestamp' => now()->timezone('Asia/Jakarta')->toIso8601String(),
    //     ];
    // }

    /**
     * Determine if this event should broadcast.
     *
     * @return bool
     */
    // public function broadcastWhen(): bool
    // {
    //     // Only broadcast if we have valid student data
    //     return $this->student && $this->studentHistory;
    // }
}
// class AttendanceRecorded
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public $attendance;
//     public $student;
//     public $studentHistory;
//     // public $action;
//     public $statistics;

//     public function __construct(Attendance $attendance, Student $student,StudentHistory $studentHistory,array $statistics) 
//     {
//         $this->attendance = $attendance;
//         $this->student = $student;
//         $this->studentHistory = $studentHistory;
//         $this->statistics = $statistics;
//     }

//     /**
//      * Get the channels the event should broadcast on.
//      *
//      * @return array<int, \Illuminate\Broadcasting\Channel>
//      */
//     public function broadcastOn(): array
//     {
//         return new Channel('attendance-updates');
//         // return [
//         //     new PrivateChannel('channel-name'),
//         // ];
//     }

//     public function broadcastAs()
//     {
//         return 'attendance.recorded';
//     }

//     public function broadcastWith()
//     {
//         return [
//             'attendance' => [
//                 'id' => $this->attendance->id,
//                 'check_in_time' => $this->attendance->check_in_time 
//                     ? $this->attendance->check_in_time->timezone('Asia/Jakarta')->format('H:i:s')
//                     : null,
//                 'check_out_time' => $this->attendance->check_out_time 
//                     ? $this->attendance->check_out_time->timezone('Asia/Jakarta')->format('H:i:s')
//                     : null,
//                 'status' => $this->attendance->status,
//                 'student' => [
//                     'nis' => $this->student->nis,
//                     'name' => $this->student->name,
//                     'class' => $this->studentHistory->groups->name ?? '-',
//                 ]
//             ],
//             'student' => [
//                 'id' => $this->student->id,
//                 'nis' => $this->student->nis,
//                 'name' => $this->student->name,
//                 'photo' => $this->student->photo,
//                 'class' => $this->studentHistory->groups->name ?? '-',
//             ],
//             'action' => $this->action, // 'check_in' or 'check_out'
//             'statistics' => $this->statistics,
//             'timestamp' => now()->timezone('Asia/Jakarta')->toIso8601String(),
//         ];
//     }
// }
