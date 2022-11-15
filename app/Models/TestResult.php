<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use Auditable;
    use HasFactory;

    public $table = 'test_results';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'test_id',
        'student_id',
        'score',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function testResultTestAnswers()
    {
        return $this->hasMany(TestAnswer::class, 'test_result_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
