<?php

namespace App\Http\Controllers;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use App\Http\Requests\SignatureRegisterRequest;
use App\Http\Resources\Signature as SignatureResource;
use App\Models\Signature;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Vinkla\Hashids\Facades\Hashids;

class SignatureRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\SignatureRegisterRequest $request
     * @return \App\Http\Resources\Signature|\Illuminate\Http\Response
     */
    public function __invoke(SignatureRegisterRequest $request)
    {
        Log::info('SIGNATURE_REGISTER_INIT', ['context' => $request->toArray()]);

        $token = $request->input('token');

        $signature = new Signature();
        $signature->fill($request->all());
        $signature->sequence = $this->getSequence($token);
        $signature->type = $this->getSignatureType($token);
        $signature->status = SignatureStatus::PUBLISHED();
        $signature->save();

        $fileName = Hashids::encode($signature->id) . '.png';

        $this->saveSignature($request->input('signature'), $fileName);

        $signature->signature_path = $fileName;
        $signature->save();

        Log::info('SIGNATURE_REGISTER_SUCCESS', ['context' => $signature->toArray()]);

        return new SignatureResource($signature);
    }

    protected function saveSignature($imageBase64, $fileName): void
    {
        $signatureImageBase = $imageBase64;
        $signatureImageBaseInstance = Image::make($signatureImageBase);

        $log = sprintf(
            "SIGNATURE_REGISTER_SAVE_SIGNATURE_ORIGINAL_PROCESS Filename: %s; Width: %s; Height: %s",
            $fileName,
            $signatureImageBaseInstance->width(),
            $signatureImageBaseInstance->height(),
        );

        Log::info($log);

        $signatureImageBaseInstance->heighten(270);

        $this->saveOriginalSignature($signatureImageBaseInstance, $fileName);
        $this->saveCompositeImage($signatureImageBaseInstance, $fileName);

        Log::info('SIGNATURE_REGISTER_SAVE_SIGNATURE_SUCCESS');
    }

    protected function saveOriginalSignature(\Intervention\Image\Image $canvasSignatureInstance, $fileName): void
    {
        $disk = Storage::cloud();

        $filePath = "signatures/{$fileName}";

        $disk->put($filePath, $canvasSignatureInstance->encode('png', 100));

        Log::info('SIGNATURE_REGISTER_SAVE_SIGNATURE_ORIGINAL_SUCCESS');
    }

    protected function saveCompositeImage(\Intervention\Image\Image $signatureImageBaseInstance, $fileName): void
    {
        $canvasInstance = Image::canvas(925, 270);
        // $canvasInstance->fill('#fbfbfb');

        $handVectorsFiles = $this->getListHandVectorFiles();
        $handVectorsSelected = Arr::random($handVectorsFiles);

        $handVectorInstance = Image::make(storage_path("app/vector/{$handVectorsSelected}"));
        $handVectorInstance->rotate(rand(-45, 45));

        $canvasInstance->insert($signatureImageBaseInstance, 'center');
        $canvasInstance->insert($handVectorInstance, 'center');

        $disk = Storage::cloud();

        $filePath = "gen/{$fileName}";

        $disk->put($filePath, $canvasInstance->encode('png', 100));

        Log::info('SIGNATURE_REGISTER_SAVE_SIGNATURE_COMPOSITE_SUCCESS');
    }

    protected function getSignatureType($inputToken)
    {
        $prefixes = config('signatures.prefix');

        foreach ($prefixes as $key => $prefix) {
            if (Str::startsWith($inputToken, $prefix)) {
                return SignatureType::make($key);
            }
        }

        return SignatureType::PUBLIC();
    }

    protected function getSequence($inputToken): int
    {
        preg_match('/^([A-Z_]+)(\d+)$/',$inputToken, $matches);

        if (count($matches) <> 3) {
            return 1000;
        }

        return (int) $matches[2];
    }

    protected function getListHandVectorFiles()
    {
        return [
          'Kanan_Biru.png',
          'Kanan_Hijau.png',
          'Kanan_Hitam.png',
          'Kanan_Merah.png',
          'Kanan_Orange.png',
          'Kiri_Biru.png',
          'Kiri_Hijau.png',
          'Kiri_Hitam.png',
          'Kiri_Merah.png',
          'Kiri_Orange.png',
        ];
    }
}
