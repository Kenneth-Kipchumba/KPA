<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CrmInvoice extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public const STATUS_SELECT = [
        '1' => 'UNPAID',
        '2' => 'PAID',
        '3' => 'BALANCE',
        '4' => 'REVIEW',
        '5' => 'CANCELLED',
    ];

    public $table = 'crm_invoices';

    public static $searchable = [
        'invoice_no',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'invoice_no',
        'member_id',
        'rate_id',
        'amount',
        'paid',
        'balance',
        'discount',
        'notes',
        'items',
        'file',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function invoiceIncomes()
    {
        return $this->hasMany(Income::class, 'invoice_id', 'id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
