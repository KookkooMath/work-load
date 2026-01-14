<?php
require 'vendor/autoload.php';
require 'phak_math.php'; // เชื่อมต่อฐานข้อมูล

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


session_start();
$year = isset($_SESSION['Year']) ? $_SESSION['Year'] : date("Y") + 543;
$term = isset($_SESSION['Term']) ? $_SESSION['Term'] : 1;
$userid = $_SESSION['UserID'];

$sql = "SELECT * FROM user WHERE UserID = ?";
$stmt1 = $conn->prepare($sql);
$stmt1->bind_param("s", $userid);
$stmt1->execute();
$result1 = $stmt1->get_result();
$user = $result1->fetch_assoc();
$stmt1->close();


$stmt = $conn->prepare("SELECT teach.*, courses.* FROM teach 
                INNER JOIN courses ON teach.CourseID = courses.CourseID
                WHERE teach.Year = ? AND teach.Term = ? AND teach.UserID = ?       
                ORDER BY 
                FIELD(Course_day, 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'),
                LEAST(
                    IFNULL(Course_time_start_lecture, '23:59:59'),
                    IFNULL(Course_time_start_lab, '23:59:59')
                ) ASC"
                );

$stmt->bind_param("iis", $year, $term, $userid);
$stmt->execute();
$result = $stmt->get_result();




// 📌 สร้าง Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$title = "ภาระงานสอน $term-$year";
// ตรวจสอบความยาวและลบอักขระต้องห้าม
$title = mb_substr($title, 0, 31);
$title = preg_replace('/[:\\/\?\*\[\]]/', '', $title);

$sheet->setTitle($title);
//$sheet->setTitle("ตารางสอน");

$rows = range(6, 30); // แถว 6 ถึง 30
$rowHeight = 40.80 ;   // กำหนดความสูงของแถว

foreach ($rows as $row) {
    $sheet->getRowDimension($row)->setRowHeight($rowHeight);
}
// ✅ กำหนดเส้นขอบตารางหัวตาราง
$sheet->getStyle("A6:AI8")->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // สีดำ
        ],
    ],
]);

$rowCount = $result->num_rows;  // จำนวนแถวที่ได้จากฐานข้อมูล
$startRow = 9;  // เริ่มต้นแถวแรกของข้อมูล
$fixedRow = $startRow + $rowCount; // แถวสุดท้ายที่ต้องการ SUM
$lastColumn = "AI"; // คอลัมน์ขวาสุดที่ต้องการแสดงข้อความ

// ✅ กำหนดเส้นขอบตารางข้อมูล
$sheet->getStyle("A$startRow:$lastColumn$fixedRow")->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // สีดำ
        ],
    ],
]);

$cellsToRemoveBorders = ['A7', 'A8', 'B7', 'B8', 'C7', 'C8', 'D7', 'D8', 'E8', 'F8', 'G8', 'H8','I7','I8','J7','J8',
                        'K8','L8','M8','N8','O8','P7','P8','Q7','Q8','R8','S8','T8','U8','V8','W8','X8','Y8','Z8',
                        'AA8','AB8','AC8','AD8','AE8','AF8','AG7', 'AG8','AH7', 'AH8','AI7','AI8'];

foreach ($cellsToRemoveBorders as $cell) {
    $sheet->getStyle($cell)->applyFromArray([
        'borders' => [
            'top' => ['borderStyle' => Border::BORDER_NONE],
        ],
    ]);
}

$cellsToRemoveBorders = ['A6', 'A7', 'B6', 'B7', 'C6', 'C7', 'D6', 'D7', 'E7', 'F7', 'G7', 'H7','I6','I7',
                        'J6','J7','K7','L7','M7','N7','O7','P6','P7','Q6','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7',
                        'AA7','AB7','AC7','AD7','AE7','AF7','AG6', 'AG7','AH6', 'AH7','AI6','AI7'];

foreach ($cellsToRemoveBorders as $cell) {
    $sheet->getStyle($cell)->applyFromArray([
        'borders' => [
            'bottom' => ['borderStyle' => Border::BORDER_NONE],
        ],
    ]);
}

$cellsToRemoveBorders = ['B7', 'B8'];

