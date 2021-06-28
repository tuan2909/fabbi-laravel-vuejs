<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Enums\TypePatient;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpecimenRequest;
use App\Http\Resources\SpecimenResource;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Specimen\SpecimenRepository;
use App\Repositories\TypePatient\TypePatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SpecimenController extends Controller
{
    protected $specimenRepository;
    protected $typePatientRepository;
    protected $patientRepository;

    /**
     * SpecimenController constructor.
     *
     * @param SpecimenRepository $specimenRepository
     */
    public function __construct(SpecimenRepository $specimenRepository,
                                TypePatientRepository $typePatientRepository,
                                PatientRepository $patientRepository)
    {
        $this->specimenRepository = $specimenRepository;
        $this->typePatientRepository = $typePatientRepository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Show list specimen.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $specimens = $this->specimenRepository->getPatientSpecimen();
        $collection = SpecimenResource::collection($specimens);
        if ($collection) {

            return response()->json(['data' => $collection],
                Response::HTTP_FORBIDDEN);
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
    public function store(SpecimenRequest $request)
    {
        DB::beginTransaction();
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
            //Find patient by id.
            $patient = $this->patientRepository->find($request->patient_id);
            //Find type_patient where number type = 0.
            $type = $this->typePatientRepository->findWhere(TypePatient::CASE_F0, 'number_type')->firstOrFail();
            //Check patient if F0 ->update type patient.
            if ((int)$request->result_test === Constant::STATUS_POSITIVE && $result && $patient->type_id !== $type->id) {
                $this->patientRepository->updateTypePatient($patient->id, $type->id);
            }
            $collection = new SpecimenResource($result);
            DB::commit();
            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
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
        $city = $this->specimenRepository->find($id);
        $collection = new SpecimenResource($city);
        if ($collection) {

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
    public function update(SpecimenRequest $request, $id)
    {
        try {
            $data = [
                'patient_id' => $request->patient_id,
                'date_infection' => $request->date_infection,
                'date_draw_blood' => $request->date_draw_blood,
                'date_test' => $request->date_test,
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
     * @return \Illuminate\Http\JsonResponse
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
