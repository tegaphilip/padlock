<?php

use Phinx\Migration\AbstractMigration;

class UsersMigration extends AbstractMigration
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
        if (!$this->hasTable('inec_wards') || !$this->hasTable('inec_polling_stations')
        || !$this->hasTable('states') || !$this->hasTable('inec_lgas') || $this->hasTable('users')) {
            return;
        }

        $this->table('users')
            ->addColumn('full_name', 'string', ['length' => 100, 'null' => false, 'encoding' => 'utf8mb4'])
            ->addColumn('email', 'string', ['length' => 100, 'null' => true, 'encoding' => 'utf8mb4'])
            ->addColumn('password', 'string', ['length' => 255, 'null' => false, 'encoding' => 'utf8mb4'])
            ->addColumn('phone', 'string', ['length' => 20, 'null' => false])
            ->addColumn('state_id', 'integer', ['length' => 11, 'null' => false])
            ->addColumn('lga_id', 'integer', ['length' => 11, 'null' => false])
            ->addColumn('ward_id', 'integer', ['length' => 11, 'null' => false])
            ->addColumn('station_id', 'integer', ['length' => 11, 'null' => false])

            ->addForeignKey('state_id', 'states', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('lga_id', 'inec_lgas', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('ward_id', 'inec_wards', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey(
                'station_id',
                'inec_polling_stations',
                ['id'],
                ['delete' => 'CASCADE', 'update' => 'CASCADE']
            )
            ->create();
    }
}
