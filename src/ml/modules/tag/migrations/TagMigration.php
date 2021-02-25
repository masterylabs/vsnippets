<?php

return;

class Masteryl_TagMigration extends Masteryl_Migration
{
    protected $table = 'tags';

    public function up()
    {
        $this->increments('id')
        ->string('name')->nullable()
        ->string('description')->nullable()
        ->string('is_id')->unique()
        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}