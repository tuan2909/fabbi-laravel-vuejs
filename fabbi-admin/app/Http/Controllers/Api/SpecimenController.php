<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpecimenRequest;
use App\Http\Resources\SpecimenResource;
use App\Repositories\Specimen\SpecimenRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecimenController extends Controller
{
    protected $specimenRepository;

    /**
     * SpecimenController constructor.
     *
     * @param SpecimenRepository $specimenRepository
     */
    public function __construct(SpecimenRepository $specimenRepository)
    {
        $this->specimenRepository = $specimenRepository;
    }

    /**
     * Show list specimen.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $specimens = $this->specimenRepository->all();
            $collection = SpecimenResource::collection($specimens);

            return response()->json(['data' => $collection],
                Response::HTTP_FORBIDDEN);
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
    public function store(SpecimenRequest $request)
    {
        try {
            $data = [
                'patient_id' => $request->patient_id,
                'date_infection' => $request->date_infection,
                'date_draw_blood' => $request->date_draw_blood,
                'date_test' => $request->date_test,
                'result_test' => $request->result_test,
                'address' => $request->address,
            ];

            $result = $this->specimenRepository->create($data);
            $collection = new SpecimenResource($result);

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
            $city = $this->specimenRepository->find($id);
            $collection = new SpecimenResource($city);

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
    public function update(SpecimenRequest $request, $id)
    {
        try {
            $data = [
                'patient_id' => $request->patient_id,
                'date_infection' => $request->date_infection,
                'date_draw_blood' => $request->date_draw_blood,
                'date_test' => $request->date_test,
                'result_test' => $request->result_test,
                'address' => $request->address,
            ];
            $result = $this->specimenRepository->update($id, $data);
            $collection = new SpecimenResource($result);

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
            $result = $this->specimenRepository->delete($id);
            if ($result) {

                return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }
}
