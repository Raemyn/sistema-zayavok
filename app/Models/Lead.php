<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\LeadStatus;


class Lead extends Model
{
use SoftDeletes;


protected $fillable = [
'name', 'email', 'phone', 'message', 'status', 'source_id'
];


protected $casts = [
'status' => LeadStatus::class,
];


public function source()
{
return $this->belongsTo(Source::class);
}


public function comments()
{
return $this->hasMany(Comment::class);
}
}