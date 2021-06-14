<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypePatientResource;
use App\Repositories\TypePatient\TypePatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $typePatients = $this->typePatientRepository->paginate(Constant::ITEM_PER_PAGE);
            //TODO
//            $collection = TypePatientResource::collection($typePatients);

            return response()->json(['data' => $typePatients], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->name
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $typePatient = $this->typePatientRepository->find($id);
            $collection = new TypePatientResource($typePatient);

            return \response()->json(['data' => $collection], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = [
                'name' => $request->name
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
     * @return \Illuminate\Http\Response
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
