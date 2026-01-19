<?php

namespace App\Exports;

use App\Models\Teacher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AttendanceMonthlyExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $month;
    protected $year;
    protected $workingDays;
    protected $rowNumber = 0;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
        $this->workingDays = $this->calculateWorkingDays();
    }

    protected function calculateWorkingDays()
    {
        $startDate = Carbon::createFromDate($this->year, $this->month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }

        return $workingDays;
    }

    public function collection()
    {
        return Teacher::active()
            ->with(['attendances' => function($q) {
                $q->whereMonth('date', $this->month)
                  ->whereYear('date', $this->year);
            }])
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Guru',
            'NIP',
            'Jabatan',
            'Hadir',
            'Terlambat',
            'Izin',
            'Sakit',
            'Alpha',
            'Persentase (%)',
        ];
    }

    public function map($teacher): array
    {
        $this->rowNumber++;
        
        $hadir = $teacher->attendances->where('status', 'hadir')->count();
        $terlambat = $teacher->attendances->where('status', 'terlambat')->count();
        $izin = $teacher->attendances->where('status', 'izin')->count();
        $sakit = $teacher->attendances->where('status', 'sakit')->count();
        $alpha = max(0, $this->workingDays - ($hadir + $terlambat + $izin + $sakit));
        $percentage = $this->workingDays > 0 
            ? round((($hadir + $terlambat) / $this->workingDays) * 100, 1) 
            : 0;

        return [
            $this->rowNumber,
            $teacher->name,
            $teacher->nip ?? '-',
            $teacher->position ?? '-',
            $hadir,
            $terlambat,
            $izin,
            $sakit,
            $alpha,
            $percentage . '%',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        return [
            // Header row styling
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0EA5E9'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // All cells border
            'A1:J' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
            ],
            // Center alignment for numeric columns
            'A2:A' . $lastRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'E2:J' . $lastRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 30,  // Nama Guru
            'C' => 15,  // NIP
            'D' => 20,  // Jabatan
            'E' => 10,  // Hadir
            'F' => 12,  // Terlambat
            'G' => 10,  // Izin
            'H' => 10,  // Sakit
            'I' => 10,  // Alpha
            'J' => 15,  // Persentase
        ];
    }

    public function title(): string
    {
        $monthName = Carbon::createFromDate($this->year, $this->month, 1)->isoFormat('MMMM');
        return "Rekap {$monthName} {$this->year}";
    }
}
