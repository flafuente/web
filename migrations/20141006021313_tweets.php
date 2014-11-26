<?php

use Phinx\Migration\AbstractMigration;

class Tweets extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('tweets');
        $table->addColumn('tweet_id',   'biginteger',   array('limit' => 50))
            ->addColumn('tweet',        'string',   array('limit' => 200, 'default' => null, 'null' => true))
            ->addColumn('fecha',        'datetime', array('default' => null, 'null' => true))
            ->addColumn('nombre',       'string',   array('limit' => 100, 'default' => null, 'null' => true))
            ->addColumn('usuario',      'string',   array('limit' => 100, 'default' => null, 'null' => true))
            ->addColumn('foto',         'string',   array('limit' => 500, 'default' => null, 'null' => true))
            ->addColumn('nret',         'integer',  array('limit' => 12, 'default' => null, 'null' => true))
            ->addColumn('rt_name',      'string',   array('limit' => 200, 'default' => null, 'null' => true))
            ->addColumn('rt_image',     'string',   array('limit' => 200, 'default' => null, 'null' => true))
            ->addColumn('rt_usuario',   'string',   array('limit' => 200, 'default' => null, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
