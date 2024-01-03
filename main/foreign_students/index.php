<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <link rel="stylesheet" href="../style/foreign_students.css">
    <title>SUB-International Students</title>
</head>

<?php
$table = ' 

<table border="1" style=" border-collapse: collapse; cellpadding: 10px;">
<thead>
    <tr>
        <th>SL#</th>
        <th>Programs</th>
        <th>Fees (BD Taka)</th>
        <th>Service Office</th>
        <th>Remarks</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>01</td>
        <td>Admission Fee: Bachelor / Honor’s Programs</td>
        <td>
            Admission Fee: 15,000<br>
            Development Fee: 8,000<br>
            Medical Fee: 3,000<br>
            ID Card Fee: 200<br>
            Library Card Fee: 200<br>
            Service Charge: 20,000<br>
            <strong>Total BD. TK.46,400/-</strong>
        </td>
        <td rowspan="3">Admission Office, Ground floor, Siddeswari Campus, 51 Siddeswari Road (Ramna), Dhaka-1217.</td>
        <td>
            Admission Fees: One time, non-refundable.<br>
            Other Fees: One time.<br>
            All fees will be paid at the time of Admission Total BD. TK.46,400/.<br>
            <strong>Requirement of Admission documents:</strong><br>
            Original & Photocopy of all academic Certificates & Mark sheets,<br>
            Original & Photocopy of Passport with BD visa (main pages),<br>
            Offer letter Original & Photocopy & 04 Passport size photographs & 02 Stamp size photographs.
        </td>
    </tr>
    <tr>
        <td>02</td>
        <td>Admission Fee: Master Programs (Business Administration, Arts, Social Sciences & Law)</td>
        <td>
            Admission Fee: 15,000<br>
            Library Fee: 2,500<br>
            Development Fee: 8,000<br>
            Medical Fee: 1,500<br>
            ID Card Fee: 200<br>
            Library Card Fee: 200<br>
            Service Charge: 20,000<br>
            <strong>Total BD. TK.47,400/-</strong>
        </td>
        <td>
            Admission Fees: One time, non-refundable.<br>
            Other Fees: One time.<br>
            All fees will be paid at the time of Admission Total BD. TK.47,400/.<br>
            <strong>Requirement of Admission documents:</strong><br>
            Original & Photocopy of all academic Certificates & Mark sheets,<br>
            Original & Photocopy of Passport with BD visa (main pages),<br>
            Offer letter Original & Photocopy & 04 Passport size photographs & 02 Stamp size photographs.
        </td>
    </tr>
    <tr>
        <td>03</td>
        <td>Admission Fee: Master Programs (Science & Engineering)</td>
        <td>
            Admission Fee: 15,000<br>
            Library Fee: 2,500<br>
            Development Fee: 8,000<br>
            Lab Fee: 5,000<br>
            Medical Fee: 1,500<br>
            ID Card Fee: 200<br>
            Library Card Fee: 200<br>
            Service Charge: 20,000<br>
            <strong>Total BD. TK.52,400/-</strong>
        </td>
        <td>
            Admission Fees: One time, non-refundable.<br>
            Other Fees: One time.<br>
            All fees will be paid at the time of Admission Total BD. TK.52,400/.<br>
            <strong>Requirement of Admission documents:</strong><br>
            Original & Photocopy of all academic Certificates & Mark sheets,<br>
            Original & Photocopy of Passport with BD visa (main pages),<br>
            Offer letter Original & Photocopy & 04 Passport size photographs & 02 Stamp size photographs.
        </td>
    </tr>
</tbody>
</table>
';

require_once('../../vendor/autoload.php');

/**
 * Generates a PDF document with the given table content.
 *
 * @param mixed $table The content of the table to be included in the PDF.
 * @return string The generated PDF document as a string.
 */
function generatePDF($table)
{
    $auth = "<small style='font-size: 10px;'>Generated on " . date('d-m-Y H:i:s') . "<br>Stamford University Bangladesh</small>";
    // Create instance of TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document metadata
    $pdf->SetCreator('SUB');
    $pdf->SetAuthor('siMobin');
    $pdf->SetTitle('SUB-Requirement of Admission Fees & documents');
    $pdf->SetSubject('Requirement of Admission Fees & documents');
    $pdf->SetKeywords('SUB');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('times', '', 12);

    // Your content goes here - use TCPDF methods to add content
    $pdf->writeHTML("$table$auth", true, false, true, false, '');

    // Output PDF as a string
    $output = $pdf->Output('output.pdf', 'S');

    return $output;
}

if (isset($_POST['download_pdf'])) {
    $table = $table;

    // Call the function to generate the PDF
    $pdfContent = generatePDF($table);

    // Output the PDF to the browser
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Requirement of Admission Fees & documents.pdf"');
    echo $pdfContent;
    exit;
}

