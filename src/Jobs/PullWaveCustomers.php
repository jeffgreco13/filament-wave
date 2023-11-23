<?php

namespace Jeffgreco13\FilamentWave\Jobs;

use Jeffgreco13\Wave\Wave;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Jeffgreco13\FilamentWave\Models\Customer;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PullWaveCustomers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wave = new Wave();
        $response = $wave->customers(['pageSize'=>20]);
        do {
            foreach ($wave->getNodes() as $node) {
                $customer = Customer::firstOrNew(['id'=>$node->id]);
                $customer->fill([
                    'name' => $node->name,
                    'email' => $node->email,
                    'first_name' => $node->firstName,
                    'last_name' => $node->lastName,
                    'phone' => $node->phone
                ]);
                $customer->saveQuietly();
            }
        } while($response = $wave->paginate());

    }
}
