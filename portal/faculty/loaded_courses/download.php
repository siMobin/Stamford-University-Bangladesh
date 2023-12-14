<?php
session_start();

if (!isset($_SESSION["FacultyId"])) {
    // User isn't logged in, redirect to the login page
    header("Location: ./login/");
    exit;
}

if (!isset($_GET["course_code"])) {
    // Redirect if course_code is not provided in the URL
    header("Location: ./courses.php"); // Redirect to your courses page
    exit;
} else {
    $courseCode = $_GET["course_code"];
}

require('../../../conn.php');
require '../../../vendor/autoload.php'; // Path to autoload.php for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch student details for the selected course
$query = "SELECT studentID, semester, mid, final, [30%] FROM CRS_confirm WHERE course_code = ?";
$params = array($courseCode);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    echo "Error fetching student details: " . print_r(sqlsrv_errors(), true);
} else {
    if (sqlsrv_has_rows($result)) {
        // Create a new PhpSpreadsheet instance
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Student Details');

        // Set headers
        $sheet->setCellValue('A1', 'Student ID');
        $sheet->setCellValue('B1', 'Semester');
        $sheet->setCellValue('C1', 'Mid');
        $sheet->setCellValue('D1', 'Final');
        $sheet->setCellValue('E1', '30%');
        $sheet->setCellValue('F1', 'Total');
        // $sheet->setCellValue('G1', '');

        // Style for bold and background color
        $style = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'DFFEFF', // Background color
                ],
            ],
        ];

        // Apply style to headers A1 to F1
        $sheet->getStyle('A1:F1')->applyFromArray($style);

        $row = 2; // Start adding data from row 2
        while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $sheet->setCellValue('A' . $row, $data['studentID']);
            $sheet->setCellValue('B' . $row, $data['semester']);
            $sheet->setCellValue('C' . $row, $data['mid']);
            $sheet->setCellValue('D' . $row, $data['final']);
            $sheet->setCellValue('E' . $row, $data['30%']);
            // Calculate Total
            $sheet->setCellValue('F' . $row, '=SUM(C' . $row . ',D' . $row . ',E' . $row . ')');
            $row++;
        }

        // Save the spreadsheet to a file
        $filename = 'student_details_' . $courseCode . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Download the file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    } else {
        echo "No students found for this course.";
    }
    sqlsrv_free_stmt($result);
}

sqlsrv_close($conn);
