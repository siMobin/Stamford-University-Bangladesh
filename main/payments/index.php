<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/payments.css">
    <title>SUB-Payment Method</title>
</head>


<?php
$table = ' 
<table border="1" style="border-collapse: collapse; width: 270mm;">
            <tr>
                <th style="width: 30px;">#</th>
                <th>Payment Method</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Pay order or Cheque</td>
                <td>in the name of "<strong>Stamford University Bangladesh</strong>" to be deposited in Accounts Office.</td>
            </tr>
            <tr>
                <td>2</td>
                <td>BRAC BANK LTD</td>
                <td><strong>RCDM</strong> at Siddeswari campus</td>
            </tr>
            <tr>
                <td>3</td>
                <td>BRAC BANK LTD (Online)</td>
                <td>A/C No: # 20573165600001 (Branch: Any)</td>
            </tr>
            <tr>
                <td>4</td>
                <td>DBBL</td>
                <td>Online A/C No: 171.120.002443 (Branch: Satmasjid Road, Dhaka)</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Sonali Bank Ltd.</td>
                <td>Online A/C No: #1653202001012 (Online payment only)</td>
            </tr>
            <tr>
                <td>6</td>
                <td>bKash <small>(+ 1.5% Charge Applicable)</small></td>
                <td>Merchant Number - 01737838508 (Select payment option & write Student ID in Ref.)</td>
            </tr>
            <tr>
                <td>7</td>
                <td>রকেট <small>(+ 1.0% Charge Applicable)</small></td>
                <td>01737838508 (select “<strong>বিশ্ববিদ্যালয়</strong>” option)</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Rocket</td>
                <td>Biller ID <strong>2001</strong></td>
            </tr>
            <tr>
                <td>9</td>
                <td>DBBL Agent Banking</td>
                <td>Biller ID <strong>2080</strong> (Bill No - write Student ID)</td>
            </tr>
            <tr>
                <td>10</td>
                <td>NexusPay Apps</td>
                <td>Select “<strong>Bill Pay</strong>” Category - University</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Payment from abroad</td>
                <td>Online A/C No : 171.120.002443 , Name: Stamford University Bangladesh . Routing Number :092820430 ,SWIFT Code : DBBLBDDH , Dutch Bangla Bank Ltd.</td>
            </tr>
        </table>
';

require_once('../../vendor/autoload.php');

/**
 * Generates a PDF document with the given table content.
 *
 * @param mixed $table The content of the table to be included in the PDF.
 * @throws TCPDF_Exception If there is an error during the PDF generation.
 * @return string The generated PDF document as a string.
 */
function generatePDF($table)
{
    // TODO: add Title
    $auth = "<small style='font-size: 10px;'>Generated on " . date('d-m-Y H:i:s') . "<br>Stamford University Bangladesh</small>";
    // Create instance of TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document metadata
    $pdf->SetCreator('SUB');
    $pdf->SetAuthor('siMobin');
    $pdf->SetTitle('SUB-Payment system');
    $pdf->SetSubject('SUB-Payment system');
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
    header('Content-Disposition: attachment; filename="SUB-Payment system.pdf"');
    echo $pdfContent;
    exit;
}

?>

<body>
    <header>
        <?php
        require '../nav.php';
        ?>
    </header>

    <div class="table_wrapper">
        <?php
        echo $table;
        ?>

    </div>

    <form action="" method="post">
        <button style="margin-left: 1em;" class="submit" type="submit" name="download_pdf">Download as PDF</button>
    </form>
    <br>

    <div class="warning">
        <div class="warn">
            <p>⚠️ Students will bear the charges if they pay fees through our bKash and Nogod payment platforms.The charges are <strong>1.5% for bKash and 1.0% for Nogod.</strong><small>(Ref:27092023/2)</small></p>
        </div>
        <div class="warn">
            <p>⚠️ For any query regarding your dues, payment & others, please call these Accounts office Numbers: <strong>01923844167, 01783666437, 01321143637</strong> and <strong>01321143639</strong> (10am – 5pm, all working days).</p>
        </div>
    </div>

    <?php
    require '../footer.php';
    ?>
</body>

</html>