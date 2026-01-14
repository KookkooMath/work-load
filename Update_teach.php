<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลรายวิชาสอน</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/confetti.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <style>
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background: linear-gradient(180deg, #f57c00, #ffffff);
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #f57c00, #ff9800);
            padding: 15px 30px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            height: 7%;
        }

        .back-link {
            margin-left: 20px;
        }

        .back-icon img {
            width: 40px;
            height: 40px;
        }

        .main-container {
            width: 100%;
            max-width: 1200px;
            margin: 90px auto 40px;
            padding: 0 20px;
        }

        .form-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        h2 {
            color: #f57c00;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .form-section {
            margin-bottom: 2rem;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            background-color: #fafafa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .form-section h3 {
            color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            border-bottom: 2px solid #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            padding-bottom: 0.75rem;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group label[for="Amount_teach_hours_per_term"] {
            margin-top: 1.5rem;
        }

        .form-group {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.15);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
            outline: none;
        }

        .form-group input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        input[type="time"] {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: white;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
            padding-right: 2.5rem;
            position: relative;
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
            z-index: 1;
        }

        input[type="time"]::-webkit-datetime-edit {
            width: calc(100% - 2.5rem);
            overflow: hidden;
            text-overflow: ellipsis;
        }

        input[type="time"]:focus {
            border-color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.15);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
            outline: none;
        }

        input[type="time"]::placeholder {
            color: #999;
        }

        .time-group {
            flex: 1;
            min-width: 200px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .time-group h4 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            font-size: 1rem;
            font-weight: 600;
        }

        .time-inputs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            width: 100%;
        }

        .time-inputs .form-group {
            flex: 1;
            min-width: 120px;
        }

        .hours-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hour-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            flex: 1;
            min-width: 300px;
        }

        .hour-group-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }

        .checkbox-input {
            display: flex;
            align-items: center;
            min-width: 150px;
        }

        .checkbox-input input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            accent-color: #f57c00;
        }

        .hours-input {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hours-input input[type="number"] {
            width: 70px;
            text-align: center;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .hours-input span {
            font-size: 0.85rem;
            color: #666;
        }

        .weeks-selection {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.25rem;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .week-options {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.25rem;
        }

        .option {
            display: flex;
            align-items: center;
        }

        .option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            accent-color: #f57c00;
        }

        .weeks-container {
            margin-top: 1.25rem;
        }

        .checkbox-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .week-item {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 0.75rem 0;
            transition: all 0.2s ease;
            cursor: pointer;
            height: 45px;
        }

        .week-item:hover {
            border-color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            background-color: #fff3e0;
            /* สีส้มอ่อนสำหรับ hover */
        }

        .week-item.selected {
            background-color: #f57c00;
            border-color: #f57c00;
            color: white;
        }

        .week-item input[type="checkbox"] {
            position: absolute;
    opacity: 0;
    width: 0px;  /* ปรับให้มีขนาดพอกดได้ */
    height: 0px;
        }

    .week-number {
            font-size: 1rem;
            font-weight: 500;
        }

        .week-item.first-week {
            border: 1px solid #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .submit-button {
            background-color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1.125rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Noto Sans Thai', sans-serif;
            box-shadow: 0 4px 6px rgba(245, 124, 0, 0.2);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
        }

        .submit-button:hover {
            background-color: #ff9800;
            /* เปลี่ยนเป็นสีส้มสว่าง */
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(245, 124, 0, 0.25);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
        }

        .submit-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(245, 124, 0, 0.2);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f57c00;
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
            box-shadow: 0 0 0 0.25rem rgba(245, 124, 0, 0.25);
            /* ปรับ rgba ให้เข้ากับสีส้ม */
        }

        .form-check-input:checked {
            background-color: #f57c00;
            border-color: #f57c00;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }

            .time-inputs {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }

            .time-inputs .form-group {
                width: 100%;
            }

            .checkbox-row {
                grid-template-columns: repeat(3, 1fr);
            }

            .hour-group-row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .hour-group {
                min-width: 100%;
                flex-direction: row;
            }

            .main-container {
                padding: 0 15px;
                margin-top: 75px;
            }

            .form-container {
                padding: 1.5rem 1.25rem;
            }

            .form-section h3+.form-row {
                flex-direction: column;
                gap: 1.5rem;
            }

            .time-group {
                width: 100%;
                padding: 0.75rem;
            }

            .checkbox-input {
                min-width: 120px;
            }

            .hours-input input[type="number"] {
                width: 60px;
            }
        }

        @media (max-width: 480px) {
            .checkbox-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-section {
                padding: 1rem;
            }

            .time-group {
                padding: 1rem;
            }

            .time-inputs {
                flex-direction: column;
                gap: 0.75rem;
            }

            .time-inputs .form-group {
                width: 100%;
                min-width: 100%;
            }

            .form-container {
                padding: 1rem;
            }

            .hour-group {
                flex-direction: column;
                align-items: flex-start;
                padding: 0.5rem;
            }

            .checkbox-input {
                min-width: 100%;
            }

            .hours-input {
                width: 100%;
            }

            .hours-input input[type="number"] {
                width: 100%;
                max-width: 100px;
            }
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <a href="TeachingInformation.php" class="back-link">
            <span class="back-icon">
                <img src="img/angle-left.png" alt="Back">
            </span>
        </a>
    </div>

    <?php
    include 'phak_math.php';

    $year = isset($_GET['Year']) ? $_GET['Year'] : '';
    $term = isset($_GET['Term']) ? $_GET['Term'] : '';   
    $courseID = isset($_GET['CourseID']) ? $_GET['CourseID'] : '';
    $course_day = isset($_GET['Course_day']) ? $_GET['Course_day'] : '';
    $section = isset($_GET['Section']) ? $_GET['Section'] : '';
           
     // ใช้ JOIN เพื่อดึงข้อมูลจากทั้งตาราง teach และ courses
     $stmt = $conn->prepare("SELECT teach.*, courses.Course_name, courses.Credit_total, courses.Credit_lecture, courses.Credit_lab, courses.Credit_independent 
     FROM teach 
     INNER JOIN courses ON teach.CourseID = courses.CourseID
     WHERE teach.Year = ? AND teach.Term = ? AND teach.CourseID = ? AND teach.Course_day = ? AND teach.Section = ?");
$stmt->bind_param("iissi", $year, $term, $courseID, $course_day, $section);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่ามีข้อมูลที่ดึงมา
if ($result->num_rows > 0) {
$data = $result->fetch_assoc();

// ตรวจสอบค่าที่ดึงมา
if (isset($data['Credit_total'], $data['Credit_lecture'], $data['Credit_lab'], $data['Credit_independent'])) {
// คำนวณ Credit_combined
$Credit_combined = "{$data['Credit_total']}({$data['Credit_lecture']}-{$data['Credit_lab']}-{$data['Credit_independent']})";
} else {
$Credit_combined = 'ข้อมูลไม่ครบถ้วน';
}
} else {
$data = []; // กรณีไม่พบข้อมูล
$Credit_combined = 'ไม่พบข้อมูล';
}

$stmt->close();
$conn->close();
?>

    <div class="main-container">
        <div class="form-container">
            <h2>แก้ไขข้อมูลรายวิชา วัน
                <?= $course_day ?> ปีการศึกษา
                <?= $year ?> ภาคเรียนที่
                <?= $term ?>
            </h2>

            <form id="details" action="Add_data.php" method="POST">
                <input type="hidden" name="Year" value="<?= $year ?>">
                <input type="hidden" name="Term" value="<?= $term ?>">
                <input type="hidden" name="Course_day" value="<?= $course_day ?>">

                <div class="form-section">
                    <h3>ข้อมูลรายวิชา</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="CourseID">รหัสวิชา</label>
                            <input type="text" name="CourseID" id="CourseID"
                                value="<?= htmlspecialchars($data['CourseID']) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Course_name">ชื่อวิชา</label>
                            <input type="text" id="Course_name" name="Course_name"
                                value="<?= htmlspecialchars($data['Course_name']) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Credit_combined">หน่วยกิต</label>
                            <input type="text" id="Credit_combined" name="Credit_combined"
                                value="<?= htmlspecialchars($Credit_combined) ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>เวลาสอน</h3>
                    <div class="form-row">
                        <div class="time-group">
                            <h4>ทฤษฎี</h4>
                            <div class="time-inputs">
                                <div class="form-group">
                                    <label for="Course_time_start_lecture">เริ่มเวลา</label>
                                        <input type="text" id="Course_time_start_lecture"  name="Course_time_start_lecture" placeholder="--:--" style="cursor: pointer;"
                                        value="<?= !empty($data['Course_time_start_lecture']) ? htmlspecialchars($data['Course_time_start_lecture']) : '' ?>">
                                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                        <script>
                                            flatpickr("#Course_time_start_lecture", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i", 
                                            time_24hr: true
                                            });
                                        </script>
                                    <!-- <input type="time" id="Course_time_start_lecture" name="Course_time_start_lecture" 
                                        value="</?= !empty($data['Course_time_start_lecture']) ? htmlspecialchars($data['Course_time_start_lecture']) : '' ?>"
                                        placeholder="00:00">-->
                                </div>
                                <div class="form-group">
                                    <label for="Course_time_end_lecture">สิ้นสุดเวลา</label>
                                    
                                    <input type="text" id="Course_time_end_lecture" name="Course_time_end_lecture" placeholder="--:--" style="cursor: pointer;"
                                        value="<?= !empty($data['Course_time_end_lecture']) ? htmlspecialchars($data['Course_time_end_lecture']) : '' ?>">
                                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                        <script>
                                            flatpickr("#Course_time_end_lecture", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i", 
                                            time_24hr: true
                                            });
                                        </script>
                                </div>
                            </div>
                        </div>
                        <div class="time-group">
                            <h4>ปฏิบัติ</h4>
                            <div class="time-inputs">
                                <div class="form-group">
                                    <label for="Course_time_start_lab">เริ่มเวลา</label>
                                    <input type="text" id="Course_time_start_lab" name="Course_time_start_lab" placeholder="--:--" style="cursor: pointer;"
                                        value="<?= htmlspecialchars($data['Course_time_start_lab']) ?>">
                                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                        <script>
                                            flatpickr("#Course_time_start_lab", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i", 
                                            time_24hr: true
                                            });
                                        </script>
                                </div>
                                <div class="form-group">
                                    <label for="Course_time_end_lab">สิ้นสุดเวลา</label>
                                    <input type="text" id="Course_time_end_lab" name="Course_time_end_lab" placeholder="--:--" style="cursor: pointer;"
                                        value="<?= htmlspecialchars($data['Course_time_end_lab']) ?>">
                                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                        <script>
                                            flatpickr("#Course_time_end_lab", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i", 
                                            time_24hr: true
                                            });
                                        </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>ข้อมูลการสอน</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Section">กลุ่มเรียน</label>
                            <input type="text" id="Section" name="Section"
                                value="<?= htmlspecialchars($data['Section']) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Student_faculty">คณะ</label>
                            <select name="Student_faculty" id="Student_faculty" required>
                                <option value="วิทย์" <?=($data['Student_faculty']=="วิทยาศาสตร์" ) ? 'selected' : '' ?>
                                    >วิทยาศาสตร์</option>
                                <option value="วิศวะ" <?=($data['Student_faculty']=="วิศวกรรมศาสตร์" ) ? 'selected' : ''
                                    ?>>วิศวกรรมศาสตร์</option>
                                <option value="สถาปัตยกรรมศิลปะและการออกแบบ"
                                    <?=($data['Student_faculty']=="สถาปัตยกรรมศิลปะและการออกแบบ" ) ? 'selected' : '' ?>
                                    >สถาปัตยกรรม ศิลปะและการออกแบบ</option>
                                <option value="ครุศาสตร์อุตสาหกรรมและเทคโนโลยี"
                                    <?=($data['Student_faculty']=="ครุศาสตร์อุตสาหกรรมและเทคโนโลยี" ) ? 'selected' : ''
                                    ?>>ครุศาสตร์อุตสาหกรรมและเทคโนโลยี</option>
                                <option value="เทคโนโลยีการเกษตร" <?=($data['Student_faculty']=="เทคโนโลยีการเกษตร" )
                                    ? 'selected' : '' ?>>เทคโนโลยีการเกษตร</option>
                                <option value="เทคโนโลยีสารสนเทศ" <?=($data['Student_faculty']=="เทคโนโลยีสารสนเทศ" )
                                    ? 'selected' : '' ?>>เทคโนโลยีสารสนเทศ</option>
                                <option value="อุตสาหกรรมอาหาร" <?=($data['Student_faculty']=="อุตสาหกรรมอาหาร" )
                                    ? 'selected' : '' ?>>อุตสาหกรรมอาหาร</option>
                                <option value="บริหารธุรกิจ" <?=($data['Student_faculty']=="บริหารธุรกิจ" ) ? 'selected'
                                    : '' ?>>บริหารธุรกิจ</option>
                                <option value="ศิลปศาสตร์" <?=($data['Student_faculty']=="ศิลปศาสตร์" ) ? 'selected'
                                    : '' ?>>ศิลปศาสตร์</option>
                                <option value="แพทยศาสตร์" <?=($data['Student_faculty']=="แพทยศาสตร์" ) ? 'selected'
                                    : '' ?>>แพทยศาสตร์</option>
                                <option value="ทันตแพทยศาสตร์" <?=($data['Student_faculty']=="ทันตแพทยศาสตร์" )
                                    ? 'selected' : '' ?>>ทันตแพทยศาสตร์</option>
                                <option value="วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ"
                                    <?=($data['Student_faculty']=="วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ" ) ? 'selected'
                                    : '' ?>>วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ</option>
                                <option value="วิทยาลัยนวัตกรรมการผลิตขั้นสูง"
                                    <?=($data['Student_faculty']=="วิทยาลัยนวัตกรรมการผลิตขั้นสูง" ) ? 'selected' : ''
                                    ?>>วิทยาลัยนวัตกรรมการผลิตขั้นสูง</option>
                                <option value="วิทยาลัยอุตสาหกรรมการบินนานาชาติ"
                                    <?=($data['Student_faculty']=="วิทยาลัยอุตสาหกรรมการบินนานาชาติ" ) ? 'selected' : ''
                                    ?>>วิทยาลัยอุตสาหกรรมการบินนานาชาติ</option>
                                <option value="วิทยาลัยวิศวกรรมสังคีต"
                                    <?=($data['Student_faculty']=="วิทยาลัยวิศวกรรมสังคีต" ) ? 'selected' : '' ?>
                                    >วิทยาลัยวิศวกรรมสังคีต</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="Student_department">สาขา</label>
                            <select name="Student_department" id="Student_department" required>
                                <option value="" disabled selected>เลือกสาขา</option>
                                <?php
                                if (!empty($data['Student_department'])) {
                                    echo '<option value="' . htmlspecialchars($data['Student_department']) . '" selected>' . htmlspecialchars($data['Student_department']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Student_degree">ชั้นปี</label>
                            <select name="Student_degree" id="Student_degree" required>
                                <option value="" disabled selected>เลือกชั้นปี</option>
                                <option value="1" <?=($data['Student_degree']=="1" ) ? 'selected' : '' ?>>1</option>
                                <option value="2" <?=($data['Student_degree']=="2" ) ? 'selected' : '' ?>>2</option>
                                <option value="3" <?=($data['Student_degree']=="3" ) ? 'selected' : '' ?>>3</option>
                                <option value="4" <?=($data['Student_degree']=="4" ) ? 'selected' : '' ?>>4</option>
                                <option value="ปริญญาโท" <?=($data['Student_degree']=="ปริญญาโท" ) ? 'selected' : '' ?>
                                    >ปริญญาโท</option>
                                <option value="ปริญญาเอก" <?=($data['Student_degree']=="ปริญญาเอก" ) ? 'selected' : ''
                                    ?>>ปริญญาเอก</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="Student_enroll">จำนวนนักศึกษาที่ลงทะเบียน</label>
                            <input type="number" id="Student_enroll" name="Student_enroll"
                                value="<?= htmlspecialchars($data['Student_enroll']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="Student_per_week">จำนวนนักศึกษาต่อสัปดาห์</label>
                            <input type="number" id="Student_per_week" name="Student_per_week"
                                value="<?= htmlspecialchars($data['Student_per_week']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>จำนวนชั่วโมงต่อสัปดาห์</h3>
                    <div class="hours-container">
                        <div class="hour-group-row">
                            <div class="hour-group">
                                <div class="checkbox-input">
                                    <input type="checkbox" id="bachelor_checkbox" class="course-checkbox"
                                        data-input="Hours_per_week_bachelor_degree" 
                                        <?=isset($data['Hours_per_week_bachelor_degree']) && $data['Hours_per_week_bachelor_degree']> 0
                    ? 'checked' : '' ?>>
                                    <label for="bachelor_checkbox">ปริญญาตรี (ปกติ)</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_bachelor_degree"
                                        name="Hours_per_week_bachelor_degree" min="0" step="0.5" value="<?= $data['Hours_per_week_bachelor_degree'] ?>"
                    <?=isset($data['Hours_per_week_bachelor_degree']) && $data['Hours_per_week_bachelor_degree']> 0 ? ''
                : 'disabled' ?> required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                            <div class="hour-group">
                                <div class="checkbox-input">
                                    <input type="checkbox" id="inter_bachelor_checkbox" class="course-checkbox"
                                        data-input="Hours_per_week_inter_bachelor_degree" <?=isset($data['Hours_per_week_inter_bachelor_degree']) &&
                        $data['Hours_per_week_inter_bachelor_degree']> 0 ? 'checked' : '' ?>>
                                    <label for="inter_bachelor_checkbox">ปริญญาตรี (นานาชาติ)</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_inter_bachelor_degree"
                                        name="Hours_per_week_inter_bachelor_degree" min="0" step="0.5" value="<?= $data['Hours_per_week_inter_bachelor_degree'] ?>"
                    <?=isset($data['Hours_per_week_inter_bachelor_degree']) &&
                    $data['Hours_per_week_inter_bachelor_degree']> 0 ? '' : 'disabled' ?>
                                        required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                            <div class="hour-group">
                                <div class="checkbox-input">
                                    <input type="checkbox" id="graduate_checkbox" class="course-checkbox"
                                        data-input="Hours_per_week_graduate" <?=isset($data['Hours_per_week_graduate']) && $data['Hours_per_week_graduate']> 0 ? 'checked' :
                    '' ?>>
                                    <label for="graduate_checkbox">บัณฑิต</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_graduate" name="Hours_per_week_graduate"
                                        min="0" step="0.5" value="<?= $data['Hours_per_week_graduate'] ?>" <?=isset($data['Hours_per_week_graduate']) &&
                    $data['Hours_per_week_graduate']> 0 ? '' : 'disabled' ?> required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-row"> 
                        <div class="form-group">
                            <label for="Amount_teach_hours_per_term">จำนวนชั่วโมงภาระงานต่อภาคเรียน</label>
                            <input type="number" id="Amount_teach_hours_per_term" name="Amount_teach_hours_per_term"
                                min="0" value="<//?= $data['Amount_teach_hours_per_term'] ?>" required>
                        </div>
                    </div>-->
                </div>

                <div class="form-section">
                    <h3>สัปดาห์ที่สอน</h3>
                    <?php
    // ดึงค่าที่เคยบันทึกจากฐานข้อมูล
    $selected_weeks = isset($data['Weeks_selected']) ? explode(',', $data['Weeks_selected']) : [];

    // ตรวจสอบว่ามีครบทั้ง 15 สัปดาห์ไหม
    $allWeeksSelected = count(array_intersect($selected_weeks, range(1, 15))) === 15;
?>

<div class="weeks-selection">
    <div class="week-options">
        <div class="option">
            <!-- ถ้าครบ 15 สัปดาห์ จะเช็ค "ทุกสัปดาห์" -->
            <input type="checkbox" id="all-weeks" <?=$allWeeksSelected ? 'checked' : '' ?>>
            <label for="all-weeks">ทุกสัปดาห์</label>
        </div>
        <div class="option">
            <!-- ถ้าไม่ได้เลือกครบทุกสัปดาห์ จะเช็ค "เลือกเอง" -->
            <input type="checkbox" id="custom-weeks" <?=!$allWeeksSelected && !empty($selected_weeks) ? 'checked' : '' ?>>
            <label for="custom-weeks">เลือกเอง</label>
        </div>
    </div>

    <div class="weeks-container"> 
        <div class="checkbox-row">
            <?php for ($i = 1; $i <= 15; $i++): ?>
                <div class="week-item">
                    <input type="checkbox" id="week-<?= $i ?>" class="week-checkbox"
                        name="Course_week[]" value="<?= $i ?>" 
                        <?=in_array($i, $selected_weeks) ? 'checked' : '' ?>>
                    <span class="week-number">
                        <?= $i ?>
                    </span>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>





                <div class="form-section">
                    <h3>ข้อมูลเพิ่มเติม</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Workload_for_reimbursement">ภาระงานเพื่อประกอบการเบิก</label>
                            <input type="text"  name="Workload_for_reimbursement"
                                value="<?= htmlspecialchars($data['Workload_for_reimbursement']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="remark">หมายเหตุ</label>
                            <input type="text" name="remark"
                                value="<?= htmlspecialchars($data['remark']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">บันทึก</button>
                </div>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
    


    <script>
        

        // กำหนดข้อมูลคณะและสาขา
        const departments = {
            วิทย์: [
                "เทคโนโลยีสิ่งแวดล้อมและการจัดการอย่างยั่งยืน",
                "เคมีอุตสาหกรรม",
                "เทคโนโลยีชีวภาพอุตสาหกรรม",
                "จุลชีววิทยาอุตสาหกรรม",
                "วิทยาการคอมพิวเตอร์",
                "คณิตศาสตร์ประยุกต์",
                "ฟิสิกส์อุตสาหกรรม",
                "สถิติประยุกต์และการวิเคราะห์ข้อมูล",
                "Kdai",
                "Industrial and Engineering Chemistry (International Program)",
                "Digital Technology and Integrated Innovation (International Program)",
            ],
            วิศวะ: [
                "วิศวกรรมระบบไอโอทีและสารสนเทศ",
                "วิศวกรรมไฟฟ้าสื่อสารและเครือข่าย",
                "วิศวกรรมไฟฟ้า",
                "วิศวกรรมอิเล็กทรอนิกส์",
                "วิศวกรรมคอมพิวเตอร์",
                "วิศวกรรมโยธา",
                "วิศวกรรมเครื่องกล",
                "วิศวกรรมขนส่งทางราง",
                "วิศวกรรมเมคคาทรอนิกส์และออโตเมชัน",
                "วิศวกรรมเกษตรอัจฉริยะ",
                "วิศวกรรมเคมี",
                "วิศวกรรมอุตสาหการ",
                "วิศวกรรมอาหาร",
                "B.Eng. Biomedical Engineering (Internation Program)",
                "B.Eng. Robotics and AI Engineering (Internation Program)",
                "B. Eng. Financial Enineering (International Program)",
                "B.Eng. Software Engineering (International Program)",
                "B.Eng. Civil Engineering (International Program)",
                "B.Eng. Mechanical Engineering (International Program)",
                "B.Eng. Chemical Engineering (International Program)",
                "B.Eng. Industrial Engineering and Logistics Management (International Program)",
                "B.Eng. Engineering Management and Entrepreneurship (Internation Program)",
                "B.Eng. Electrical Engineering (Internation Program)",
                "B.Eng. Energy Engineering (Internation Program)",
                "B.Eng. Computer Engineering (International Program)",
                "วิศวกรรมคอมพิวเตอร์ (ต่อเนื่อง)",
                "วิศวกรรมการวัดคุม (ต่อเนื่อง)",
                "วิศวกรรมโยธา (ต่อเนื่อง)",
                "วิศวกรรมระบบอุตสาหกรรมการเกษตร (ต่อเนื่อง)",
            ],
            สถาปัตยกรรมศิลปะและการออกแบบ: [
                "สถาปัตยกรรมหลัก",
                "ภูมิสถาปัตยกรรม",
                "สถาปัตยกรรมภายใน",
                "ศิลปอุตสาหกรรม",
                "สาขาวิชาการออกแบบประสบการณ์สำหรับสื่อบูรณาการ",
                "การถ่ายภาพ",
                "นิเทศศิลป์",
                "ภาพยนตร์และดิจิทัล มีเดีย",
                "สาขาวิชาศิลปกรรม มีเดียอาร์ต และอิลลัสเตชั่นอาร์ต",
                "สาขาวิชาสถาปัตยกรรม (หลักสูตรนานาชาติ)",
                "สาขาวิชาศิลปะสร้างสรรค์และภัณฑารักษ์ศึกษา (หลักสูตรนานาชาติ)",
                "หลักสูตรควบระดับปริญญาตรี 2 ปริญญา วิทยาศาสตรบัณฑิต สาขาวิชาสถาปัตยกรรม (หลักสูตรนานาชาติ) วิศวกรรมศาสตรบัณฑิต และสาขาวิชาวิศวกรรมโยธา (หลักสูตรนานาชาติ)",
                "หลักสูตรควบระดับปริญญาตรี 2 ปริญญา วิทยาศาสตรบัณฑิต สาขาวิชาสถาปัตยกรรม (หลักสูตรนานาชาติ) วิศวกรรมศาสตรบัณฑิต และสาขาวิชาวิศวกรรมโยธา (หลักสูตรนานาชาติ)",
            ],
            ครุศาสตร์อุตสาหกรรมและเทคโนโลยี: [
                "สถาปัตยกรรม (5 ปี)",
                "ครุศาสตร์การออกแบบสภาพแวดล้อมภายใน (5 ปี)",
                "ครุศาสตร์การออกแบบ",
                "ครุศาสตร์วิศวกรรม (4 ปี)",
                "สาขาวิชาเทคโนโลยีอิเล็กทรอนิกส์",
                "ครุศาสตร์เกษตร (4 ปี)",
                "บูรณาการนวัตกรรมเพื่อสินค้าและบริการ (ต่อเนื่อง 2 ปี)",
            ],
            เทคโนโลยีการเกษตร: [
                "เศรษฐศาสตร์และธุรกิจเพื่อพัฒนาการเกษตร",
                "โครงการหลักสูตรควบระดับปริญญาตรี 2 ปริญญา AGRINOVATOR",
                "นวัตกรรมการผลิตสัตว์น้ำและการจัดการทรัพยากรประมง",
                "การจัดการสมาร์ตฟาร์ม",
                "การออกแบบและการจัดการภูมิทัศน์เพื่อสิ่งแวดล้อม",
                "เทคโนโลยีการผลิตพืช",
                "เทคโนโลยีการผลิตสัตว์และวิทยาศาสตร์เนื้อสัตว์",
                "พัฒนาการเกษตร",
                "นิเทศศาสตร์เกษตร",
            ],
            เทคโนโลยีสารสนเทศ: [
                "เทคโนโลยีสารสนเทศ",
                "วิทยาการข้อมูลและการวิเคราะห์เชิงธุรกิจ",
                "Business Information Technology",
                "เทคโนโลยีปัญญาประดิษฐ์",
            ],
            อุตสาหกรรมอาหาร: [
                "เทคโนโลยีการหมักในอุตสาหกรรมอาหาร",
                "วิทยาศาสตร์และเทคโนโลยีการอาหาร",
                "วิศวกรรมแปรรูปอาหาร",
                "วิศวกรรมแปรรูปอาหาร โครงการหลักสูตรควบระดับปริญญาตรี 2 ปริญญา",
                "Culinary Science and Foodservice Management (International program)",
            ],
            วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ: [
                "วิศวกรรมวัสดุนาโน",
                "Dual Bachelor’s Degree Program consists of Bachelor of Engineering (Smart Materials Technology) and Bachelor of Engineering (Robotics and AI Engineering)",
            ],
            วิทยาลัยนวัตกรรมการผลิตขั้นสูง: [
                "วิศวกรรมระบบการผลิต",
                "วิศวกรรมระบบการผลิต (ต่อเนื่อง) (โครงการอาชีวะพรีเมียม)",
            ],
            บริหารธุรกิจ: [
                "บริหารธุรกิจบัณฑิต",
                "เศรษฐศาสตร์ธุรกิจและการจัดการ",
                "BACHELOR OF BUSINESS ADMINISTRATION (INTERNATIONAL PROGRAM)",
                "Bachelor of Business Administration Program in Global Entrepreneurship (International Program)",
            ],
            วิทยาลัยอุตสาหกรรมการบินนานาชาติ: [
                "วิศวกรรมการบินและอวกาศ (นานาชาติ)",
                "วิศวกรรมการบินและนักบินพาณิชย์ (นานาชาติ)",
                "การจัดการโลจิสติกส์ (นานาชาติ)",
            ],
            ศิลปศาสตร์: [
                "ภาษาอังกฤษ",
                "ภาษาญี่ปุ่นธุรกิจ",
                "นวัตกรรมการท่องเที่ยวและการบริการ",
                "ภาษาจีนเพื่ออุตสาหกรรม",
            ],
            แพทยศาสตร์: ["แพทยศาสตรบัณฑิต (นานาชาติ)"],
            วิทยาลัยวิศวกรรมสังคีต: ["วิศวกรรมดนตรีและสื่อประสม"],
            ทันตแพทยศาสตร์: ["Doctor of Dental Surgery"],
        };

        const facultySelect = document.getElementById("Student_faculty");
        const departmentSelect = document.getElementById("Student_department");

        facultySelect.addEventListener("change", function () {
            const selectedFaculty = this.value;
            departmentSelect.innerHTML = '<option value="">-- เลือกสาขา --</option>'; // รีเซ็ต dropdown สาขา

            if (selectedFaculty) {
                departments[selectedFaculty].forEach((dep) => {
                    const option = document.createElement("option");
                    option.value = dep;
                    option.textContent = dep;
                    departmentSelect.appendChild(option);
                });
                departmentSelect.disabled = false;
            } else {
                departmentSelect.disabled = true;
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".course-checkbox");

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    checkboxes.forEach((cb) => {
                        if (cb !== this) {
                            cb.checked = false;
                            const inputField = document.getElementById(
                                cb.getAttribute("data-input")
                            );
                            inputField.disabled = true;
                            inputField.value = ""; // ลบค่าที่เคยกรอก
                        }
                    });

                    const inputId = this.getAttribute("data-input");
                    document.getElementById(inputId).disabled = !this.checked;
                });
            });

            // ฟอร์มส่งข้อมูล
            const form = document.querySelector("form");
            form.addEventListener("submit", function (event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch("Add_data.php", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => response.text())
                    .catch((error) => console.error("Error:", error));
            });
        });
        
        document.addEventListener('DOMContentLoaded', () => {
    const allWeeksCheckbox = document.getElementById('all-weeks');
    const customWeeksCheckbox = document.getElementById('custom-weeks');
    const weekCheckboxes = document.querySelectorAll('.week-checkbox');

    function resetCheckboxes() {
        weekCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.disabled = false;  // ให้สามารถกดเลือกเองได้
            checkbox.closest('.week-item').classList.remove('selected'); // ล้างสีที่เลือก
        });
    }

    // เมื่อเลือก "ทุกสัปดาห์"
    allWeeksCheckbox.addEventListener('change', () => {
        if (allWeeksCheckbox.checked) {
            customWeeksCheckbox.checked = false; // ปิด "เลือกเอง"
            weekCheckboxes.forEach(checkbox => {
                checkbox.checked = true; // เลือกทั้งหมด
                checkbox.closest('.week-item').classList.add('selected'); // ไฮไลต์ทั้งหมด
            });
        } else if (!customWeeksCheckbox.checked) {
            resetCheckboxes(); // รีเซ็ต checkbox ทั้งหมด
        }
    });

    // เมื่อเลือก "เลือกเอง"
    customWeeksCheckbox.addEventListener('change', () => {
        if (customWeeksCheckbox.checked) {
            allWeeksCheckbox.checked = false; // ปิด "ทุกสัปดาห์"
            resetCheckboxes(); // รีเซ็ต checkbox ทั้งหมด
        }
    });

    // การตั้งค่าเริ่มต้นเมื่อโหลดหน้าเว็บ
    weekCheckboxes.forEach((checkbox) => {
        const parent = checkbox.closest(".week-item");

        // ไฮไลต์อันที่ถูกเลือกไว้
        if (checkbox.checked) {
            parent.classList.add("selected");
        }

        // เมื่อกด checkbox ให้เปลี่ยนสี
        checkbox.addEventListener("change", function () {
            if (this.checked) {
                parent.classList.add("selected");
            } else {
                parent.classList.remove("selected");
            }
        });
    });
});

document.querySelectorAll('.week-item').forEach(item => {
    item.addEventListener('click', () => {
        let checkbox = item.querySelector('.week-checkbox');
        checkbox.checked = !checkbox.checked;
        item.classList.toggle('selected', checkbox.checked);
    });
});



        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("details");

            form.addEventListener("submit", function (event) {
                event.preventDefault(); // ป้องกัน Form Submit ปกติ

                const formData = new FormData(form);

                fetch("Add_data.php", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert(data.message); // Popup เดียว
                            window.location.href = data.redirect; // Redirect
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    </script>

</body>

</html>