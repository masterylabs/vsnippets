<?php

class Masteryl_ContactMigration extends Masteryl_Migration
{
    protected $table = 'contacts';

    public function up()
    {
        $this->increments('id')
            ->string('identifier')->unique()
            ->string('first_name')->nullable()
            ->string('last_name')->nullable()
            ->string('email')->unique()
            ->string('phone')->nullable()
            ->boolean('email_confirmed')
            ->boolean('opted_out')
            ->boolean('blocked')
            ->timestamps()
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}