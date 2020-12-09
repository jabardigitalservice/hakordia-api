<?php

namespace App\Http\Controllers;

use App\Http\Resources\Signature as SignatureResource;
use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureDetailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Signature $signature
     * @return \App\Http\Resources\Signature|\Illuminate\Http\Response
     */
    public function __invoke(Request $request, Signature $signature)
    {
        return new SignatureResource($signature);
    }
}
