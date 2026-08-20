<?php

namespace App\Enums\Domain;

enum SslStatusEnum: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
