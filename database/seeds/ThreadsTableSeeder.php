<?php

use App\Category;
use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->categories()->content();
        Schema::enableForeignKeyConstraints();
    }
    /**
     * Seed the channels table.
     */
    protected function categories()
    {
        Category::truncate();
        factory(Category::class, 10)->create();
        return $this;
    }
    /**
     * Seed the thread-related tables.
     */
    protected function content()
    {
        Thread::truncate();
        Reply::truncate();
        factory(Thread::class, 50)->create();
    }
}
