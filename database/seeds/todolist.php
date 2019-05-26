<?php

use Illuminate\Database\Seeder;

class todolist extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todolist')->truncate();

        $date = date('Y-m-d H:i:s');
        
        DB::table('todolist')->insert([
            'title'=>str_random(10),
            'content'=>str_random(20),
            'created_at'=>$date,
            'updated_at'=>$date
        ]);

        factory(App\Todolist::class, 10)->create();
    }
}
