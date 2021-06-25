<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypePatientResource;
use App\Repositories\TypePatient\TypePatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\TypePatientStore;
use App\Http\Requests\TypePatientUpdate;

class TypePatientController extends Controller
{
    protected $typePatientRepository;

    public function __construct(TypePatientRepository $typePatientRepository)
    {
        $this->typePatientRepository = $typePatientRepository;
    }

    /**
     * Get all type patient by item per_page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $typePatients = $this->typePatientRepository->getDataTypePatient($request->keyword);
        $collection = TypePatientResource::collection($typePatients);

        if ($typePatients) {
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
    public function store(TypePatientStore $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'number_type' => $request->numbertype,
            ];
            $result = $this->typePatientRepository->create($data);
            $collection = new TypePatientResource($result);

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
        $typePatient = $this->typePatientRepository->find($id);
        $collection = new TypePatientResource($typePatient);
        if ($typePatient) {
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
    public function update(TypePatientUpdate $request, $id)
    {
        try {
            $data = [
                'name' => $request->name,
                'number_type' => $request->numbertype,
            ];
            $result = $this->typePatientRepository->update($id, $data);
            $collection = new TypePatientResource($result);

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
            $result = $this->typePatientRepository->delete($id);
            if ($result) {

                return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }
}
