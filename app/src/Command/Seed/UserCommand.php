<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Command\Seed;

use App\Database\User;
use Cycle\ORM\TransactionInterface;
use Faker\Generator;
use Spiral\Console\Command;

class UserCommand extends Command
{
    protected const NAME = 'seed:user';

    protected const DESCRIPTION = '';

    protected const ARGUMENTS = [];

    protected const OPTIONS = [];

    /**
     * Perform command
     */
    protected function perform(TransactionInterface $tr, Generator $faker): void
    {
        $u = new User();
        $u->username = 'toto';
        $u->email = 'toto@toto.com';
        $u->password = password_hash('toto', PASSWORD_DEFAULT);

        $tr->persist($u)->run();
    }
}
