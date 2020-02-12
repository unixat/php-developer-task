<?php

declare(strict_types=1);

namespace App\Services;

use function fwrite;

/**
 * Class CsvFile
 * @package CsvFile
 */
class CsvFileService
{
    protected $delimiter;

    /**
     * CsvFile constructor.
     *
     * @param string $delimiter
     */
    public function __construct(string $delimiter = ",")
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Write an array of data records, one data record per line.
     *
     * @param resource $fp
     * @param array $data
     * @param array|null $header
     *
     * @return bool|int
     */
    public function writeData($fp, array $data, array $header = null) : int
    {
        $totBytes = 0;
        if ($header) {
            $totBytes += $this->writeRecord($fp, $header);
        }

        if (!count($data)) {
            return 0;
        }

        foreach ($data as $key => $record) {
            $totBytes += $this->writeRecord($fp, $record);
        }
        return $totBytes;
    }

    /**
     * Write one CSV record, each field in record comma separated.
     *
     * @param resource $fp
     * @param array $data
     *
     * @return int
     */
    public function writeRecord($fp, array $data) : int
    {
        $record = null;
        foreach ($data as $field) {
            if (!is_numeric($field)) {
                $quote = strpos($field, '"');
                $comma = strpos($field, ',');
                $newline = strpos($field, PHP_EOL);
                if ($quote != false || $comma != false || $newline != false) {
                    $field = str_replace('"', '""', $field, $replacements);
                    $record .= '"' . $field . '"' . $this->delimiter;
                }
                else {
                    $record .= "{$field}" . $this->delimiter;
                }
            }
            else {
                $record .= "{$field}" . $this->delimiter;
            }
        }

        // remove final delimiter and append CR
        return fwrite($fp, substr($record, 0, strlen($record) - 1) . PHP_EOL);
    }
}
