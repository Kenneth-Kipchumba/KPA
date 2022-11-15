<?php

namespace App\Models;

use \DateTimeInterface;
use App\Notifications\VerifyUserNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use Notifiable;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        '1' => 'UNPAID',
        '2' => 'PAID',
        '3' => 'BALANCE',
        '4' => 'INACTIVE',
        '5' => 'INVOICED',
        '6' => 'ELDER',
        '7' => 'DECEASED',
		'8' => 'PAID IN ADVANCE', 
    ];

    public const DESIGNATION_SELECT = [
        '1' => 'General Paediatrician',
        '2' => 'Nurses',
        '3' => 'Medical Officer',
        '4' => 'Clinical Officer',
        '5' => 'Registrar/ Student',
        '6' => 'Other (Specify)',
    ];

    public $table = 'users';

    public static $searchable = [
        'member_no',
        'name',
        'email',
        'phone',
    ];

    protected $appends = [
        'photo',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'date_registration',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'member_no',
        'name',
        'email',
        'phone',
        'board_reg_no',
        'designation',
        'designation_other',
        'specialization_id',
        'specialization_other',
        'workstation',
        'address',
        'location_id',
        'status',
        'id_no',
        'postal_address',
        'postal_code',
        'bio',
        'alt_email',
        'email_verified_at',
        'remember_token',
        'password',
        'date_registration',
        'approved',
        'latitude',
        'longitude',
        'custom_field_1',
        'custom_field_2',
        'custom_field_3',
        'custom_field_4',
        'custom_field_5',
        'custom_field_6',
        'custom_field_7',
        'custom_field_8',
        'custom_field_9',
        'custom_field_10',
        'custom_text_1',
        'custom_text_2',
        'custom_text_3',
        'custom_text_5',
        'custom_text_4',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            $registrationRole = config('panel.registration_default_role');
            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
        });
    }

    public function getStatusnameAttribute()
    {
        return $this::STATUS_SELECT[$this->attributes['status']];
    }

    public function getFulldetailsAttribute()
    {
        return $this->attributes['member_no']." - ".$this->attributes['name'];
    }


    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function studentTestResults()
    {
        return $this->hasMany(TestResult::class, 'student_id', 'id');
    }

    public function memberIncomes()
    {
        return $this->hasMany(Income::class, 'member_id', 'id');
    }

    public function memberCrmInvoices()
    {
        return $this->hasMany(CrmInvoice::class, 'member_id', 'id');
    }

    public function memberEventAttendances()
    {
        return $this->hasMany(EventAttendance::class, 'member_id', 'id');
    }

    public function studentsCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getDateRegistrationAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateRegistrationAttribute($value)
    {
        $this->attributes['date_registration'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
