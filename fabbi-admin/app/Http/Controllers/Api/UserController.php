<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Resources\UserResource;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $userRepository;
    protected $patientRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, PatientRepository $patientRepository)
    {
        $this->userRepository = $userRepository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Get lists users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = $this->userRepository->all();
            $collection = UserResource::collection($users);

            return \response()->json(['data' => $collection], Response::HTTP_OK);
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
            $user = $this->userRepository->find($id);
            $collection = new UserResource($user);

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
                'status' => $request->status,
                'role' => $request->role,
            ];
            $result = $this->userRepository->update($id, $data);

            return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
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
    public function store(UserStore $request)
    {
        try {
            $data = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "status" => $request->status,
                "role" => $request->role,
            ];
            $result = $this->userRepository->create($data);
            $collection = new UserResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = $this->patientRepository->findWhere($id, 'user_id')->count();
            if ($patient === 0) {
                $result = $this->userRepository->delete($id);

                return response()->json(['message' => trans('message.api.loading_data_true')], Response::HTTP_OK);
            } else {

                return response()->json(['errors' => trans('message.user.false_delete')], Response::HTTP_CONFLICT);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => trans('message.api.loading_data_false')],
                Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Get user info.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function user(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        if (!$user) {

            return response()->json('token is expired', Response::HTTP_FORBIDDEN);
        }

        return response()->json(['data' => $user], Response::HTTP_OK);
    }
}
