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
 * @Cycle\Entity(repository="\App\Repository\PodcastRepository")
 */
class Podcast
{
    /**
     * @Cycle\Entity(table = "podcasts")
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
    public $source;

    /**
     * @Cycle\Column(type = "text")
     */
    public $content;


    /**
     * @Cycle\Column(type = "string")
     */
    public $status;

    /**
     * @Cycle\Column(type = "date")
     */
    public $created_at;

    /**
     * @Cycle\Column(type = "date")
     */
    public $updated_at;
}
