<?php

use Phinx\Migration\AbstractMigration;

class InecPollingStationsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        if (!$this->hasTable('inec_wards') || $this->hasTable('inec_polling_stations')) {
            return;
        }

        $this->table('inec_polling_stations')
            ->addColumn('name', 'string', ['length' => 100, 'null' => false, 'encoding' => 'utf8mb4'])
            ->addColumn('ward_id', 'integer', ['length' => 11])
            ->addColumn('inec_station_id', 'integer', ['length' => 11, 'comment' => 'id from inec db'])
            ->addForeignKey('ward_id', 'inec_wards', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
