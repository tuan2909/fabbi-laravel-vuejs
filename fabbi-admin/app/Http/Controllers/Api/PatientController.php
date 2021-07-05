<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Repositories\HealthPatient\HealthPatientRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PatientController extends Controller
{
    protected $patientRepository;
    protected $healthPatientRepository;

    /**
     * PatientController constructor.
     * healthPatientRepository constructor.
     *
     * @param healthPatientRepository $healthPatientRepository
     * @param PatientRepository $patientRepository
     */
    public function __construct(
        PatientRepository $patientRepository,
        HealthPatientRepository $healthPatientRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->healthPatientRepository = $healthPatientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $patients = $this->patientRepository->getDataPatients($request->keyword);
        $collection = PatientResource::collection($patients);
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
    public function store(PatientRequest $request)
    {
        DB::beginTransaction();
        try {
            $dataPatient = $request->all();
            $result = $this->patientRepository->create($dataPatient);
            if ($result) {
                $dataPatient['patient_id'] = $result->id;
                $this->healthPatientRepository->create($dataPatient);
            }
            DB::commit();
            return response()->json(['data' => $result], Response::HTTP_OK);
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
        $patient = $this->patientRepository->getPatientBy($id);
        $collection = new PatientResource($patient);
        if ($patient) {

            return response()->json(['data' => $collection], Response::HTTP_OK);
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
    public function update(PatientRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $dataPatient = $request->all();
            $result = $this->patientRepository->update($id, $dataPatient);
            Log::info("Update patient>>>>>>>>>>>>>>$result" . $result);
            if ($result) {
                $dataPatient['patient_id'] = $id;
                $this->healthPatientRepository->deleteHealthPatient('patient_id', $id);
                $this->healthPatientRepository->create($dataPatient);
            }
            DB::commit();

            return response()->json(['data' => $result], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info("Update patient>>>>>>>>>>>>>>" . $e->getMessage());
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
        DB::beginTransaction();
        try {
            $result = $this->patientRepository->delete($id);
            if ($result) {
                //Delete health patient after delete patient
                $this->healthPatientRepository->deleteHealthPatient('patient_id', $id);
            }
            DB::commit();

            return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    public function getParentPatientByType($number)
    {
        $result = $this->patientRepository->getParentPatients($number);
        $collection = PatientResource::collection($result);
        if ($result) {

            return response()->json(['data' => $collection], Response::HTTP_OK);
        } else {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }
}
