<?php

namespace App\Http\Controllers;

use App\Http\Resources\Signature as SignatureResource;
use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureListController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $records = Signature::query();

        return SignatureResource::collection($records->paginate());
    }
}
