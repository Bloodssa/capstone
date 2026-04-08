<?php

namespace App\Models;

use App\Enum\InquiryStatusType;
use Illuminate\Database\Eloquent\Model;

class WarrantyInquiries extends Model
{
    protected $fillable = [
        'user_id',
        'warranty_id',
        'message',
        'status',
        'attachments'
    ];

    protected $casts = [
        'status' => InquiryStatusType::class,
        'attachments' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    public function responses()
    {
        return $this->hasMany(InquiryResponse::class);
    }
}
