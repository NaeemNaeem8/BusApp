<?php

namespace App\Http\Requests\Panel;

use App\Models\LineParking;
use App\Rules\LineParkingRule;
use App\Rules\TripBusesRule;
use App\Rules\TripSupervisorsRule;
use App\Services\GeneralServices;
use Illuminate\Foundation\Http\FormRequest;

class LineParkingRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;
    private  $Drivers        = [];
    private  $Buses          = [];
    private  $Supervisors    = [];
    public   $lineParking;
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $ser = new GeneralServices();
        try {
            $this->Drivers           = $ser->convert_to_array($this->drivers, 'driver_id');
            $this->Buses             = $ser->convert_to_array($this->drivers, 'bus_id');
            $this->Supervisors       = $ser->convert_to_array($this->supervisors, 'supervisor_id');

        } catch (\Throwable $th) {
            abort(404, 'missing some arguments');
        }
        // $this->lineParking = LineParking::findOrFail($this->line_parking_id,['id','line_trip_id']);
        if (
            $ser->check_duplicates($this->Drivers) ||
            $ser->check_duplicates($this->Buses) ||
            $ser->check_duplicates($this->Supervisors)
        ) {
            abort(404, 'You can\'t duplicate drivers , buses and supervisors in the same parking');
        }
    }


    public function rules()
    {
        return [
            'line_trip_id'                  => ['required','exists:line_trips,id'],
            'drivers'                       => [
                'required', 'array',
                // new TripBusesRule($this->Drivers, $this->Buses,$this->lineParking->line_trip_id)
            ],
            'drivers.*.bus_id'              => ['required', 'exists:buses,id'],
            'drivers.*.driver_id'           => ['required', 'exists:drivers,id'],
            'supervisors'                   => [
                'required', 'array',
                // new TripSupervisorsRule($this->lineParking->line_trip_id, $this->Supervisors)
            ],
            'supervisors.*.supervisor_id'   => ['exists:supervisors,id'],
        ];
    }
}
