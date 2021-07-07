<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuarantineRequest;
use App\Http\Resources\QuarantineResource;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\QuarantinePatient\QuarantinePatientRepository;
use App\Repositories\Specimen\SpecimenRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuarantinePatientController extends Controller
{
    protected $quarantinePatientRepository;
    protected $patientRepository;
    protected $specimenRepository;

    public function __construct(QuarantinePatientRepository $quarantinePatientRepository,
                                PatientRepository $patientRepository, SpecimenRepository $specimenRepository)
    {
        $this->quarantinePatientRepository = $quarantinePatientRepository;
        $this->patientRepository = $patientRepository;
        $this->specimenRepository = $specimenRepository;
    }

    /**
     * Get all type patient by item per_page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $quarantines = $this->quarantinePatientRepository->getDataQuarantines($request->all());

        if ($quarantines) {
            return response()->json(['data' => $quarantines], Response::HTTP_OK);
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
            if ((int)$request->status === Constant::STATUS_OUT_QUARANTINE) {

                $specimen = $this->specimenRepository->checkSpecimenPatient($request->all());
                if ($specimen > Constant::NUMBER_CONDITION_POSITIVE) {

                    $result = $this->quarantinePatientRepository->update($id, $request->all());
                    $collection = new QuarantineResource($result);

                    return response()->json(['data' => $collection], Response::HTTP_OK);
                } else {

                    return response()->json(['errors' => trans('message.quarantine.condition_out_quarantine')],
                        Response::HTTP_FORBIDDEN);
                }
            }
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

    public function getListPatientNotQuarantine(Request $request)
    {
        $dataPatientQuarantine = [];
        $patientQuarantine = $this->quarantinePatientRepository->getPatientsQuarantine();
        foreach ($patientQuarantine as $item) {
            array_push($dataPatientQuarantine, $item->patient_id);
        }
        $result = $this->patientRepository->getListPatientNotQuarantine($dataPatientQuarantine);

        return response()->json(['data' => $result], Response::HTTP_OK);
    }
}
