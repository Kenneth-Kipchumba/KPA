<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Specialization extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'specializations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function specializationUsers()
    {
        return $this->hasMany(User::class, 'specialization_id', 'id');
    }

    public function specializationEvents()
    {
        return $this->hasMany(Event::class, 'specialization_id', 'id');
    }

    public function specializationCourses()
    {
        return $this->hasMany(Course::class, 'specialization_id', 'id');
    }

    public function specializationWebinars()
    {
        return $this->hasMany(Webinar::class, 'specialization_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
