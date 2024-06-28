<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{

    public function toArray($request)
    {
        $is_completed = true;
        if (count($this->trips) > 0) {
            foreach ($this->trips as $key => $trips) {
                    if (count($trips->parkings) > 0) {
                        foreach ($trips->parkings as $key => $parkings) {
                            if (count($parkings->trip_buses) == 0 || count($parkings->trip_supervisors) == 0) {
                                $is_completed = false;
                                break;
                            }
                        }
                    } else {
                        $is_completed = false;
                        break;
                    }

            }
        } else {
            $is_completed = false;
        }
        return [
            'id'                    => $this->id,
            'type'                  => $this->type,
            'trip_start'            => $this->trip_start->format('H:i A'),
            // 'lines'                 => LinesResource::collection($this->lines),
            'day_id'                => $this->day_id,
            'is_completed'          => $is_completed,
            'day'                   => !isset($this->day->deleted_at) ?
                $this->day->name :  $this->day->name . '(هذا اليوم غير مفعل) ',
            'lines'                 => LineResource::collection($this->trips),
        ];
    }
}
