<?php

class Masteryl_EventMigration extends Masteryl_Migration
{
    protected $table = 'events';

    public function up()
    {
        $this->increments('id')
            ->string('name')->nullable()
            ->string('value')->nullable()
            ->string('cleint_ip')->nullable()
            ->text('data')->nullable()
            ->integer('created', 11)->nullable()
            ->integer('updated', 11)->nullable()
            ->boolean('archived')
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}