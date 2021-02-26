<?php

class Masteryl_VideoMigration extends Masteryl_Migration
{
    protected $table = 'videos';

    public function up()
    {
        $this->increments('id')
        ->identifier()        
        ->string('name')
        ->text('description')
        ->string('image')
        ->mediumtext('content')

        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}
