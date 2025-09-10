<?php

namespace App\Exports;

use App\Models\Todo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TodosExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected $filters;
    protected $totalTodos;
    protected $totalTimeTracked;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Todo::query();

        // Apply filters
        if (!empty($this->filters['title'])) {
            $query->where('title', 'like', '%' . $this->filters['title'] . '%');
        }
        if (!empty($this->filters['assignee'])) {
            $query->where('assignee', 'like', '%' . $this->filters['assignee'] . '%');
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['priority'])) {
            $query->where('priority', $this->filters['priority']);
        }

        // Calculate summaries before returning the query
        $summaryData = $query->clone()->get();
        $this->totalTodos = $summaryData->count();
        $this->totalTimeTracked = $summaryData->sum('time_tracked');

        return $query;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Assignee',
            'Due Date',
            'Time Tracked (minutes)',
            'Status',
            'Priority',
        ];
    }

    public function map($todo): array
    {
        return [
            $todo->title,
            $todo->assignee,
            $todo->due_date,
            $todo->time_tracked,
            $todo->status,
            $todo->priority,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Dapatkan object sheet inti dari PhpSpreadsheet
                $sheet = $event->sheet->getDelegate();

                // Tentukan baris awal untuk menulis summary (setelah baris data terakhir + 1 baris kosong)
                $summaryStartRow = $sheet->getHighestRow() + 2;

                // Siapkan data summary dalam bentuk array
                $summaryData = [
                    ['Summary:'],
                    ['Total Number of Todos', $this->totalTodos],
                    ['Total Time Tracked (minutes)', $this->totalTimeTracked]
                ];

                // Tulis data summary ke sheet menggunakan fromArray()
                // null       => Nilai null tidak akan ditulis (cell akan kosong)
                // 'A' . $summaryStartRow => Koordinat awal untuk mulai menulis data
                $sheet->fromArray($summaryData, null, 'A' . $summaryStartRow);

                // (Opsional) Beri style bold pada teks summary
                $summaryEndRow = $summaryStartRow + count($summaryData) - 1;
                $sheet->getStyle("A{$summaryStartRow}:B{$summaryEndRow}")
                    ->getFont()->setBold(true);
            },
        ];
    }
}
