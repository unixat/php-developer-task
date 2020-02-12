<?php


namespace App\Services;

use App\Models\Student;
use App\Models\ExportHistory;
use function fclose;
use function fopen;

class ExportCsvService
{
	public function export(string $filename, array $ids, string $token) : array
	{
	    $info = null;
	    $error = null;
	    $students = null;

	    // enforce .csv extension of filename
	    $pos = strpos($filename, '.');
	    if (false === $pos) {
            $filename .= '.csv';
        }
	    else {
	        $filename = substr_replace($filename, '.csv', $pos);
        }

		$fh = fopen($filename, 'w');

        $students = Student::with(['course'])->find($ids);
		if ($fh) {
            $csv = new CsvFileService();
            $studentArray = $students->toArray();
            foreach ($studentArray as &$s) {
                $s['course_name'] = $s['course']['course_name'];
                $s['university'] = $s['course']['university'];
                unset($s['course']);
            }

            if ($csv->writeData($fh, $studentArray)) {
                $history = new ExportHistory;
                $history->filename = $filename;
                $history->records = count($studentArray);
                $history->token = $token;
                $history->save();
            }
            fclose($fh);
            $info = $history->records . " student" . ($history->records > 1 ? "s":"") . " exported to " . $filename;
        }
		else {
		    $error = 'Error exporting student data - click "View Students" to continue';
        }

		return [$students, $info, $error];
	}
}