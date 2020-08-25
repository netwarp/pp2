<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Database;

use Cycle\Annotated\Annotation as Cycle;

/**
 * @Cycle\Entity(repository="\App\Repository\EventRepository")
 */
class Event
{
    /**
     * @Cycle\Entity(table = "events")
     */

    /**
     * @Cycle\Column(type = "primary")
     */
    public $id;

    /**
     * @Cycle\Column(type = "string")
     */
    public $title;

    /**
     * @Cycle\Column(type = "string")
     */
    public $slug;

    /**
     * @Cycle\Column(type = "string")
     */
    public $date;
}
