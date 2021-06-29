<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\HealthPatient\HealthPatientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HealPatientController extends Controller
{
    protected $healthPatientRepository;

    public function __construct(HealthPatientRepository $healthPatientRepository)
    {
        $this->healthPatientRepository = $healthPatientRepository;
    }

    public function getHealPatientByIdPatient($id)
    {
        $healPatient = $this->healthPatientRepository->findWhere($id, 'patient_id')->firstOrFail();

        if($healPatient){
            return response()->json(['data' => $healPatient], Response::HTTP_OK);
        }else{
            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }
}
