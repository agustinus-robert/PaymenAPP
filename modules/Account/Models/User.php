<?php

namespace Modules\Account\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Searchable\Searchable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Web\Models\PayTransaction;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use \Modules\Poz\Models\UserOutlet;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Academic\Models\Student;
use Modules\HRMS\Models\Employee;
// use Laravel\Passport\HasApiTokens;
use Modules\Auth\Notifications\ForgotPasswordNotification;
use Modules\Account\Database\Factories\UserFactory;
use App\Models\Traits\HasRole;
use Modules\Core\Models\Traits\HasCompanyRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Account\Models\Traits\UserTrait;
use Modules\Account\Models\Traits\UserRBACTrait;
use Modules\Account\Models\Repositories\UserRepository;
use Modules\Academic\Models\StudentAchievement;


class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, Metable, Restorable, Userstamps, TwoFactorAuthenticatable, HasApiTokens, HasProfilePhoto, UserRBACTrait, UserRepository;

    protected $guard_name = 'web';
    /**
     * Define the meta table
     */
    public $metaTable = 'user_metas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'embark_id',
        'location',
        'image_name',
        'current_team_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'email_verified_at',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'display_name'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'name',
        'username'
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Specifies the user's FCM tokens
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->getDeviceTokens();
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
            ->orWhere('username', 'like', '%' . $term . '%');
        });
    }


    /*
    * profile data
    */
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id')->withDefault();
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    /*
    * generate password
    */

    // public static function generatePassword($length = 2)
    // {
    //     $list = ['adam', 'idris', 'nuh', 'hud', 'sholeh', 'ibrahim', 'luth', 'ismail', 'ishaq', 'yakub', 'yusuf', 'ayub', 'suaeb', 'musa', 'harun', 'zulkifli', 'daud', 'sulaiman', 'ilyas', 'ilyasa', 'yunus', 'zakariya', 'yahya', 'isa', 'muhammad'];
    //     return $list[rand(0, (count($list) - 1))] . substr(str_shuffle('123456789'), 0, $length);
    // }

    /**
     * Get the e-mail address where password reset links are sent.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgotPasswordNotification($token));
    }

    /**
     * Find the user instance for the given value.
     */
    public function findForPassport($value)
    {
        return $this->where((filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'username'), $value)->first();
    }

    /**
     * Interact with the user's password.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getOutletIdAttribute()
    {
        return \DB::table('user_employee_outlets')
            ->join('empls', 'user_employee_outlets.empl_id', '=', 'empls.id')
            ->where('empls.user_id', $this->user_id)
            ->value('outlet_id');
    }

    /**
     * Get display name attributes.
     */
    public function getDisplayNameAttribute()
    {
        return $this->is(Auth::user()) ? 'Your' : $this->name;
    }

    /**
     * Get profile avatar path attributes.
     */
  public function getProfileAvatarPathAttribute()
    {
        $filename = $this->getMeta('profile_avatar');

        $fullPath = public_path('uploads/' . $filename);

        return $this->relationLoaded('meta') && $filename && file_exists($fullPath)
            ? asset('uploads/' . $filename)
            : asset('img/users/default-img.png');
    }
    /**
     * get all FCM token from current user
     */
    public function getDeviceTokens()
    {
        return array_filter([$this->pushtoken->pluck('token')]);
    }

    /**
     * get all FCM token from current user
     */
    public function pushtoken()
    {
        return $this->hasMany(UserToken::class, 'user_id');
    }

    // public function student()
    // {
    //     return $this->hasOne(Student::class, 'user_id');
    // }



      /**
     * This has many achievements.
     */
    public function achievements () {
        return $this->hasMany(UserAchievement::class, 'user_id');
    }


    // public function role()
    // {
    //     return $this->hasOne(UserRole::class, 'user_id');
    // }

    /**
     * This has many logs.
     */
    public function logs()
    {
        return $this->hasMany(UserLog::class, 'user_id');
    }

    public function memberdonator()
    {
        return $this->hasOne(MemberDonator::class, 'user_id');
    }

    public function membervolunteer()
    {
        return $this->hasOne(MemberVolunteer::class, 'user_id');
    }

    public function memberpartnership()
    {
        return $this->hasOne(Memberpartnership::class, 'user_id');
    }

    public function modelable()
    {
        return $this->morphTo();
    }

    /**
     * Create log.
     */
    public function log($message, $modelable_type = null, $modelable_id = null)
    {
        $ip = getClientIp();
        $user_agent = getenv('HTTP_USER_AGENT');

        return $this->logs()->create(compact('message', 'modelable_type', 'modelable_id', 'ip', 'user_agent'));
    }

    public function getRedirectRoute(): string
    {
        return match ((int)$this->current_team_id) {
            1, 2 => route('portal::dashboard.index'),
            default => route('login'),
        };
    }

    public function sendSystemNotification(array $details)
    {
        $this->notify(new \App\Notifications\GlobalGenericNotification($details));
    }

    public static function broadcastSystemNotification(array $details)
    {
        $myId = auth()->id();
        $recipients = self::where('id', '!=', $myId)->get();

        if ($recipients->isNotEmpty()) {
            foreach ($recipients as $recipient) {
                $details['user_id_target'] = $recipient->id;

                $recipient->notify(new \App\Notifications\GlobalGenericNotification($details));
            }
        }
    }

    public function broadcastToSameOutlet(array $details, $outletId = null)
    {
        if (!$outletId) {
            $outletId = UserOutlet::whereHas('employee', function($q) {
                $q->where('user_id', $this->id);
            })->pluck('outlet_id')->first();
        }

        if (!$outletId) return;

        $recipients = self::whereHas('employee.outlets', function($q) use ($outletId) {
                $q->where('outlet_id', $outletId);
            })
            ->where('id', '!=', $this->id)
            ->get();

        if ($recipients->isNotEmpty()) {
            foreach ($recipients as $recipient) {
                $details['user_id_target'] = $recipient->id;
                $recipient->notify(new \App\Notifications\GlobalGenericNotification($details));
            }
        }
    }

    public function balance(): HasOne
    {
        return $this->hasOne(UserBalance::class, 'user_balance_id')->latestOfMany();
    }

    public function token(): HasOne
    {
        return $this->hasOne(UserToken::class, 'user_id');
    }
}
