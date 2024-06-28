<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LineParkingRequest;
use App\Models\LineParking;
use App\Models\LineTrip;
use App\Models\User;
use App\Services\Paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LineParkingController extends Controller
{

    public function index()
    {
        $result = LineParking::where('line_trip_id', request('id'))
            ->with('parking')->get();
        return response()->success($result);
    }

    /*
        to complete the line Parkings table with:
            1 - drivers and buses
            2 - supervisors
    */
    public function store(LineParkingRequest $request)
    {
        $line_parkings = LineParking::whereRelation('line_trip', 'id', $request->validated('line_trip_id'))->get();
        foreach ($line_parkings as $line_parking) {
            $line_parking->trip_buses()->createMany($request->drivers);
            $line_parking->trip_supervisors()->createMany($request->supervisors);
        }
        return response()->success('', 'added successfully');
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $line_parking_id)
    {
        $line_parking = LineParking::whereId($line_parking_id)->firstOrFail();

        $validator = Validator::make(
            [
                'line_parking_id'   => $line_parking_id,
                'parking_id'        => $request->parking_id
            ],
            [
                'line_parking_id'   => 'required|exists:line_parkings,id',
                'parking_id'        => [
                    'exists:parkings,id',
                    Rule::unique('line_parkings')->where(
                        fn ($q) => $q->where('parking_id', $request->parking_id)
                            ->where('line_trip_id', $line_parking->line_trip_id)
                            ->where('id', '!=', $line_parking_id)
                    )
                ],
            ]
        );

        if ($validator->fails())
            return response()->error($validator->errors()->first());

        $line_parking->update(['parking_id' => $request->parking_id]);

        return response()->success('', 'تم التعديل بنجاج');
    }


    public function destroy($id)
    {
        //
    }
}
