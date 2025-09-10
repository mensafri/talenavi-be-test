<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todos = [
            [
                'title' => 'Finish Laravel project',
                'assignee' => 'Alice',
                'due_date' => Carbon::now()->addDays(3)->toDateString(),
                'time_tracked' => 120,
                'status' => 'pending',
                'priority' => 'high',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Write documentation',
                'assignee' => 'Bob',
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'time_tracked' => 60,
                'status' => 'open',
                'priority' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Review pull requests',
                'assignee' => null,
                'due_date' => Carbon::now()->addDays(1)->toDateString(),
                'time_tracked' => 30,
                'status' => 'in_progress',
                'priority' => 'low',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('todos')->insert($todos);
    }
}
