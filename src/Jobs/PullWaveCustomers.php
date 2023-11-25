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
        $response = $wave->customers(['pageSize'=>200]);
        $presentWaveIds = [];
        do {
            foreach ($wave->getNodes() as $node) {
                $model = Customer::firstOrNew(['id'=>$node->id]);
                $model->fill([
                    'name' => $node->name,
                    'email' => $node->email,
                    'first_name' => $node->firstName,
                    'last_name' => $node->lastName,
                    'phone' => $node->phone,
                    'mobile' => $node->mobile,
                    'toll_free' => $node->tollFree,
                    'website' => $node->website,
                    'internal_notes' => $node->internalNotes,
                    'address' => $node->address,
                    'currency' => $node->currency,
                    'meta' => array_merge($model->meta ?? [],[
                        'outstandingAmount' => $node->outstandingAmount,
                        'overdueAmount' => $node->overdueAmount,
                        'shippingDetails' => $node->shippingDetails,
                    ])
                ]);
                $model->saveQuietly();

                // Add non-archived IDs to an array to enable archiving.
                if (!$node->isArchived) {
                    $presentWaveIds[] = $node->id;
                }
            }
        } while($response = $wave->paginate());
        // Once the loop is done, we can now archive those not present
        Customer::whereNotIn('id', $presentWaveIds)->get()->each->archive();

    }
}
