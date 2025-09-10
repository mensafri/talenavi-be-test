<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function summary(Request $request)
    {
        $type = $request->query('type');

        switch ($type) {
            case 'status':
                return $this->statusSummary();
            case 'priority':
                return $this->prioritySummary();
            case 'assignee':
                return $this->assigneeSummary();
            default:
                return response()->json(['error' => 'Invalid summary type provided.'], 400);
        }
    }

    private function statusSummary()
    {
        $summary = Todo::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Ensure all possible statuses are present in the response
        $allStatuses = ['pending' => 0, 'open' => 0, 'in_progress' => 0, 'completed' => 0];
        $data = array_merge($allStatuses, $summary->toArray());

        return response()->json(['status_summary' => $data]);
    }

    private function prioritySummary()
    {
        $summary = Todo::query()
            ->select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Ensure all possible priorities are present
        $allPriorities = ['low' => 0, 'medium' => 0, 'high' => 0];
        $data = array_merge($allPriorities, $summary->toArray());

        return response()->json(['priority_summary' => $data]);
    }

    private function assigneeSummary()
    {
        $summary = Todo::query()
            ->select(
                'assignee',
                DB::raw('COUNT(*) as total_todos'),
                DB::raw("SUM(CASE WHEN status != 'completed' THEN 1 ELSE 0 END) as total_pending_todos"),
                DB::raw("SUM(CASE WHEN status = 'completed' THEN time_tracked ELSE 0 END) as total_timetracked_completed_todos")
            )
            ->whereNotNull('assignee')
            ->groupBy('assignee')
            ->get()
            ->keyBy('assignee') // Use assignee name as the key
            ->map(function ($item) {
                // Cast to integer for clean JSON output
                return [
                    'total_todos' => (int)$item->total_todos,
                    'total_pending_todos' => (int)$item->total_pending_todos,
                    'total_timetracked_completed_todos' => (int)$item->total_timetracked_completed_todos,
                ];
            });

        return response()->json(['assignee_summary' => $summary]);
    }
}
