<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

use Spiral\Database\Driver;

return [
    'default'   => 'default',
    'databases' => [
        'default' => ['driver' => 'mysql'],
    ],
    'drivers'   => [
        'runtime' => [
            'driver'     => Driver\SQLite\SQLiteDriver::class,
            'connection' => 'sqlite:' . directory('root') . 'app.db',
            'profiling'  => true,
        ],
        'mysql'     => [
            'driver'     => Driver\MySQL\MySQLDriver::class,
            'options'    => [
                'connection' => 'mysql:host=127.0.0.1;dbname=' . env('DB_NAME'),
                'username'   => env('DB_USERNAME'),
                'password'   => env('DB_PASSWORD'),
            ]
        ],
    ]
];