?>


<body>

    <header>
        <?php
        require '../nav.php';
        // include './header_slider.php';
        ?>
    </header>

    <div class="fssc">
        <h1>Functioning of FSSC</h1>
        <h3>Duties and responsibilities of the Cell:</h3>
        <p>Issue Admission Offer letter to foreign candidates seeking admission complying requisite criteria of a relevant program.</p>

        <p>Receiving the students from the Airport on completion of immigration procedure.</p>

        <p>Arrange transportation for such students from Airport to the University Admission office.</p>

        <p>Arrange lunch/ dinner for them after receiving them from the Airport.</p>

        <p>Ensure accommodation in the dormitory arranged for them.</p>

        <p>Complete their admission procedure from the Admission Office and arrange ID Card for them.</p>

        <p>Inform the arrival of such students with their bio-data and photocopy of passports to Depts. concerned.</p>

        <p>Ensure their requisite medical tests and advice by the University Medical Center.</p>

        <p>Ensure documentation of the students by the Admission Office.</p>

        <p>Process the Visa extension of students with the concerned Govt. Offices.</p>

        <p>Implementation of decisions taken by the Foreign Students Service Committee as and when given.</p>

        <p>Solve difficulties and welfare matters relating to foreign students.</p>

        <p>Explain necessary rules and regulations for the students of the University.</p>

        <p>Ensure safe custody of Passports of foreign students.</p>

        <p>Updating Website relating to foreign students information on admission and other instructions.</p>

        <p>Ensure management of Foreign students dormitory ( regarding rent agreement/utility payment etc. through the students committee).</p>

    </div>

    <h1 class="initial-fac h1">Initial Facilities</h1>
    <p class="initial-fac">Receiving the Students from the Airport. University will arrange transportation from the Airport (Charge Free).Arrange first time Lunch or Dinner (Charge Free), University will arrange accommodation in the hired dormitory. Students will complete admission procedure with the help of FSSC from the Admission Office and will receive ID card.</p>

    <div class="enroll">
        <h1>Enrollment Requirement</h1>
        <p> Offer Letter for Enrolment: No Fees required (Will be issued from the university after proper scrutiny of educational requirements.)</p>

        <p> Send soft copy Prescribed CV or Bio-Data (MS Word) & Scanned copy documents by Email at: <a href="mailto:fssc@stamforduniversity.edu.bd">fssc@stamforduniversity.edu.bd</a></p>

        <p> Educational requirements & documents :</p>
        <table border='1' style=' border-collapse: collapse;'>
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Programs</th>
                    <th>Required documents</th>
                    <th>Prescribed CV or Bio-Data (MS Word)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>For Bachelor / Honor’s Programs</td>
                    <td>Educational Requirement: See Admission Requirement.<br>Prescribed CV or Bio-data, Original Valid Passport main 1 or 2 pages<br>Scanned copy or Photocopy (valid Minimum 12 months).<br>Scanned copy or Photocopy of SSC & HSC or O-Level & A-level original Certificates & Mark Sheets.</td>
                    <td><a class="submit" href="../downloads/">Download</a></td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>For Master Programs</td>
                    <td>Educational Requirement: See Admission Requirement.<br>Prescribed CV or Bio-data, Original Valid Passport main 1 or 2 pages<br>Scanned copy or Photocopy (valid Minimum 12 months).<br>Scanned copy or Photocopy of SSC, HSC or O-Level, A-level & Honor’s or Bachelor original Certificates & Mark Sheets.</td>
                    <td><a class="submit" href="../downloads/">Download</a></td>
                </tr>
            </tbody>
        </table>

    </div>


    <div class="requirement">
        <details>
            <summary>
                Requirement of Admission Fees & documents
            </summary>

            <?php
            echo $table;
            ?>
            <br>
            <!-- <br> -->
            <form action="" method="post">
                <button class="submit" type="submit" name="download_pdf">Download PDF</button>
            </form>

        </details>
    </div>

    <details>
        <summary>Necessary Information, documents and Fees for Foreign Students VISA extension or renewal: Please see the website of visa office Government of Bangladesh and see the requirements below</summary>

        <div class="details">
            <h1>Dept. of Immigration & Passports</h1>

            <p><strong>Visa office address :</strong>Agargaon, Dhaka, Bangladesh</p>

            <p><strong>Visit Visa office website :</strong><a href="www.visa.gov.bd">www.visa.gov.bd</a></p>

            <p><strong>Hotline :</strong>333</p>

            <p><strong>Working time of Visa office: 9:00 AM to 3:00 PM (Friday, Saturday & Govt. Holiday closed)</strong></p>
        </div>
    </details>

    <?php
    require '../footer.php';
    ?>
</body>

</html>