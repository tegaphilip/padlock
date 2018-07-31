<?php

use Phinx\Migration\AbstractMigration;

class WardMigration extends AbstractMigration
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
        if (!$this->hasTable('local_government_areas') || $this->hasTable('wards')) {
            return;
        }

        $this->table('wards')
            ->addColumn('name', 'string', ['length' => 100, 'null' => false, 'encoding' => 'utf8mb4'])
            ->addColumn('code', 'string', ['length' => 10, 'null' => true, 'encoding' => 'utf8mb4'])
            ->addColumn('lga_id', 'integer', ['length' => 11])
            ->addForeignKey('lga_id', 'local_government_areas', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
