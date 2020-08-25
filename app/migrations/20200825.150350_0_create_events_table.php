<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App;

use Spiral\Migrations\Migration;

class CreateEventsTableMigration extends Migration
{
    /**
     * Create tables, add columns or insert data here
     */
    public function up(): void
    {
        $this->table('events')
            ->addColumn('id', 'primary')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('date', 'string')
            ->create();
    }

    /**
     * Drop created, columns and etc here
     */
    public function down(): void
    {
        $this->table('events')->drop();
    }
}
