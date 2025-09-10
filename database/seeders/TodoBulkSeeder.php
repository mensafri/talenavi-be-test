<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TodoBulkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'open', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];
        $assignees = ['Alice', 'Bob', 'Charlie', 'Diana', 'Eve'];
        $todos = [];
        for ($i = 1; $i <= 30; $i++) {
            $todos[] = [
                'title' => 'Todo Task #' . $i,
                'assignee' => $assignees[array_rand($assignees)],
                'due_date' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
                'time_tracked' => rand(0, 480),
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('todos')->insert($todos);
    }
}
