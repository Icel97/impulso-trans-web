<?php

namespace App\Console\Commands;

use App\Enums\SuscripcionStatusEnum;
use Illuminate\Console\Command;
use App\Models\Suscripcion;
use Carbon\Carbon;

class UpdateExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:actualizar'; 
        /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of expired subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Command started"); 

        $now = Carbon::now();
        $this->info("Current date: {$now}"); 
        $expiredSubscription = Suscripcion::whereNotNull('fecha_fin') 
            ->where('fecha_fin', '<', $now)
            ->where('estatus', SuscripcionStatusEnum::Activa)
            ->get();

        $this->info("Found {$expiredSubscription->count()} expired subscriptions"); 
        foreach ($expiredSubscription as $subscription) {
            $subscription->estatus = SuscripcionStatusEnum::Vencida;
            $subscription->save();
            $this->info("Subscription ID {$subscription->id} 'expired, has been updated"); 
        }

        $this->info("Command update:expired:subscriptions executed successfully"); 
    }
}
