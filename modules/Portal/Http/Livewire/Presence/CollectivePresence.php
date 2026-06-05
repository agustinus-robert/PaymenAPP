<?php

namespace Modules\Portal\Http\Livewire\Presence;


use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Modules\Core\Enums\PositionTypeEnum;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Modules\HRMS\Enums\TeacherShiftEnum;
use Modules\HRMS\Models\Employee;
use Modules\HRMS\Models\EmployeeSchedule;
use Modules\Admin\Models\Post;
use Carbon\Carbon;
use Modules\Portal\Models\Event;
use Livewire\WithPagination;
use DB;
use Modules\HRMS\Models\EmployeeScheduleTeacher;
use Modules\HRMS\Models\EmployeeTeacherDuty;

class CollectivePresence extends Component
{
    use WithPagination;

    public $employees = [], $lessons = [], $duty = [];
    public $today;
    public $dutied = '';
    public $humas = '';

    public function mount(Request $request)
    {
        $month    = Carbon::parse($request->get('month', now()));
        $start_at = $month->copy()->startOfMonth()->addDays(20)->format('Y-m-d');
        $end_at   = $month->copy()->endOfMonth()->addDays(20)->format('Y-m-d');
        $type = PositionTypeEnum::GURU->value;
        $this->lessons = TeacherShiftEnum::cases();

        $today = Carbon::today()->toDateString();

        $this->dutied = EmployeeTeacherDuty::with('employee')
            ->whereNull('deleted_at')
            ->whereDate('start_at', '<=', $today)
            ->whereDate('end_at', '>=', $today)
            ->where('empl_id', $request->user()->employee->id)
            ->get()
            ->filter(function ($duty) use ($today) {
                $dates = is_array($duty->dates) ? $duty->dates : [];
                return !empty($dates[$today][0]) || !empty($dates[$today][1]);
            })
            ->first();

        $this->humas = $request->user()->employee->positions->first()->position->id;
        $this->duty = EmployeeTeacherDuty::with('employee')
            ->whereNull('deleted_at')
            ->whereDate('start_at', '<=', $today)
            ->whereDate('end_at', '>=', $today)
            ->get()
            ->filter(function ($duty) use ($today) {
                $dates = is_array($duty->dates) ? $duty->dates : [];
                return !empty($dates[$today][0]) || !empty($dates[$today][1]);
            });

        $this->employees = Employee::with([
            'user.meta',
            'position.position',
            'schedulesTeachers' => fn($schedule) => $schedule->whenMonth($request->get('month', date('Y-m'))),
        ])->when($type, fn($t) => $t->whereHas('position.position', fn($q) => $q->where('type', $type)))
        ->search($request->get('search'))->whenTrashed($request->get('trash'))->get();
    }


    public function presenceShortcut($id, $shift, $keyPresence)
    {
        $today = date('Y-m-d');
        $empSch = EmployeeScheduleTeacher::find($id);
        $dates = $empSch->dates;

        $todayArray = $dates[$today] ?? [];
        $keyPresence = (int) $keyPresence;

        $currentShift = (int) $shift;
        $previousShift = $currentShift - 1;

        $currentLessonId = $todayArray[$currentShift]['lesson'][0] ?? null;

        $shiftData = $todayArray[$currentShift] ?? [];
        $shiftData['lesson'] = [$keyPresence, true];
        $todayArray[$currentShift] = $shiftData;

        if ($previousShift >= 0 && isset($todayArray[$previousShift])) {
            $prevLessonId = $todayArray[$previousShift]['lesson'][0] ?? null;

            if ($prevLessonId == $currentLessonId) {
                $prevShiftData = $todayArray[$previousShift];
                $prevShiftData['lesson'] = [$keyPresence, true];
                $todayArray[$previousShift] = $prevShiftData;
            }
        }

        // simpan kembali ke model
        $dates->put($today, $todayArray);
        $empSch->dates = $dates;
        $empSch->save();

        $this->dispatch('alert-success', message: 'Data berhasil disimpan!');
        $this->dispatch('$refresh');
    }



    public function render()
    {
        return view('portal::livewire.presence.collective');
    }
}
