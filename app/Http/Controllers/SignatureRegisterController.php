<?php

namespace App\Http\Controllers;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use App\Http\Requests\SignatureRegisterRequest;
use App\Http\Resources\Signature as SignatureResource;
use App\Models\Signature;
use Intervention\Image\Facades\Image;

class SignatureRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\SignatureRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SignatureRegisterRequest $request)
    {
        $signatureImageBase = $request->input('signature');

        $signatureImageInstance = Image::make($signatureImageBase);

        $signature = new Signature();
        $signature->fill($request->all());
        $signature->type = SignatureType::PUBLIC();
        $signature->status = SignatureStatus::PUBLISHED();
        $signature->signature_path = 'ttd-example.png';

        $signature->save();

        return new SignatureResource($signature);
    }
}
