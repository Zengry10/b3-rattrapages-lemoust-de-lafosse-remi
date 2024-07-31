<?php

namespace App\Enum;

enum BasketStatusEnum: string
{
    case DRAFT = "draft";
    case COMPLETED = "completed";
    case CANCELLED = "cancelled";
    case VALIDATED = "validated";
}
