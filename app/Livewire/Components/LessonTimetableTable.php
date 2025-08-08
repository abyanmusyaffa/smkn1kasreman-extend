<?php

namespace App\Livewire\Components;

use App\Models\Group;
use App\Models\Staff;
use Livewire\Component;
use App\Models\LessonSession;
use App\Models\LessonTimetable;
use Livewire\Attributes\Reactive;

class LessonTimetableTable extends Component
{
    public $selectedGroup = null;
    public $selectedTeacher = null;
    
    public $groups = [];
    public $teachers = [];
    public $days = []; 
    
    public $schedules = [];
    public $lessonSessions = [];

    public function mount()
    {
        // Load all groups that have timetables
        $this->groups = Group::whereHas('lesson_timetables')
            ->orderBy('name')
            ->get();
        
        // Load all teachers who have timetables
        $this->teachers = Staff::where('category', 'teacher')
            ->whereHas('lesson_timetables')
            ->orderBy('name')
            ->get();
        
        // Load lesson sessions
        $this->lessonSessions = LessonSession::orderBy('type')->orderBy('start_time')->get();

        $this->days = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa', 
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat'
        ];
        
        // Set default group (first available)
        // if ($this->groups->isNotEmpty()) {
        //     $this->selectedGroup = $this->groups->first()->id;
        // }
        
        // Load initial schedules
        $this->loadSchedules();
    }

    public function updatedSelectedGroup()
    {
        $this->selectedTeacher = null; // Reset teacher filter when group changes
        $this->loadSchedules();
        $this->dispatch('schedule-updated');
    }

    public function updatedSelectedTeacher()
    {
        $this->loadSchedules();
        $this->dispatch('schedule-updated');
    }

    public function filterByGroup($groupId)
    {
        $this->selectedGroup = $groupId;
        $this->selectedTeacher = null;
        $this->loadSchedules();
    }

    public function filterByTeacher($teacherId)
    {
        $this->selectedTeacher = $teacherId;
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $query = LessonTimetable::with(['subjects', 'staff', 'groups']);

        // Filter by group
        if ($this->selectedGroup) {
            $query->where('group_id', $this->selectedGroup);
        }

        // Filter by teacher
        if ($this->selectedTeacher) {
            $query->where('staff_id', $this->selectedTeacher);
        }

        $this->schedules = $query->get();
    }

    public function getSchedulesByDay($day)
    {
        return $this->schedules->where('day', $day)->sortBy(function ($schedule) {
            if (!$schedule->lesson_session || !is_array($schedule->lesson_session)) {
                return 999;
            }
            
            $firstSessionId = $schedule->lesson_session[0] ?? null;
            $session = $this->lessonSessions->where('id', $firstSessionId)->first();
            return $session ? $session->start_time : '99:99';
        });
    }

    public function getSessionsText($lessonSessionIds)
    {
        if (!$lessonSessionIds || !is_array($lessonSessionIds)) {
            return '-';
        }

        $sessions = $this->lessonSessions->whereIn('id', $lessonSessionIds)->sortBy('start_time');
        
        if ($sessions->isEmpty()) {
            return '-';
        }

        return $sessions->map(function ($session) {
            return $session->number . ' (' . $session->start_time . '-' . $session->end_time . ')';
        })->join(', ');
    }
    
    public function render()
    {
        return view('livewire.components.lesson-timetable-table');
    }
}
