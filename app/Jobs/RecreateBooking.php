<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\LocationReservations;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecreateBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Define the start of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        
        // Fetch all reservations where recurring is 1 and not canceled
        $reservations = Reservation::where('recurring', 1)->where('cancel', 0)->get();
        $locationReservations = LocationReservations::where('recurring', 1)->where('cancel', 0)->get();

        // Process each reservation
        foreach ($reservations as $reservation) {
            // Check if a reservation has already been created this week for the same user
            $existingThisWeek = Reservation::where('recurring', 1)
                                           ->where('cancel', 0)
                                           ->where('user_id', $reservation->user_id)
                                           ->where('created_at', '>=', $startOfWeek)
                                           ->exists();
                                           
            if (!$existingThisWeek) {
                // Create a new reservation based on the existing one
                $newReservation = $reservation->replicate();
                $newReservation->created_at = Carbon::now();  // Set the creation timestamp
                $newReservation->updated_at = Carbon::now();  // Set the update timestamp

                // Calculate the next occurrence of the specified day of the week
                $dayOfWeek = Carbon::parse($reservation->day_of_week)->dayOfWeek;
                $nextOccurrence = Carbon::now()->next($dayOfWeek);
                
                // Set the res_date to the calculated date at the recurring time
                $newReservation->res_date = $nextOccurrence->setTimeFromTimeString($reservation->recur_time);

                // Set the checkout_date to 23:59 of the res_date
                $newReservation->checkout_date = $newReservation->res_date->copy()->setTime(23, 59);

                $newReservation->save();
            }
        }

        // Process each location reservation
        foreach ($locationReservations as $locationReservation) {
            // Check if a location reservation has already been created this week for the same user
            $existingLocationThisWeek = LocationReservations::where('recurring', 1)
                                                            ->where('cancel', 0)
                                                            ->where('user_id', $locationReservation->user_id)
                                                            ->where('created_at', '>=', $startOfWeek)
                                                            ->exists();
                                                            
            if (!$existingLocationThisWeek) {
                // Create a new reservation based on the existing one
                $newLocationReservation = $locationReservation->replicate();
                $newLocationReservation->created_at = Carbon::now();  // Set the creation timestamp
                $newLocationReservation->updated_at = Carbon::now();  // Set the update timestamp

                // Calculate the next occurrence of the specified day of the week
                $dayOfWeek = Carbon::parse($locationReservation->day_of_week)->dayOfWeek;
                $nextOccurrence = Carbon::now()->next($dayOfWeek);
                
                // Set the res_date to the calculated date at the recurring time
                $newLocationReservation->res_date = $nextOccurrence->setTimeFromTimeString($locationReservation->recur_time);

                // Set the checkout_date to 23:59 of the res_date
                $newLocationReservation->checkout_date = $newLocationReservation->res_date->copy()->setTime(23, 59);

                $newLocationReservation->save();
            }
        }
    }
}
