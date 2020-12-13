<?php

use App\Enums\SignatureType;

return [
    'prefix' => [
        SignatureType::PIMPINAN()->value => env('HAKORDIA_PREFIX_PIMPINAN','PIMPINAN_'),
        SignatureType::INSPEKTORAT()->value => env('HAKORDIA_PREFIX_INSPEKTORAT', 'INSPEKTORAT_'),
        SignatureType::PIMPINAN_OPD()->value => env('HAKORDIA_PREFIX_PIMPINAN_OPD', 'PIMPINANOPD_'),
        SignatureType::WALIKOTA()->value => env('HAKORDIA_PREFIX_WALIKOTA', 'WALIKOTA_'),
    ]
];
