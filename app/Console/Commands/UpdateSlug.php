<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\GrandCategory;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Support\Str;

class UpdateSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stores = Store::all();
        foreach ($stores as $key => $value) {
            $value->slug = Str::slug($value->name);
            $value->save();
        }

        return Command::SUCCESS;
    }
}
