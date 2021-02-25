<?php

return;

class Masteryl_ProductMigration extends Masteryl_Migration
{
    protected $table = 'products';

    public function up()
    {
        $this->increments('id')
        ->string('identifier')->unique()
        ->string('app_id')->unique()
        ->string('slug')->unique()

        ->integer('tag_id')->unsigned()
        ->integer('email_id')->unsigned()
        ->integer('page_id')->unsigned()
        ->integer('promote_page_id')->unsigned()
        ->integer('download_id')->unsigned()

        ->string('name')->nullable()
        ->string('description')->nullable()
        ->string('image')->nullable()
        ->string('thumb')->nullable()
        ->string('poster')->nullable()
        ->string('tag_id')->nullable() // ??
        ->string('download_url')->nullable()
        ->string('promote_url')->nullable()

        ->integer('sender_id')->unsigned()
        ->integer('email_id')->unsigned()
        ->string('schedule')->nullable()
        ->integer('schedule_ts')->nullable()
        ->boolean('can_promote')
        ->boolean('promote_hot')
        ->boolean('active')
        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}