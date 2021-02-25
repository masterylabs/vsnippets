<?php

class Masteryl_EmailMigration extends Masteryl_Migration
{
    protected $table = 'emails';

    public function up()
    {
        $this->increments('id')
            ->string('identifier')->unique()
            ->string('name')->nullable()
            ->text('description')->nullable()
            ->string('subject')->nullable()
            ->string('teaser')->nullable()
            ->text('body_html')->nullable()
            ->text('body_text')->nullable()
            ->boolean('active')->nullable()
            ->timestamps()
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}