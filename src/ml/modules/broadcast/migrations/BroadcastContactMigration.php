<?php

class Masteryl_BroadcastContactMigration extends Masteryl_Migration
{
    protected $table = 'broadcast_contact';

    public function up()
    {
        $this->increments('id')

            // pivot
            ->integer('broadcast_id')->unsigned()
            ->integer('contact_id')->unsigned()

            // first entry event ids
            ->integer('qued', 11)->nullable()
            ->integer('processed', 11)->nullable()
            ->integer('deferred', 11)->nullable()
            ->integer('delivered', 11)->nullable()
            ->integer('open', 11)->nullable()
            ->integer('click', 11)->nullable()
            ->integer('bounce', 11)->nullable()
            ->integer('dropped', 11)->nullable()
            ->integer('spamreport', 11)->nullable()
            ->integer('unsubscribe', 11)->nullable()
            ->integer('group_unsubscribe', 11)->nullable()
            ->integer('group_resubscribe', 11)->nullable()

            ->timestamps()
            ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}