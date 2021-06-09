<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Repositories\City\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    const ITEM_PER_PAGE = 15;

    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get all city by item per_page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $cities = $this->cityRepository->paginate(static::ITEM_PER_PAGE);
            $collection = CityResource::collection($cities);

            return response()->json(['data' => $collection], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => 'loading false'], Response::HTTP_FORBIDDEN);
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
            $result = $this->cityRepository->create($data);
            $collection = new CityResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Store false'], Response::HTTP_FORBIDDEN);
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
            $city = $this->cityRepository->find($id);
            $collection = new CityResource($city);

            return \response()->json(['data' => $collection], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => 'loading false'], Response::HTTP_FORBIDDEN);
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
            $result = $this->cityRepository->update($id, $data);
            $collection = new CityResource($result);

            return response()->json($collection, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Update false'], Response::HTTP_FORBIDDEN);
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
            $result = $this->cityRepository->delete($id);
            if ($result) {

                return response()->json(['message' => 'Delete Success'], Response::HTTP_OK);
            } else {

            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'Delete false'], Response::HTTP_FORBIDDEN);
        }
    }
}
