<?php


class Masteryl_TaskMigration extends Masteryl_Migration
{

    protected $database = 'master';

    protected $table = 'tasks';

    public function up()
    {
        $this->increments('id')

        ->string('name')
        ->text('data')
        ->string('ref')
        
        ->integer('priority')->setDefault(0)
        ->integer('progress', 3)->setDefault(0)
        ->integer('scheduled', 11)->setDefault(0)

        ->boolean('in_progress')
        ->boolean('is_paused')
        ->boolean('is_complete')
        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}
