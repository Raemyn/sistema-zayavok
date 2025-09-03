<?php


namespace App\Enums;


enum LeadStatus: string
{
case NEW = 'new';
case IN_PROGRESS = 'in_progress';
case DONE = 'done';
case REJECTED = 'rejected';


public static function values(): array
{
return array_map(fn($c) => $c->value, self::cases());
}
}