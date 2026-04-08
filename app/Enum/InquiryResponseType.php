<?php

namespace App\Enum;

enum InquiryStatusType:string
{
    case MESSAGE = 'message';
    case UPDATES = 'updates';
    case SOLUTION = 'solution';
}
