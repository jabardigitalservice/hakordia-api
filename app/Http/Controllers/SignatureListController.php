<?php

namespace App\Http\Controllers;

use App\Enums\SignatureStatus;
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

        $records->where('status', SignatureStatus::PUBLISHED());

        if ($request->filled('type')) {
            $records->where('type', $request->input('type'));
        }

        $records->latest();

        return SignatureResource::collection($records->paginate());
    }
}
