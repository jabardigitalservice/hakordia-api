<?php

namespace App\Http\Controllers;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use App\Http\Requests\SignatureRegisterRequest;
use App\Http\Resources\Signature as SignatureResource;
use App\Models\Signature;
use Illuminate\Support\Facades\Storage;
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
        $signature = new Signature();
        $signature->fill($request->all());
        $signature->sequence = 1000;
        $signature->type = SignatureType::PUBLIC();
        $signature->status = SignatureStatus::PUBLISHED();
        $signature->save();

        if ($request->filled('signature') === false) {
            return new SignatureResource($signature);
        }

        $fileName = Hashids::encode($signature->id) . '.png';

        $this->saveSignature($request->input('signature'), $fileName);

        $signature->signature_path = $fileName;
        $signature->save();

        return new SignatureResource($signature);
    }

    protected function saveSignature($imageBase64, $fileName): void
    {
        $signatureImageBase = $imageBase64;
        $signatureImageBaseInstance = Image::make($signatureImageBase);

        $this->saveOriginalSignature($signatureImageBaseInstance, $fileName);
        $this->saveCompositeImage($signatureImageBaseInstance, $fileName);
    }

    protected function saveOriginalSignature(\Intervention\Image\Image $canvasSignatureInstance, $fileName): void
    {
        $disk = Storage::cloud();

        $filePath = "signatures/{$fileName}";

        $disk->put($filePath, $canvasSignatureInstance->encode('png', 100));
    }

    protected function saveCompositeImage(\Intervention\Image\Image $signatureImageBaseInstance, $fileName): void
    {
        $canvasInstance = Image::canvas(925, 270);
        // $canvasInstance->fill('#fbfbfb');

        $handVectorInstance = Image::make(storage_path('app/vector/Kiri_Merah.png'));
        $handVectorInstance->rotate('45');

        $canvasInstance->insert($handVectorInstance, 'center');
        $canvasInstance->insert($signatureImageBaseInstance);

        $disk = Storage::cloud();

        $filePath = "gen/{$fileName}";

        $disk->put($filePath, $canvasInstance->encode('png', 100));
    }
}
