<?php

namespace Tests\Unit\Models\Graph;

use App\Models\Graph\TaskBurndown;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BurndownTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group tasks
     * @test
     */
    public function it_counts_the_remaining_tasks_per_minute_of_the_last_hour()
    {
        $user = User::factory()->create();
        //Given we have two uncompleted tasks and the time is in the 30th minute of the hour
        Carbon::setTestNow(now()->startOfHour()->addMinutes(30));
        $tasks1 = Task::factory()->create([
            'user_id' => $user->id
        ]);
        $tasks1->created_at = now()->startOfHour()->addMinutes(2);
        $tasks1->save(['timestamps' => false]);

        $tasks2 = Task::factory()->create([
            'user_id' => $user->id
        ]);
        $tasks2->created_at = now()->startOfHour()->addMinutes(5);
        $tasks2->save(['timestamps' => false]);

        //assert that in the 35th minute we still have 2 uncompleted tasks
        $tasks = (new TaskBurndown(now(), $user))->get();
        $this->assertEquals(2, $tasks[34]);

        //now if we completed a task at minute 35
        $tasks2->update(['completed_at' => now()->addMinutes(5)]);
        //we can assert that we now only have 1 task uncompleted at minute 35
        $tasks = (new TaskBurndown(now(), $user))->get();
        $this->assertEquals(1, $tasks[34]);

        //and we still have two tasks uncompleted by minute 34
        $this->assertEquals(2, $tasks[33]);
    }
}
