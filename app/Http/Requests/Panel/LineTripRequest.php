<?php

namespace App\Http\Requests\Panel;

use App\Models\LineTrip;
use App\Models\TripSupervisor;
use App\Rules\LineParkingRule;
use App\Rules\TripBusesRule;
use App\Rules\TripSupervisorsRule;
use App\Services\GeneralServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineTripRequest extends FormRequest
{
    // public $Supervisors = [];
    // public $Drivers     = [];
    // public $Buses       = [];
    // public $Parkings    = [];
    // protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    // public function prepareForValidation()
    // {
    //     if ($this->getMethod()   == 'POST') {
    //         $service = new GeneralServices();
    //         try {
    //             $this->Supervisors    = $service->convert_to_array($this->supervisors, 'supervisor_id');
    //             $this->Drivers        = $service->convert_to_array($this->drivers, 'driver_id');
    //             $this->Buses          = $service->convert_to_array($this->drivers, 'bus_id');
    //         } catch (\Throwable $th) {
    //             abort(404, 'missing arguments');
    //         }
    //         if (
    //             $service->check_duplicates($this->Supervisors) ||
    //             $service->check_duplicates($this->Drivers) ||
    //             $service->check_duplicates($this->Buses)
    //         )
    //             abort(404, 'test duplicate');
    //     }
    // }

    public function rules()
    {
        $id = request()->route('line_trip_id');

        $line_trip = LineTrip::findOrFail($id);

        return [
            'line_id'       => [
                'required',
                Rule::unique('line_trips')->where(fn($q)
                => $q->where('id','!=',$id)
                    ->where('trip_id',$line_trip->trip_id)
                    ->where('line_id',$line_trip->line_id)
                )
            ],
        ];
    }
}
