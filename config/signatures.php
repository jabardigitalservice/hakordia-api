<?php

use App\Enums\SignatureType;

return [
    'prefix' => [
        SignatureType::PIMPINAN()->value => 'PIMPINAN',
        SignatureType::INSPEKTORAT()->value => 'INSPEKTORAT',
        SignatureType::PIMPINAN_OPD()->value => 'PIMPINANOPD',
        SignatureType::WALIKOTA()->value => 'WALIKOTA',
    ]
];
