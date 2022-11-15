<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Income extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public const MODE_SELECT = [
        '1' => 'MPESA',
        '2' => 'CREDIT CARD',
        '3' => 'EFT / RTGS',
        '4' => 'CHEQUE',
        '5' => 'CASH',
        '6' => 'PESAPAL',
        '7' => 'OTHER',
    ];

    public $table = 'incomes';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'entry_date',
        'receipt_no',
        'member_id',
        'invoice_id',
        'amount',
        'income_category_id',
        'mode',
        'transaction_no',
        'notes',
        'items',
        'file',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function invoice()
    {
        return $this->belongsTo(CrmInvoice::class, 'invoice_id');
    }

    public function income_category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
