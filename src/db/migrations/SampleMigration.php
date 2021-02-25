<?php
return;

class Masteryl_SampleMigration extends Masteryl_Migration
{
    protected $table = 'sample_items';

    public function up()
    {
        $this->increments('id')
        ->identifier()

        ->integer('some_id')->unsigned()
        
        ->sring('name')
        ->text('description')

        ->string('schedule')
        ->integer('schedule_ts')

        ->boolean('is_archived')
        ->boolean('is_active')

        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}
