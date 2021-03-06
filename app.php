<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

mb_internal_encoding('UTF-8');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'stderr');

require __DIR__ . '/vendor/autoload.php';

// initiate shared container, bindings, directories and etc
$app = \App\App::init([
    'root' => __DIR__,
    'storage' => __DIR__ . '/storage'
]);

if ($app != null) {
    $app->serve();
}
