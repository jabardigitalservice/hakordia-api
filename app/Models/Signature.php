<?php

namespace App\Models;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property \App\Enums\SignatureType $type
 * @property \App\Enums\SignatureStatus $status
 * @property string $signature_path
 * @property integer $sequence
 * @property integer $id
 */
class Signature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'email',
        'content', 'occupation_name', 'workplace_name', 'signature_path'
    ];

    protected $casts = [
        'type' => SignatureType::class,
        'status' => SignatureStatus::class,
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        $decodedId = Hashids::decode($value);

        if (count($decodedId) === 0) {
            return false;
        }

        return $this->where('id', $decodedId)->firstOrFail();
    }
}
