<?php

// namespace Modules\HRMS\Http\Controllers;

// use Illuminate\Http\Request;
// use Modules\Account\Enums\ReligionEnum;
// use Modules\Account\Enums\SexEnum;
// use Modules\HRMS\Models\Employee;
// use Modules\Reference\Models\Grade;

// class DashboardController extends Controller
// {
//     /**
//      * Show the dashboard page.
//      */
//     public function index(Request $request)
//     {
//         $grades = Grade::all()->keyBy('id');
//         $gradeMapping = [
//             'SLTA/SMA/MA/SEDERAJAT' => 1,
//             'Diploma III' => 2,
//             'Strata I' => 3,
//             'Strata II' => 4,
//             'Strata III' => 5,
//             'Kosong' => 6,
//         ];

//         $users = Employee::with('user.meta', 'contract.contract', 'position.position.department')->whereHas('contract')->get();

//       $employee_by_genders = collect($users)->mapToGroups(fn($e) => [
//             !is_null($e->user?->getMeta('profile_sex'))
//                 ? (SexEnum::tryFrom((int) $e->user->getMeta('profile_sex'))?->label() ?? 'Kosong')
//                 : 'Kosong' => $e
//         ])->map(fn($group) => $group->count())->toArray();

//         $employee_by_religions = collect($users)->mapToGroups(fn($e) => [
//             !is_null($e->user->getMeta('profile_religion')) ? ReligionEnum::tryFrom($e->user->getMeta('profile_religion'))->label() : 'Kosong' => $e
//         ])->map(fn($group) => $group->count())->toArray();

//         $employee_by_educations = collect($users)->mapToGroups(function ($e) use ($grades) {
//             $eduGrade = $e->user->getMeta('edu_grade');
//             $gradeName = !is_null($eduGrade) && $grades->has($eduGrade) ? $grades->get($eduGrade)->name : 'Kosong';
//             return [$gradeName => $e];
//         })->map->count()->toArray();


//         uksort($employee_by_educations, function ($key1, $key2) use ($gradeMapping) {
//             return $gradeMapping[$key1] <=> $gradeMapping[$key2];
//         });

//         $employee_by_contracts = collect($users)->mapToGroups(fn($e) => [
//             $e->contract?->contract->kd ? strtoupper($e->contract?->contract->kd) : 'Kosong' => $e
//         ])->map(fn($group) => $group->count())->toArray();

//         $employee_by_departements = collect($users)->mapToGroups(fn($e) => [
//             $e->position?->position->department->name ?: 'Kosong' => $e
//         ])->map(fn($group) => $group->count())->toArray();

//         return view('hrms::dashboard', compact('employee_by_genders', 'employee_by_contracts', 'employee_by_educations', 'employee_by_religions', 'employee_by_departements'));
//     }
// }
