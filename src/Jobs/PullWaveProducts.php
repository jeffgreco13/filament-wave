<?php

namespace Jeffgreco13\FilamentWave\Jobs;

use Jeffgreco13\Wave\Wave;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Jeffgreco13\FilamentWave\Models\Product;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PullWaveProducts implements ShouldQueue
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
        $response = $wave->products(['pageSize'=>200]);
        do {
            foreach ($wave->getNodes() as $node) {
                $model = Product::firstOrNew(['id'=>$node->id]);
                $model->fill([
                    'name' => $node->name,
                    'description' => $node->description,
                    'unit_price' => $node->unitPrice,
                    'is_sold' => $node->isSold,
                    'is_bought' => $node->isBought,
                    'taxes' => $node->defaultSalesTaxes,
                    'account' => $node->incomeAccount ?? $node->expenseAccount
                ]);
                $model->saveQuietly();
            }
        } while($response = $wave->paginate());

    }
}
