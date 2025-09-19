<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainSeeder extends Seeder
{
    public function run()
    {
        DB::table('trains')->delete();
        
        $data = [
            [
                'name' => 'Trại đông',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Trại hè',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Học giả chung',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Nghiên cứu một học kỳ',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Học tập một năm học',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Bậc thầy',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Bác sĩ',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
            [
                'name' => 'Cử nhân',
                'note' => null,
                'publish' => 2,
                'order' => 2,
                'user_id' => 4504,
                'deleted_at' => null,
                'created_at' => Carbon::create(2025, 9, 19, 23, 10, 02),
                'updated_at' => Carbon::create(2025, 9, 20, 00, 04, 45),
            ],
        ];

        foreach ($data as $item) {
            DB::table('trains')->insertGetId($item);
        }

    }
}