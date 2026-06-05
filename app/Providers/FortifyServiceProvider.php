<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Modules\Account\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\LoginResponse as CustomLoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request): RedirectResponse
            {
                return redirect(auth()->user()->getRedirectRoute());
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $login = $request->input('username');

            $user = User::where('username', $login)
                ->orWhere('email', $login)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });
        // Fortify::authenticateUsing(function (Request $request) {
        //     $login = $request->input('username');

        //     $user = \Modules\Account\Models\User::where('username', $login)
        //         ->orWhereHas('student', function ($query) use ($login) {
        //             $query->where('nik', $login);
        //         })
        //         ->first();

        //     if ($user && Hash::check($request->password, $user->password)) {
        //         $isLoginByNik = optional($user->student)->nik === $login
        //                         && $user->username !== $login;

        //         if ($isLoginByNik) {
        //             session()->put('login_as_nik', true);
        //             session()->put('parent_student', $user->student->nisn);
        //         } else {
        //             session()->forget('login_as_nik');
        //             session()->forget('parent_student');
        //         }

        //         return $user;
        //     }

        //     return null;
        // });

        // RateLimiter::for('login', function (Request $request) {
        //     $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

        //     return Limit::perMinute(5)->by($throttleKey);
        // });

        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });
    }
}
