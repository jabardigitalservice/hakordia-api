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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $records = Signature::query();

        $records->where('status', SignatureStatus::PUBLISHED());

        if ($request->filled('type')) {
            $type = $request->input('type');
            $explodeType = explode(',', $type);

            $records->whereIn('type', $explodeType);
        }

        if ($request->filled('search')) {
            $records->where(function ($query) use ($request) {
                $query->where('first_name', 'like', "%{$request->input('search')}%")
                    ->orWhere('last_name', 'like', "%{$request->input('search')}%");
            });
        }

        $orderBy = $request->input('order_by', 'created_at');
        $orderDirection = $request->input('order_dir', 'desc');

        $records->orderBy($orderBy, $orderDirection);

        return SignatureResource::collection($records->paginate());
    }
}
