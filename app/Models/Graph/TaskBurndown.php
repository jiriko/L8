<?php

namespace App\Models\Graph;


use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskBurndown
{
    protected $date;
    protected $user;
    protected $tasks;

    public function __construct(Carbon $date, User $user)
    {
        $this->date = $date;
        $this->user = $user;
        $this->fetch();
    }

    public function get()
    {
        $range = [];
        $start = $this->date->startOfHour();
        $end = $this->date->copy()->endOfHour();
        while ($start->lt($end)) {
            $range[(int)$start->format('i')] = $this->countRemainingTask($start->format('U'));
            $start->addMinute();
        }
        return $range;
    }

    protected function fetch()
    {
        $this->tasks = Task::mine($this->user)
            ->whereBetween('created_at', [$this->date->startOfHour(), $this->date->copy()->endOfHour()])
            ->get();
    }

    protected function countRemainingTask($time)
    {
        return $this->tasks->filter(function ($task) use ($time) {
            return !$task->completed_at || (int)$task->completed_at->format('U') > (int)$time + 60 ;
        })->count();
    }
}
