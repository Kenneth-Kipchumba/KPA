<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public const LIST_SELECT = [
        '1' => 'CUSTOM LIST',
        '2' => 'ALL MEMBERS (ACTIVE)',
        '3' => 'PAID MEMBERS',
        '4' => 'UNPAID MEMBERS',
        '5' => 'INACTIVE MEMBERS',
    ];

    public $table = 'sms';

    public static $searchable = [
        'message',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'list',
        'custom_list',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
