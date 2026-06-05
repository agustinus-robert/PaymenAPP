<?php

namespace App\Traits;

use Carbon\Carbon;

trait EventMeetTrait
{
    /**
     * Proses jadwal guru bentuk array mentah → ready untuk insert database.
     *
     * @param array $payload
     * @return array
     */
    public function processTeacherSchedules(array $payload): array
    {
        $emplId   = $payload['empl_id'] ?? null;
        $dates    = $payload['dates'] ?? [];
        $schedules = [];

        foreach ($dates as $date => $items) {
            foreach ($items as $item) {

                if (empty($item['lesson'][0]) || empty($item['rombel'][0])) {
                    continue;
                }

                $schedules[] = [
                    'empl_id'     => $emplId, // ← TAMBAHKAN INI
                    'teacher_id'  => $emplId,
                    'subject_id'  => $item['lesson'][0],   // lesson ID
                    'classroom_id'=> $item['rombel'][0],   // rombel/class ID
                    'start_at'    => $this->mergeDateTime($date, $item[0]),
                    'end_at'      => $this->mergeDateTime($date, $item[1]),
                    'day'         => Carbon::parse($date)->dayOfWeekIso,
                    'date'        => $date
                ];
            }
        }

        return $schedules;
    }

    /**
     * Menggabungkan tanggal + jam menjadi datetime MySQL.
     */
    private function mergeDateTime(string $date, string $time): string
    {
        return Carbon::parse($date . ' ' . $time)->format('Y-m-d H:i:s');
    }
}
