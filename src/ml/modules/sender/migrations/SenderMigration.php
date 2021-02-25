<?php

class Masteryl_SenderMigration extends Masteryl_Migration
{
    protected $table = 'senders';

    public function up()
    {
        $this->increments('id')
            ->string('identifier')->unique()
            ->string('name')->nullable()
            ->string('email')->nullable()
            ->string('reply_email')->nullable()
            ->timestamps()
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}