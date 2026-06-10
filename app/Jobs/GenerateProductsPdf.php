<?php

namespace App\Jobs;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateProductsPdf implements ShouldQueue
{
    use Queueable;

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
        
        $products = Product::all();
        $pdf = Pdf::loadView('pdf.products', compact('products'));
        Storage::put(
            'reports/products.pdf',
            $pdf->output()
        );
        
    }
}
