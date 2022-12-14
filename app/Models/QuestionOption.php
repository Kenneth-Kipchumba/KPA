<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;

    public $table = 'question_options';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function optionTestAnswers()
    {
        return $this->hasMany(TestAnswer::class, 'option_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
