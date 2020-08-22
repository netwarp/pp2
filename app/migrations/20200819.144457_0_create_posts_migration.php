<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App;

use Spiral\Migrations\Migration;

class CreatePostsMigrationMigration extends Migration
{
    /**
     * Create tables, add columns or insert data here
     */
    public function up(): void
    {
        $this->table('posts')
            ->addColumn('id', 'primary')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('image', 'string', [
                'nullable' => true
            ])
            ->addColumn('preview', 'text')
            ->addColumn('content', 'text')
            ->addColumn('status', 'string', [
                'nullable' => false,
                'default' => 'unpublished'
            ])
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
        $this->table('posts')->drop();
    }
}
