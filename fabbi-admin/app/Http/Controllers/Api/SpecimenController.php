<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Enums\TypePatient;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpecimenRequest;
use App\Http\Resources\SpecimenResource;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\QuarantinePatient\QuarantinePatientRepository;
use App\Repositories\Specimen\SpecimenRepository;
use App\Repositories\TypePatient\TypePatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecimenController extends Controller
{
    protected $specimenRepository;
    protected $typePatientRepository;
    protected $patientRepository;
    protected $quarantinePatientRepository;

    /**
     * SpecimenController constructor.
     *
     * @param SpecimenRepository $specimenRepository
     */
    public function __construct(SpecimenRepository $specimenRepository,
                                TypePatientRepository $typePatientRepository,
                                PatientRepository $patientRepository,
                                QuarantinePatientRepository $quarantinePatientRepository
    )
    {
        $this->specimenRepository = $specimenRepository;
        $this->typePatientRepository = $typePatientRepository;
        $this->patientRepository = $patientRepository;
        $this->quarantinePatientRepository = $quarantinePatientRepository;
    }

    /**
     * Show list specimen.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $specimens = $this->specimenRepository->getPatientSpecimen($request->all());
        $collection = SpecimenResource::collection($specimens);
        if ($collection) {

            return response()->json(['data' => $collection],
                Response::HTTP_OK);
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
                'quarantine_id' => $request->quarantine_id,
                'date_infection' => $request->date_infection,
                'date_draw_blood' => $request->date_draw_blood,
                'date_test' => $request->date_test,
                'result_test' => $request->result_test,
                'address' => $request->address,
            ];
            $result = $this->specimenRepository->create($data);
            $quarantine = $this->quarantinePatientRepository->find($result->quarantine_id);
            //Find patient by id.
            $patient = $this->patientRepository->find($quarantine->patient_id);
            //Check patient if F0 ->update type patient.
            if ((int)$request->result_test === Constant::STATUS_POSITIVE && $result && $patient->type_patient !== TypePatient::CASE_F0) {
                $dataType = [
                    'type_patient' => TypePatient::CASE_F0,
                ];
                $this->patientRepository->updateTypePatient($patient->id, $dataType);
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
        DB::beginTransaction();
        try {
            $data = [
                'quarantine_id' => $request->quarantine_id,
                'date_infection' => $request->date_infection,
                'date_draw_blood' => $request->date_draw_blood,
                'date_test' => $request->date_test,
                'address' => $request->address,
                'result_test' => $request->result_test,
            ];
            if ($request->result_test === Constant::STATUS_NEGATIVE) {
                $data['date_infection'] = null;
            }
            $result = $this->specimenRepository->update($id, $data);
            //Find quarantine by id
            $quarantine = $this->quarantinePatientRepository->find($request->quarantine_id);
            //Find patient by quarantine.
            $patient = $this->patientRepository->find($quarantine->patient_id);

            if ((int)$request->result_test === Constant::STATUS_NEGATIVE && $patient->parent_id !== null) {
                //Find parent patient by quarantine.
                $parentPatient = $this->patientRepository->findWhere($patient->parent_id, 'id')->firstOrFail();
                $data = [
                    'type_patient' => (int)$parentPatient->type_patient + 1,
                ];
                // If result test = 0
                // update type patient based on type of parent patient +1
                $this->patientRepository->updateTypePatient($patient->id, $data);
            } else if ((int)$request->result_test === Constant::STATUS_POSITIVE) {
                $data = [
                    'type_patient' => TypePatient::CASE_F0,
                ];
                $this->patientRepository->updateTypePatient($patient->id, $data);
            }
            DB::commit();
            Log::info('Update Specimen>>>>>>>>>>>>>>$result' . $result);
            $collection = new SpecimenResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::commit();
            Log::info('Update Specimen>>>>>>>>>>>>>>$result' . $e->getMessage());
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
