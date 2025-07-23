<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Diskon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'nominal' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        // Set primary key
        $this->forge->addKey('id', true);
        
        // Add unique key untuk tanggal agar tidak ada duplikasi tanggal
        $this->forge->addUniqueKey('tanggal');
        
        // Create table
        $this->forge->createTable('diskon');
    }

    public function down()
    {
        $this->forge->dropTable('diskon');
    }
}