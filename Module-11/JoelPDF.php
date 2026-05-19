<?php
// Joel Atkinson, May 19, 2026. CSD440 Server-Side Scripting Assignment 11.2
// The purpose of this program is to pull every row from the joel_mlb_teams
// table (built back in Module 8) and turn it into a PDF report using the
// FPDF library. The PDF has a page header and footer on every page, a short
// section of background info about MLB, and a data table with a header row
// of column names and a footer row that totals up the team count and the
// World Series wins.

require('fpdf/fpdf.php');

// FPDF calls Header() and Footer() automatically every time a new page is
// added, so I'm subclassing FPDF and overriding both of them.
class JoelPDF extends FPDF
{
    function Header()
    {
        $this->SetFillColor(102, 51, 153);   // purple
        $this->SetTextColor(218, 165, 32);   // gold
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 14, 'Joel\'s MLB Teams - Database Report', 0, 1, 'C', true);

        // Gold divider under the banner
        $this->SetDrawColor(218, 165, 32);
        $this->SetLineWidth(0.8);
        $this->Line(10, 18, 200, 18);

        $this->SetTextColor(0, 0, 0);
        $this->Ln(8);
    }

    function Footer()
    {
        // 15mm up from the bottom of the page
        $this->SetY(-15);

        $this->SetDrawColor(218, 165, 32);
        $this->SetLineWidth(0.4);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(2);

        // Copyright line, centered
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(80, 80, 80);
        $this->Cell(0, 6, 'Joel Atkinson - Copyright 2026', 0, 0, 'C');

        // Page number on the right. {nb} gets swapped for the total page
        // count because of AliasNbPages() below.
        $this->SetXY(-30, $this->GetY());
        $this->Cell(20, 6, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }
}

// Same DB credentials as the Module 8 scripts
$servername = "localhost";
$username   = "student1";
$password   = "pass";
$database   = "baseball_01";

$conn = new mysqli($servername, $username, $password, $database);

// Bail out cleanly if the DB is down - can't put a connection error inside
// a PDF, so print plain text and quit before any PDF output starts.
if ($conn->connect_error) {
    header('Content-Type: text/plain');
    echo "Connection failed: " . $conn->connect_error;
    exit;
}

// Same query/order as JoelQueryTable.php from Module 8 - winningest teams first
$sql = "SELECT team_id, team_name, city, league, division,
               founded_year, world_series_wins, mascot
        FROM joel_mlb_teams
        ORDER BY world_series_wins DESC, team_name ASC";
$result = $conn->query($sql);

if ($result === false) {
    header('Content-Type: text/plain');
    echo "Query failed: " . $conn->error;
    $conn->close();
    exit;
}

// Pull every row into an array so I can loop over it for the table body
// and also use it to calculate the footer totals.
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
$result->free();
$conn->close();

// Set up the PDF
$pdf = new JoelPDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(10, 25, 10);       // top margin clears the header banner
$pdf->SetAutoPageBreak(true, 22);   // bottom break leaves room for the footer
$pdf->AddPage();

// Intro section
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(102, 51, 153);
$pdf->Cell(0, 8, 'About Major League Baseball', 0, 1, 'L');

$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);
$intro =
    "Major League Baseball (MLB) is the oldest of the four major North American "
  . "professional sports leagues, with the National League founded in 1876 and "
  . "the American League following in 1901. MLB is made up of 30 franchises, "
  . "split evenly between the American League (AL) and the National League (NL), "
  . "and each league is further divided into East, Central, and West divisions "
  . "of five teams each. The champions of the AL and NL meet every October in "
  . "the World Series, a best-of-seven series that decides the league champion. "
  . "The data table on the following pages lists each team's city, league, "
  . "division, founding year, total World Series titles, and mascot.";
$pdf->MultiCell(0, 6, $intro, 0, 'J');
$pdf->Ln(4);

// Data table title
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetTextColor(102, 51, 153);
$pdf->Cell(0, 8, 'Team Data - joel_mlb_teams', 0, 1, 'L');
$pdf->Ln(1);

// Column widths add up to 195mm to fit a Letter page with 10mm side margins
$widths  = array(10,  46,  30,  14,  20,  20,  20,  35);
$headers = array('ID','Team','City','League','Division','Founded','WS Wins','Mascot');
$aligns  = array('C', 'L',  'L',  'C',     'C',       'C',       'C',       'L');

// Wrapped in a closure so I can call it again if the table spills onto a
// second page - keeps the column labels visible at the top of every page.
$drawHeader = function() use ($pdf, $widths, $headers) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(102, 51, 153);
    $pdf->SetTextColor(218, 165, 32);
    $pdf->SetDrawColor(80, 80, 80);
    $pdf->SetLineWidth(0.2);
    for ($i = 0; $i < count($headers); $i++) {
        $pdf->Cell($widths[$i], 8, $headers[$i], 1, 0, 'C', true);
    }
    $pdf->Ln();
};
$drawHeader();

// Table body
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$rowFill   = false;     // toggles grey row banding
$totalWins = 0;

foreach ($rows as $r) {
    // Start a new page and re-draw the header row if we're running out of room
    if ($pdf->GetY() > 250) {
        $pdf->AddPage();
        $drawHeader();
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);
        $rowFill = false;
    }

    $pdf->SetFillColor(242, 242, 242);

    $cells = array(
        $r['team_id'],
        $r['team_name'],
        $r['city'],
        $r['league'],
        $r['division'],
        $r['founded_year'],
        $r['world_series_wins'],
        $r['mascot']
    );

    for ($i = 0; $i < count($cells); $i++) {
        $pdf->Cell($widths[$i], 7, (string)$cells[$i], 1, 0, $aligns[$i], $rowFill);
    }
    $pdf->Ln();

    $totalWins += (int)$r['world_series_wins'];
    $rowFill    = !$rowFill;
}

// Table footer row - team count on the left, total WS wins on the right
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(102, 51, 153);
$pdf->SetTextColor(218, 165, 32);
$leftWidth  = $widths[0] + $widths[1] + $widths[2] + $widths[3];
$rightWidth = $widths[4] + $widths[5] + $widths[6] + $widths[7];
$pdf->Cell($leftWidth,  8, 'Totals: ' . count($rows) . ' Teams', 1, 0, 'L', true);
$pdf->Cell($rightWidth, 8, 'Total World Series Wins: ' . $totalWins, 1, 1, 'R', true);

// Source note under the table
$pdf->Ln(6);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetTextColor(80, 80, 80);
$pdf->MultiCell(0, 5,
    'Source: joel_mlb_teams table in the baseball_01 MySQL database. '
  . 'Generated by JoelPDF.php using the FPDF library.', 0, 'C');

// 'I' streams the PDF to the browser inline. Swap to 'D' to force a download.
$pdf->Output('I', 'JoelMLBTeams.pdf');