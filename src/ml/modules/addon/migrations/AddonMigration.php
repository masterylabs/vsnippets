<?php

return;

class Masteryl_AddonMigration extends Masteryl_Migration
{
    protected $table = 'addons';

    public function up()
    {
        $this->increments('id')
        ->string('identifier')->unique()
        ->string('app_id')->unique()

        ->integer('product_id')->unsigned()
        ->integer('tag_id')->unsigned()
        ->integer('email_id')->unsigned()

        ->string('name')->nullable()
        ->string('description')->nullable()
        ->string('name_prepend')->nullable()
        ->string('name_append')->nullable()
        ->string('description_prepend')->nullable()
        ->string('description_append')->nullable()
        ->string('download_url')->nullable()
        ->boolean('active')
        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}