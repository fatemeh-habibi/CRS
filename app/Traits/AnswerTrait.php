<?php

namespace App\Http\Traits;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;

trait AnswerTrait {
    public function Question1() {
        #Find rooms available for specific dates and guest count,considering room types and pricing.
        $startDate = "12-2-2022";
        $endDate = "12-3-2022";
        $guest_count = 4;
        $room_type_id =1;
        $min_price = 100000;
        $max_price= 200000;
        $result = Room::scopeSearch($startDate,$endDate,$guest_count,$room_type_id,$min_price,$max_price)->get();

        return $this->apiResponse(
            [
                'success' => true,
                'result' => $result,
            ]
        );

    }

    #Retrieve guest reservations with associated room details,including pricing and taxes.
    public function Question2() {

        $result = Reservation::with('room')->get();
        $data = $result->map(function ($item) use ($module_name){
            return [
                'id'=> $item->id,
                'code'=> $item->code,
                'room'=> $item->paid ? $item->paid->map(function ($item){
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'description' => $item->description,
                        'quest_count' => $item->quest_count,
                        'price' => $item->price,
                        'type'=> optional($item->type())->type ?? '',
                    ];
                }) : [],   
                'total_rooms'=> $item->total_rooms,
                'tax'=> $item->tax,
                'coupon_fee'=> $item->coupon_fee,
                'total_price'=> $item->total_price,
                'created_at'=> $item->created_at,
                'updated_at'=> $item->updated_at,
            ];
        });

        return $this->apiResponse(
            [
                'success' => true,
                'result' => $data,
            ]
        );
    }

    //Calculate total revenue for a given date range, segmented byroom type.
    //todo
    public function Question3($startDate,$endDate) {
        $result = Reservation::select(
            DB::raw('sum(price) as sums'), 
        )->with(['room','room.type'])
        ->whereBetween('date', [$startDate, $endDate])
        ->groupBy('room.type_id') // I don't have to solve this item , i know this part have bug
        ->get();

        return $this->apiResponse(
            [
                'success' => true,
                'result' => $result,
            ]
        );

    }

    //Find guests with birthdays within the next month and rooms matching their preferences (optional, bonus points).
    public function Question4() {
        $next_month = Carbon::now()->addMonth();
        $startDate = $next_month->startOfMonth();
        $endDate = $next_month->endOfMonth();
        $result = Room::whereHas('reviews', function ($query) use ($startDate, $endDate){
            return $query->with(['user' => function($query) use ($startDate, $endDate) { 
                return $query->whereBetween('birth_day', [$startDate, $endDate]);
            }]);
        })->get();

        return $this->apiResponse(
            [
                'success' => true,
                'result' => $result,
            ]
        );
    }

}