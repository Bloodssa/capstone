<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryResponse extends Model
{
    protected $fillable = [
        'user_id',
        'warranty_inquiries_id',
        'message',
        'type',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'array'
    ];

    protected $touches = ['warrantyInquiries'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warrantyInquiries()
    {
        return $this->belongsTo(WarrantyInquiries::class);
    }
}
