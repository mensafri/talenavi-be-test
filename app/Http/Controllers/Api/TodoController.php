<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\TodosExport;
use Maatwebsite\Excel\Facades\Excel;

class TodoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_date' => 'required|date|after_or_equal:today',
            'time_tracked' => 'nullable|numeric|min:0',
            'status' => ['nullable', 'string', Rule::in(['pending', 'open', 'in_progress', 'completed'])],
            'priority' => ['required', 'string', Rule::in(['low', 'medium', 'high'])],
        ]);

        // Set default status if not provided
        if (empty($validated['status'])) {
            $validated['status'] = 'pending';
        }

        $todo = Todo::create($validated);

        return response()->json($todo, 201);
    }

    /**
     * Generate an Excel report of todos.
     */
    public function generateReport(Request $request)
    {
        $filters = $request->only(['title', 'assignee', 'status', 'priority']);

        return Excel::download(new TodosExport($filters), 'todos_report.xlsx');
    }
}
