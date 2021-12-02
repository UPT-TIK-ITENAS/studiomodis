<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RuanganCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start' => $this->begin_date,
            'end' => $this->end_date,
            'title' => $this->whenLoaded('ruangan', function () {
                return $this->ruangan[0]->nama;
            }) . " : " . $this->whenLoaded('user', function () {
                return $this->user->username;
            }),
        ];
    }
}