foreach ($cellsToRemoveBorders as $cell) {
    $sheet->getStyle($cell)->applyFromArray([
        'borders' => [
            'right' => ['borderStyle' => Border::BORDER_NONE],
        ],
    ]);
}

$cellsToRemoveBorders = ['C7', 'C8'];

foreach ($cellsToRemoveBorders as $cell) {
    $sheet->getStyle($cell)->applyFromArray([
        'borders' => [
            'left' => ['borderStyle' => Border::BORDER_NONE],
        ],
    ]);
}

// ✅ รวมเซลล์ (Merge) ตั้งแต่ Y ถึง AF
$mergeRange = "Y$fixedRow:AF$fixedRow";
$sheet->mergeCells($mergeRange);

// ✅ ใส่ข้อความลงในเซลล์ที่รวม
$sheet->setCellValue("Y$fixedRow", "รวมชั่วโมงภาระงานต่อภาคเรียน");

// ✅ จัดข้อความให้อยู่ตรงกลาง
$sheet->getStyle($mergeRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle($mergeRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

// ✅ ใส่ SUM สำหรับคอลัมน์ตัวเลข
$sheet->setCellValue("AG$fixedRow", "=SUM(AG$startRow:AG" . ($fixedRow - 1) . ")");
$sheet->setCellValue("AH$fixedRow", "=SUM(AH$startRow:AH" . ($fixedRow - 1) . ")");

// กำหนดข้อความที่ต้องการแสดงนอกตาราง
$outsideText1 = "ลงชื่อ.......................................อาจารย์ผู้กรอก";
$outsideText2 = "ลงชื่อ..............................................................หัวหน้าภาควิชาฯ (ผู้ตรวจสอบความถูกต้อง)";
$outsideText3 = "ลงชื่อ...............................................................คณบดี (ผู้อนุมัติ)";

// ใส่ข้อความในแต่ละเซลล์ที่ต้องการ
$sheet->setCellValueExplicit("K" . ($fixedRow + 1), $outsideText1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet->setCellValueExplicit("K" . ($fixedRow + 2), $outsideText2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet->setCellValueExplicit("K" . ($fixedRow + 3), $outsideText3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);


// ใช้ applyFromArray กับช่วงเซลล์ทั้งหมดในคราวเดียว
$sheet->getStyle("K" . ($fixedRow + 1) . ":K" . ($fixedRow + 3))->applyFromArray([
    'font' => [
        'name' => 'TH SarabunPSK', // ใช้ฟอนต์ภาษาไทย
        'size' => 16,
        'bold' => true
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT, // ให้ข้อความชิดซ้ายใน K
        'vertical' => Alignment::VERTICAL_CENTER
    ]
]);

$sheet->setShowGridlines(false);


$Emp = $user['Emp_type'] ?? ''; // รับค่าจากฐานข้อมูล
$govCheck = ($Emp == "ข้าราชการ") ? "✓" : " ";
$empCheck = ($Emp == "พนักงาน") ? "✓" : " ";


// ตั้งค่าหัวข้อ ('A1', "ตารางสอน ปี $year เทอม $term")
$sheet->setCellValue('A2', "รายละเอียดการปฎิบัติงานสอนของคณาจารย์คณะวิทยาศาสตร์ สจล. ประจำภาคการศึกษาที่ $term/$year")
      ->setCellValue('A3', "ชื่อ ". $user['First_name']."  " .$user['Last_name']. "  ตำแหน่งทางวิชาการ ".$user['Academic_pos']."  ตำแหน่งทางบริหาร ".$user['Administrative_pos']."  ภาควิชา ".$user['Department'])
      ->setCellValue('A4', "({$govCheck}) ข้าราชการ                  ({$empCheck}) พนักงาน");

$sheet->mergeCells('A2:AI2');
$sheet->mergeCells('A3:AI3');
$sheet->mergeCells('A4:AI4');

// 📌 ตั้งค่าแบบอักษร 
$styleArray = [
    'font' => [
        'name' => 'TH SarabunPSK', // ใช้ฟอนต์ภาษาไทย
        'size' => 18,
        'bold' => true
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
    ]
];
$sheet->getStyle("A1:A5")->applyFromArray($styleArray);

// ตั้งค่าหัวตาราง
$headers = ["วันสอน", "รหัส-ชื่อวิชา", "", "หน่วยกิต","บริการประเภทนักศึกษา","","","","จำนวน","จำนวน",
            "เวลาที่สอน","","จำนวนชั่วโมงที่สอนต่อสัปดาห์","","","จำนวนสัปดาห์","จำนวนชั่วโมง",
            "สัปดาห์ที่สอน (ให้ใส่เครื่องหมายถูก / ไม่นับรวมสัปดาห์สอบ)","","","","","","","","","","","","","","",
            "จำนวนชั่วโมง","ภาระงาน","หมายเหตุ"          
];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '6', $header);
    $col++;
}
// ✅ ตั้งค่าหัวข้อย่อยในแถว 7
$sheet->setCellValue('E7', 'คณะ');
$sheet->setCellValue('F7', 'สาขา');
$sheet->setCellValue('G7', 'ชั้นปี');
$sheet->setCellValue('H7', 'กลุ่มเรียน');
$sheet->setCellValue('K7', 'ทฤษฎี');
$sheet->setCellValue('L7', 'ปฏิบัติ');
$sheet->setCellValue('I7', 'นักศึกษา');
$sheet->setCellValue('J7', 'นักศึกษา');
$sheet->setCellValue('I8', 'ที่ลงทะเบียน');
$sheet->setCellValue('J8', 'ต่อสัปดาห์');
$sheet->setCellValue('M7', 'ปริญญา');
$sheet->setCellValue('M8', '(ปกติ)');
$sheet->setCellValue('N7', 'ปริญญาตรี');
$sheet->setCellValue('N8', '(นานาชาติ)');
$sheet->setCellValue('O7', 'บัณฑิต');
$sheet->setCellValue('P7', 'ที่สอนต่อ');
$sheet->setCellValue('P8', 'ภาคเรียน');
$sheet->setCellValue('Q7', 'ที่สอนต่อ');
$sheet->setCellValue('Q8', 'ภาคเรียน');
$sheet->setCellValue('R8', '1');
$sheet->setCellValue('S8', '2');
$sheet->setCellValue('T8', '3');
$sheet->setCellValue('U8', '4');
$sheet->setCellValue('V8', '5');
$sheet->setCellValue('W8', '6');
$sheet->setCellValue('X8', '7');
$sheet->setCellValue('Y8', '8');
$sheet->setCellValue('Z8', '9');
$sheet->setCellValue('AA8', '10');
$sheet->setCellValue('AB8', '11');
$sheet->setCellValue('AC8', '12');
$sheet->setCellValue('AD8', '13');
$sheet->setCellValue('AE8', '14');
$sheet->setCellValue('AF8', '15');
$sheet->setCellValue('AG7', 'ภาระงาน');
$sheet->setCellValue('AH7', 'เพื่อประกอบ');
$sheet->setCellValue('AG8', 'ภาคเรียน');
$sheet->setCellValue('AH8', 'การเบิก');


$sheet->mergeCells('B6:C6');
$sheet->mergeCells('E6:H6');
$sheet->mergeCells('K6:L6');
$sheet->mergeCells('M6:O6');
$sheet->mergeCells('R6:AF6');

// 📌 ตั้งค่าหัวตารางให้ **Bold**
$styleArray = [
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 16
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
];

// รายการช่วงเซลล์ที่ต้องการใช้สไตล์เดียวกัน
$ranges1 = ["A6:H6", "K6:L6", "AI6", "E7:F7"];

foreach ($ranges1 as $range1) {
    $sheet->getStyle($range1)->applyFromArray($styleArray);
}

$styleArray = [
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
];

// รายการช่วงเซลล์ที่ต้องการใช้สไตล์เดียวกัน
$ranges2 = ["K7:L7"];

foreach ($ranges2 as $range2) {
    $sheet->getStyle($range2)->applyFromArray($styleArray);
}

$styleArray = [
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 12
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
];

// รายการช่วงเซลล์ที่ต้องการใช้สไตล์เดียวกัน
$ranges3 = ["G7:H7", "I6:J8", "P6:Q8", "R6:AF8", "M6:O6"];

foreach ($ranges3 as $range3) {
    $sheet->getStyle($range3)->applyFromArray($styleArray);
}

$styleArray = [
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 11
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
];

// รายการช่วงเซลล์ที่ต้องการใช้สไตล์เดียวกัน
$ranges4 = ["M7:O8", "AG6:AH8"];

foreach ($ranges4 as $range4) {
    $sheet->getStyle($range4)->applyFromArray($styleArray);
}


$rowNum = 9;

while ($row = $result->fetch_assoc()) {
    // สร้าง DateTime objects ถ้ามีข้อมูล
    $startTimeLec = !empty($row['Course_time_start_lecture']) ? new DateTime($row['Course_time_start_lecture']) : null;
    $endTimeLec   = !empty($row['Course_time_end_lecture'])   ? new DateTime($row['Course_time_end_lecture'])   : null;
    $startTimeLab = !empty($row['Course_time_start_lab'])     ? new DateTime($row['Course_time_start_lab'])     : null;
    $endTimeLab   = !empty($row['Course_time_end_lab'])       ? new DateTime($row['Course_time_end_lab'])       : null;

    
    // แปลงเวลาเป็นรูปแบบที่ต้องการ
    $startTimeLecFormatted = $startTimeLec ? $startTimeLec->format('H:i') : '';
    $endTimeLecFormatted   = $endTimeLec   ? $endTimeLec->format('H:i')   : '';
    $startTimeLabFormatted = $startTimeLab ? $startTimeLab->format('H:i') : '';
    $endTimeLabFormatted   = $endTimeLab   ? $endTimeLab->format('H:i')   : '';

    // ตั้งค่าข้อมูลหลัก (คอลัมน์ A ถึง Q, AG, AH, AI)
    $sheet->setCellValue("A$rowNum", $row['Course_day']);
    $sheet->setCellValue("B$rowNum", $row['CourseID']);
    $sheet->setCellValue("C$rowNum", $row['Course_name']);
    $sheet->setCellValue("D$rowNum", $row['Credit_total'] . "(" . $row['Credit_lecture'] . "-" . $row['Credit_lab'] . "-" . $row['Credit_independent'] . ")");
    $sheet->setCellValue("E$rowNum", $row['Student_faculty']);
    $sheet->setCellValue("F$rowNum", $row['Student_department']);
    $sheet->setCellValue("G$rowNum", $row['Student_degree']);
    $sheet->setCellValue("H$rowNum", $row['Section']);
    $sheet->setCellValue("I$rowNum", $row['Student_enroll']);
    $sheet->setCellValue("J$rowNum", $row['Student_per_week']);
    // เวลา lecture
    if (!empty($startTimeLecFormatted) && !empty($endTimeLecFormatted)) {
        $sheet->setCellValue("K$rowNum", "$startTimeLecFormatted - $endTimeLecFormatted");
    } elseif (!empty($startTimeLecFormatted)) {
        $sheet->setCellValue("K$rowNum", $startTimeLecFormatted);
    } elseif (!empty($endTimeLecFormatted)) {
        $sheet->setCellValue("K$rowNum", $endTimeLecFormatted);
    } else {
        $sheet->setCellValue("K$rowNum", ""); // เวลาว่าง
    }

    // เวลา lab
    if (!empty($startTimeLabFormatted) && !empty($endTimeLabFormatted)) {
        $sheet->setCellValue("L$rowNum", "$startTimeLabFormatted - $endTimeLabFormatted");
    } elseif (!empty($startTimeLabFormatted)) {
        $sheet->setCellValue("L$rowNum", $startTimeLabFormatted);
    } elseif (!empty($endTimeLabFormatted)) {
        $sheet->setCellValue("L$rowNum", $endTimeLabFormatted);
    } else {
        $sheet->setCellValue("L$rowNum", "");
    }

    /*$sheet->setCellValue("K$rowNum", "$startTimeLecFormatted - $endTimeLecFormatted");
    $sheet->setCellValue("L$rowNum", "$startTimeLabFormatted - $endTimeLabFormatted");*/
    $sheet->setCellValue("M$rowNum", $row['Hours_per_week_bachelor_degree']);
    $sheet->setCellValue("N$rowNum", $row['Hours_per_week_inter_bachelor_degree']);
    $sheet->setCellValue("O$rowNum", $row['Hours_per_week_graduate']);
    $sheet->setCellValue("P$rowNum", $row['Amount_week_per_term']);
    $sheet->setCellValue("Q$rowNum", $row['Amount_hours_per_term']);
    $sheet->setCellValue("AG$rowNum", $row['Amount_teach_hours_per_term']);
    $sheet->setCellValue("AH$rowNum", $row['Workload_for_reimbursement']);
    $sheet->setCellValue("AI$rowNum", $row['remark']);

    // แยกค่า Weeks_selected ลงคอลัมน์ R ถึง AF
    $weeks = explode(',', $row['Weeks_selected']); // แยกค่าด้วย `,`
    $startColumnIndex = 18; // 'R' คือคอลัมน์ที่ 17 (A=1, B=2, ..., R=17)
    foreach ($weeks as $week) {
        $week = (int) trim($week); // แปลงเป็นตัวเลขและตัดช่องว่าง
        if ($week >= 1 && $week <= 15) { // ตรวจสอบให้แน่ใจว่าสัปดาห์อยู่ในช่วงที่กำหนด
            $columnIndex = $startColumnIndex + ($week - 1); // คำนวณตำแหน่งคอลัมน์
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex); // แปลงเป็นตัวอักษร
            $sheet->setCellValue("{$columnLetter}{$rowNum}", "/"); // ใส่ค่า ✓
        }
    }
    $rowNum++;
}

// 📌 ตั้งค่าฟอนต์สำหรับข้อมูล (ขนาดเล็กลง)
$sheet->getStyle("A9:A$rowNum")->applyFromArray([
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
]);
// 📌 ตั้งค่าฟอนต์สำหรับข้อมูล (ขนาดเล็กลง)
$sheet->getStyle("B9:AI$rowNum")->applyFromArray([
    'font' => [
        'name' => 'TH SarabunPSK',
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER
    ]
]);
$sheet->getStyle("Y$fixedRow")->applyFromArray([
    'font' => [
        'name' => 'TH SarabunPSK',
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
    ]
]);

$sheet->getColumnDimension('B')->setWidth(9.22);  // กำหนดความกว้างของคอลัมน์ B
$sheet->getColumnDimension('C')->setWidth(38.78);  // กำหนดความกว้างของคอลัมน์ A
$sheet->getColumnDimension('D')->setWidth(7.75);  
$sheet->getColumnDimension('E')->setWidth(7.70);
$sheet->getColumnDimension('F')->setWidth(10.35);
$sheet->getColumnDimension('G')->setWidth(3.20);
$sheet->getColumnDimension('H')->setWidth(6.22);
$sheet->getColumnDimension('I')->setWidth(9.00);
$sheet->getColumnDimension('J')->setWidth(7.15);
$sheet->getColumnDimension('K')->setWidth(11.00);
$sheet->getColumnDimension('L')->setWidth(11.00);
$sheet->getColumnDimension('M')->setWidth(7.00);
$sheet->getColumnDimension('N')->setWidth(7.00);
$sheet->getColumnDimension('O')->setWidth(6.00);
$sheet->getColumnDimension('P')->setWidth(9.90);
$sheet->getColumnDimension('Q')->setWidth(9.20);
$sheet->getColumnDimension('AG')->setWidth(8.60);
$sheet->getColumnDimension('AH')->setWidth(7.78);
$sheet->getColumnDimension('AI')->setWidth(34.22);

$columns = ['R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF']; // กำหนดคอลัมน์ที่ต้องการ
$width = 3.00; // กำหนดความกว้างที่ต้องการ

foreach ($columns as $column) {
    $sheet->getColumnDimension($column)->setWidth($width);
}



// ส่งออกไฟล์
$writer = new Xlsx($spreadsheet);
$filename = "ภาระงานสอนประจำภาคการศึกษา $term-$year.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save("php://output");
exit;

echo "<script>window.location.href='TeaachingInformation2.php';</script>";
exit;
?>
