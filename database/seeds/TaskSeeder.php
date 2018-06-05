<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{

    private const EMAIL = 'johndoe@example.com';

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

        $user = factory(App\User::class)->create([
            'name' => 'John Doe',
            'email' => self::EMAIL,
            'password' => bcrypt('asdasd'),
        ]);

        factory(App\Task::class, 30)->create([
            'user_id' => $user->id
        ]);
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