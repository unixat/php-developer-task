<?php

namespace App\Http\Controllers;

use App\Models\ExportHistory;
use App\Services\ExportCsvService;
use App\Models\Student;
use Illuminate\Http\Request;
use Bueltge\Marksimple\Marksimple;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExportSelected;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ExportController extends Controller
{
    public function __construct()
    {
        // Only to test in the browser api auth
        Auth::loginUsingId(1);
    }

    public function welcome()
    {
        $ms = new Marksimple();

        return view('hello', [
            'content' =>  $ms->parseFile('../README.md'),
        ]);
    }

    /**
     * View all students found in the database
     *
     * @param array|null $error
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewStudents()
    {
        $students = Student::with('course')->get();

        return view('view_students', compact(['students']));
    }

    /**
     * Exports all student data to a CSV file
     *
     * @param ExportSelected $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exportStudentsToCSV(ExportSelected $request)
    {
        $exportService = new ExportCsvService();
        list($students, $info, $error) = $exportService->export($request->get('exportFilename'),
                $request->get('studentId'),
                $request->get('_token'));
        return view('view_students', ['students' => $students, 'info' => $info, 'error' => $error]);
    }

    public function viewHistory()
    {
        $exportHistory = ExportHistory::get()->toArray();
        return view('view_export_history', compact('exportHistory'));
    }

    /**
     * Exports the total number of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCSV()
    {
        //
    }

    /** Optional **/

    /**
     * View all students found in the database
     */
    public function viewStudentsWithVue()
    {
        $students = Student::with('courses')->get();

        return view('view_students_vue', compact(['students']));
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCsvWithVue()
    {
        //
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCsvWithVue()
    {
        //
    }
}
