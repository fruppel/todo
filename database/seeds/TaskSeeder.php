<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{

    /**
     * Runs the database seeds
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        $this->clear();
        factory(App\Task::class, 30)->create();
    }

    /**
     * Clears all seeded data
     *
     * @return void
     *
     * @throws Exception
     */
    private function clear()
    {
        \App\Task::query()->delete();
    }
}