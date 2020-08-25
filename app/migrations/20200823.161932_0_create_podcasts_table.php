<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App;

use Spiral\Migrations\Migration;

class CreatePodcastsTableMigration extends Migration
{
    /**
     * Create tables, add columns or insert data here
     */
    public function up(): void
    {
        $this->table('podcasts')
            ->addColumn('id', 'primary')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('source', 'string')
            ->addColumn('status', 'string')
            ->addColumn('content', 'text')
            ->addColumn('created_at', 'date', [
                'nullable' => false,
                'default' => date('Y-m-d H:i:s')
            ])
            ->addColumn('updated_at', 'date', [
                'nullable' => false,
                'default' => date('Y-m-d H:i:s')
            ])
            ->create();
    }

    /**
     * Drop created, columns and etc here
     */
    public function down(): void
    {
        $this->table('podcasts')->drop();
    }
}
