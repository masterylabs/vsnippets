<?php
return;

class Masteryl_SampleModuleMigration extends Masteryl_Migration
{

    // protected $database = 'master';

    protected $table = 'module_samples';

    public function up()
    {
        $this->increments('id')

        ->string('name')
        ->text('data')
        ->integer('scheduled', 11)->setDefault(0)
        ->boolean('in_done')
        ->timestamps()
        ->create();
    }

    public function down()
    {
        $this->destroy();
    }
}
