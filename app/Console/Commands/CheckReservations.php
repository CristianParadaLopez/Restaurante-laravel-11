<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Table;
use App\Models\Reservation;
use Carbon\Carbon;

class CheckReservations extends Command
{
    protected $signature = 'reservations:check';
    protected $description = 'Revisa las reservaciones y actualiza el estado de las mesas';

    public function handle()
    {
        $now = Carbon::now();

        // Encuentra las reservaciones pasadas
        $expiredReservations = Reservation::where('date', '<=', $now->toDateString())
            ->where('time', '<=', $now->toTimeString())
            ->get();

        foreach ($expiredReservations as $reservation) {
            // Actualiza la mesa a disponible
            $table = $reservation->table;
            if ($table) {
                $table->update(['status' => 'disponible']);
            }

            // Elimina la reservación
            $reservation->delete();
        }

        $this->info('Reservaciones vencidas procesadas correctamente.');
    }
}
