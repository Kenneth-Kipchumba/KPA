<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Email extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public const LIST_SELECT = [
        '1' => 'CUSTOM LIST',
        '2' => 'ALL MEMBERS (ACTIVE)',
        '3' => 'PAID MEMBERS',
        '4' => 'UNPAID MEMBERS',
        '5' => 'INACTIVE MEMBERS',
    ];

    public $table = 'emails';

    public static $searchable = [
        'subject',
        'message',
    ];

    protected $appends = [
        'image',
        'attachments',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'list',
        'custom_list',
        'subject',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50)->nonQueued();
        $this->addMediaConversion('preview')->fit('crop', 120, 120)->nonQueued();
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
