<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Company;
use App\Models\User;
use App\Models\Site;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entity_type')->insert([
            [
                'name' => 'site',
                'collection_name' => Site::class,
            ],
            [
                'name' => 'user',
                'collection_name' => User::class,
            ],
            [
                'name' => 'company',
                'collection_name' => Company::class,
            ]
        ]);
    }
}
