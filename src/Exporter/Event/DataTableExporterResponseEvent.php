<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Exporter\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * DataTableExporterResponseEvent.
 *
 * @author Maxime Pinot <contact@maximepinot.com>
 */
class DataTableExporterResponseEvent extends Event
{
    public function __construct(private Response $response) {}

    public function getResponse(): Response
    {
        return $this->response;
    }
}
