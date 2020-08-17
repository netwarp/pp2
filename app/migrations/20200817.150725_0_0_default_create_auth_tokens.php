<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefault24840a83e07d494cecd27b82e89eb445 extends Migration
{
    protected const DATABASE = 'default';

    public function up()
    {
        $this->table('auth_tokens')
            ->addColumn('id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 64
            ])
            ->addColumn('hashed_value', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 128
            ])
            ->addColumn('created_at', 'datetime', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('expires_at', 'datetime', [
                'nullable' => true,
                'default'  => null
            ])
            ->addColumn('payload', 'binary', [
                'nullable' => false,
                'default'  => null
            ])
            ->setPrimaryKeys(["id"])
            ->create();
    }

    public function down()
    {
        $this->table('auth_tokens')->drop();
    }
}
