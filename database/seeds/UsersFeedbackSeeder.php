<?php

use App\Models\Admin\Feedback;
use Illuminate\Database\Seeder;

class UsersFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(Feedback::class, 30)->create();
    }
}
