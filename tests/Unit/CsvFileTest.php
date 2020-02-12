<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CsvFileService;

class CsvFileServiceTest extends TestCase
{
    protected string $fileName = "test.csv";
    protected  $fp;
    protected CsvFileService $csv;

    /**
     * @throws \Exception
     */
    public function Setup() : void
    {
        $this->csv = new CsvFileService();
        $this->fp = fopen($this->fileName, "w");
        if (!$this->fp) {
            throw new \Exception("Error " . posix_get_last_error() . " for fopen: " . $this->fileName);
        }
    }

    public function TearDown() : void
    {
        fclose($this->fp);
    }

    public function testWriteRecord()
    {
        $bytes = $this->csv->writeRecord($this->fp, [1,'Ninke','Brinkman']);
        $this->assertEquals(17, $bytes);
        $bytes = $this->csv->writeRecord($this->fp, [2,'Piotr','Loerakker']);
        $this->assertEquals(18, $bytes);
    }

    public function testWriteDataAndHeader()
    {
        $bytes = $this->csv->writeData($this->fp, [[1,'Unita'], [4,'Isla']], ['id','name']);
        $this->assertEquals(23, $bytes);
    }

    public function testWriteFieldWithEmbeddedQuotes()
    {
        $data = [3,'Julian "Jools"','Jackson'];
        $expectBytes = \fputcsv($this->fp, $data);

        $bytes = $this->csv->writeRecord($this->fp, $data);
        $this->assertEquals($expectBytes, $bytes);
    }

    public function testWriteRecordWithEmbeddedNewline()
    {
        $data = [1,'Perry'.PHP_EOL.'Cider','x-man'];
        $expectBytes = \fputcsv($this->fp, $data);

        $bytes = $this->csv->writeRecord($this->fp, $data);
        $this->assertEquals($expectBytes, $bytes);
    }

    public function testWriteRecordWithEmbeddedCommas()
    {
        $data = [1,'Perry,,Cider','x,man'];
        $expectBytes = \fputcsv($this->fp, $data);

        $bytes = $this->csv->writeRecord($this->fp, $data);
        $this->assertEquals($expectBytes, $bytes);
    }

    public function testWriteRecordEmbeddedQuotables()
    {
        $data = [1,'Perry'.PHP_EOL.'Cider,Rose','x"man'];
        $expectBytes = \fputcsv($this->fp, $data);

        $bytes = $this->csv->writeRecord($this->fp, $data);
        $this->assertEquals($expectBytes, $bytes);
    }
}
