<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Question extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'questions';

    protected $appends = [
        'question_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'test_id',
        'question_text',
        'points',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function questionQuestionOptions()
    {
        return $this->hasMany(QuestionOption::class, 'question_id', 'id');
    }

    public function questionTestAnswers()
    {
        return $this->hasMany(TestAnswer::class, 'question_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function getQuestionImageAttribute()
    {
        $file = $this->getMedia('question_image')->last();
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
