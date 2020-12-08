<?php

namespace App\Models;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \App\Enums\SignatureType $type
 * @property \App\Enums\SignatureStatus $status
 */
class Signature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'phone_number', 'email',
        'content', 'occupation_name', 'workplace_name', 'signature_path'
    ];

    protected $casts = [
        'type' => SignatureType::class,
        'status' => SignatureStatus::class,
    ];
}
