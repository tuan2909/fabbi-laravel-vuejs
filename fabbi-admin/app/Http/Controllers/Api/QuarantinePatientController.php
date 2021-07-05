<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuarantineRequest;
use App\Http\Requests\TypePatientStore;
use App\Http\Requests\TypePatientUpdate;
use App\Http\Resources\QuarantineResource;
use App\Http\Resources\TypePatientResource;
use App\Repositories\QuarantinePatient\QuarantinePatientRepository;
use App\Repositories\TypePatient\TypePatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuarantinePatientController extends Controller
{
    protected $quarantinePatientRepository;

    public function __construct(QuarantinePatientRepository $quarantinePatientRepository)
    {
        $this->quarantinePatientRepository = $quarantinePatientRepository;
    }

    /**
     * Get all type patient by item per_page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $quarantines = $this->quarantinePatientRepository->getDataQuarantines($request->keyword);
        $collection = QuarantineResource::collection($quarantines);

        if ($collection) {
            return response()->json(['data' => $collection], Response::HTTP_OK);
        } else {
            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuarantineRequest $request)
    {
        try {
            $result = $this->quarantinePatientRepository->create($request->all());
            $collection = new QuarantineResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $quarantine = $this->quarantinePatientRepository->find($id);
        $collection = new QuarantineResource($quarantine);
        if ($quarantine) {
            return \response()->json(['data' => $collection], Response::HTTP_OK);
        } else {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuarantineRequest $request, $id)
    {
        try {
            $result = $this->quarantinePatientRepository->update($id, $request->all());
            $collection = new QuarantineResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->quarantinePatientRepository->delete($id);
            if ($result) {

                return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }
}
