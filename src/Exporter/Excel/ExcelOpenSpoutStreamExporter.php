<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Exporter\Excel;

use Omines\DataTablesBundle\Exporter\DataTableExporterInterface;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\AutoFilter;
use OpenSpout\Writer\XLSX\Entity\SheetView;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Excel exporter using OpenSpout.
 */
class ExcelOpenSpoutStreamExporter implements DataTableExporterInterface
{
    public function export(array $columnNames, \Iterator $data): StreamedResponse
    {
        $filePath = sys_get_temp_dir() . '/' . uniqid('dt') . '.xlsx';

        // Header
        $rows = [Row::fromValues($columnNames, (new Style())->setFontBold())];
        $writer = new Writer();
        $response = new StreamedResponse(function () use ($writer, $data) {
            $writer->openToBrowser('filename.xlsx');

            foreach ($data as $row) {
                $values = array_map('strip_tags', $row);
                $writer->addRow(Row::fromValues($values));
            }

            $writer->close();
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');

        return $response;
    }

    public function getMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }

    public function getName(): string
    {
        return 'excel-openspout-stream';
    }
}
