<?php

class Masteryl_BroadcastMigration extends Masteryl_Migration
{
    protected $table = 'broadcasts';

    public function up()
    {
        $this->increments('id')
            ->string('identifier')->unique()
            ->string('name')->nullable()
            ->string('description')->nullable()
            ->integer('sender_id')->unsigned()
            ->integer('email_id')->unsigned()
            ->string('schedule')->nullable()
            ->integer('schedule_ts')->nullable()
            ->boolean('schedule_active')->nullable()
            ->boolean('sent')->nullable()
            ->timestamps()
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}