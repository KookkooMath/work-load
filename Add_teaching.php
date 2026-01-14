<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลรายวิชาสอน</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Add_teaching.css">
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
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            border-bottom: 2px solid #f57c00;
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
            box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.15);
            outline: none;
        }

        .form-group input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed; 
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

        .hour-group-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
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
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
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
            /* เปลี่ยนจาก #150B6E เป็นสีส้มเข้ม */
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
            background-color: #fff3e0;
        }

        .week-item.selected {
            background-color: #f57c00;
            border-color: #f57c00;
            color: white;
        }

        .week-item input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .week-number {
            font-size: 1rem;
            font-weight: 500;
        }

        .week-item.first-week {
            border: 1px solid #f57c00;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .submit-button {
            background-color: #f57c00;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1.125rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Noto Sans Thai', sans-serif;
            box-shadow: 0 4px 6px rgba(245, 124, 0, 0.2);
        }

        .submit-button:hover {
            background-color: #ff9800;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(245, 124, 0, 0.25);
        }

        .submit-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(245, 124, 0, 0.2);
        }

        .search-button-container {
            display: flex;
            align-items: flex-end;
            padding-bottom: 0.625rem;
        }

        .search-button {
            background-color: #f57c00;
            color: white;
            margin-bottom: -8px;
            padding: 0.625rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Noto Sans Thai', sans-serif;
            box-shadow: 0 2px 4px rgba(245, 124, 0, 0.15);
        }

        .search-button:hover {
            background-color: #ff9800;
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(245, 124, 0, 0.2);
        }

        .search-button:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(245, 124, 0, 0.1);
        }

        @media (max-width: 768px) {
            .search-button-container {
                align-items: flex-start;
                padding-bottom: 0;
            }

            .search-button {
                width: 100%;
                padding: 0.625rem;
            }
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f57c00;
            box-shadow: 0 0 0 0.25rem rgba(245, 124, 0, 0.25);
        }

        .form-check-input:checked {
            background-color: #f57c00;
            border-color: #f57c00;
        }

        /* Media Queries คงไว้เหมือนเดิม */
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
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>
    <?php
    include 'phak_math.php';

    $year = isset($_GET['Year']) ? $_GET['Year'] : '';
    $term = isset($_GET['Term']) ? $_GET['Term'] : '';
    $course_day = isset($_GET['Course_day']) ? $_GET['Course_day'] : '';

    ?>

    <div class="main-container">
        <div class="form-container">
            <h2>เพิ่มข้อมูลรายวิชาสอน วัน
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
                            <input type="text" name="CourseID" id="CourseID" placeholder="รหัสวิชา" required>
                        </div>
                        <div class="search-button-container">
                            <button type="button" class="search-button" onclick="searchCourse()">ค้นหา</button>
                        </div>
                        <div class="form-group">
                            <label for="Course_name">ชื่อวิชา</label>
                            <input type="text" id="Course_name" name="Course_name" placeholder="ชื่อวิชา" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Credit_combined">หน่วยกิต</label>
                            <input type="text" id="Credit_combined" name="Credit_combined" readonly>
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
                                    <input type="text" id="Course_time_start_lecture"  name="Course_time_start_lecture" placeholder="--:--" style="cursor: pointer;">
                                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                        <script>
                                            flatpickr("#Course_time_start_lecture", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i", 
                                            time_24hr: true
                                            });
                                        </script>
                                </div>
                                <div class="form-group">
                                    <label for="Course_time_end_lecture">สิ้นสุดเวลา</label>
                                            <input type="text" id="Course_time_end_lecture" name="Course_time_end_lecture" placeholder="--:--" style="cursor: pointer;">
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
                                    <input type="text" id="Course_time_start_lab" name="Course_time_start_lab" placeholder="--:--" style="cursor: pointer;">
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
                                    <input type="text" id="Course_time_end_lab" name="Course_time_end_lab" placeholder="--:--" style="cursor: pointer;">
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
                            <input type="text" id="Section" name="Section" placeholder="กลุ่มเรียน" required>
                        </div>
                        <div class="form-group">
                            <label for="Student_faculty">คณะ</label>
                            <select name="Student_faculty" id="Student_faculty" required>
                                <option value="" disabled selected>เลือกคณะ</option>
                                <option value="วิทย์">วิทยาศาสตร์</option>
                                <option value="วิศวะ">วิศวกรรมศาสตร์</option>
                                <option value="สถาปัตยกรรมศิลปะและการออกแบบ">สถาปัตยกรรม ศิลปะและการออกแบบ</option>
                                <option value="ครุศาสตร์อุตสาหกรรมและเทคโนโลยี">ครุศาสตร์อุตสาหกรรมและเทคโนโลยี</option>
                                <option value="เทคโนโลยีการเกษตร">เทคโนโลยีการเกษตร</option>
                                <option value="เทคโนโลยีสารสนเทศ">เทคโนโลยีสารสนเทศ</option>
                                <option value="อุตสาหกรรมอาหาร">อุตสาหกรรมอาหาร</option>
                                <option value="บริหารธุรกิจ">บริหารธุรกิจ</option>
                                <option value="ศิลปศาสตร์">ศิลปศาสตร์</option>
                                <option value="แพทยศาสตร์">แพทยศาสตร์</option>
                                <option value="ทันตแพทยศาสตร์">ทันตแพทยศาสตร์</option>
                                <option value="วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ">วิทยาลัยเทคโนโลยีและนวัตกรรมวัสดุ
                                </option>
                                <option value="วิทยาลัยนวัตกรรมการผลิตขั้นสูง">วิทยาลัยนวัตกรรมการผลิตขั้นสูง</option>
                                <option value="วิทยาลัยอุตสาหกรรมการบินนานาชาติ">วิทยาลัยอุตสาหกรรมการบินนานาชาติ
                                </option>
                                <option value="วิทยาลัยวิศวกรรมสังคีต">วิทยาลัยวิศวกรรมสังคีต</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Student_department">สาขา</label>
                            <select name="Student_department" id="Student_department" disabled required>
                                <option value="" disabled selected>เลือกสาขา</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Student_degree">ชั้นปี</label>
                            <select name="Student_degree" id="Student_degree" required>
                                <option value="" disabled selected>เลือกชั้นปี</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="ปริญญาโท">ปริญญาโท</option>
                                <option value="ปริญญาเอก">ปริญญาเอก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Student_enroll">จำนวนนักศึกษาที่ลงทะเบียน</label>
                            <input type="number" id="Student_enroll" name="Student_enroll"
                                placeholder="จำนวนนักศึกษาที่ลงทะเบียน" required>
                        </div>
                        <div class="form-group">
                            <label for="Student_per_week">จำนวนนักศึกษาต่อสัปดาห์</label>
                            <input type="number" id="Student_per_week" name="Student_per_week"
                                placeholder="จำนวนนักศึกษาต่อสัปดาห์" required>
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
                                        data-input="Hours_per_week_bachelor_degree">
                                    <label for="bachelor_checkbox">ปริญญาตรี (ปกติ)</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_bachelor_degree"
                                        name="Hours_per_week_bachelor_degree" min="0" step="0.5" disabled required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                            <div class="hour-group">
                                <div class="checkbox-input">
                                    <input type="checkbox" id="inter_bachelor_checkbox" class="course-checkbox"
                                        data-input="Hours_per_week_inter_bachelor_degree">
                                    <label for="inter_bachelor_checkbox">ปริญญาตรี (นานาชาติ)</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_inter_bachelor_degree"
                                        name="Hours_per_week_inter_bachelor_degree" min="0" step="0.5" disabled
                                        required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                            <div class="hour-group">
                                <div class="checkbox-input">
                                    <input type="checkbox" id="graduate_checkbox" class="course-checkbox"
                                        data-input="Hours_per_week_graduate">
                                    <label for="graduate_checkbox">บัณฑิต</label>
                                </div>
                                <div class="hours-input">
                                    <input type="number" id="Hours_per_week_graduate" name="Hours_per_week_graduate"
                                        min="0" step="0.5" disabled required>
                                    <span>ชั่วโมง/สัปดาห์</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-row"> 
                        <div class="form-group">
                            <label for="Amount_teach_hours_per_term">จำนวนชั่วโมงภาระงานต่อภาคเรียน</label>
                            <input type="number" id="Amount_teach_hours_per_term" name="Amount_teach_hours_per_term"
                                min="0" required>
                        </div>
                    </div>-->
                </div>
        
                <div class="form-section">
                    <h3>สัปดาห์ที่สอน</h3>
                    <div class="weeks-selection">
                        <div class="week-options">
                            <div class="option">
                                <input type="checkbox" id="all-weeks">
                                <label for="all-weeks">ทุกสัปดาห์</label>
                            </div>
                            <div class="option">
                                <input type="checkbox" id="custom-weeks">
                                <label for="custom-weeks">เลือกเอง</label>
                            </div>
                        </div>
                        <div class="weeks-container">
                            <div class="checkbox-row">
                                <?php for ($i = 1; $i <= 15; $i++): ?>
                                    <div class="week-item"> 
                                        <input type="checkbox" id="week-<?= $i ?>" class="week-checkbox" name="Course_week[]" value="<?= $i ?>">
                                        <span class="week-number"><?= $i ?></span>
                                    </div>
                                <?php endfor; ?>
                             </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>ข้อมูลเพิ่มเติม</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Workload_for_reimbursement">ภาระงานเพื่อประกอบการเบิก</label>
                            <input type="text" id="Workload_for_reimbursement" name="Workload_for_reimbursement">
                        </div>
                        <div class="form-group">
                            <label for="remark">หมายเหตุ</label>
                            <input type="text" id="remark" name="remark">
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
        function searchCourse() {
            let courseID = document.getElementById("CourseID").value.trim(); // รับค่า CourseID
            if (!courseID) {
                alert("กรุณากรอกรหัสวิชา");
                return;
            }

            let formData = new FormData();
            formData.append("CourseID", courseID);

            fetch("search_course.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response:", data); // เช็คค่าที่ได้จาก PHP

                    if (data.status === "success") {
                        document.getElementById("Course_name").value = data.course.Course_name;

                        // แสดงหน่วยกิตในรูปแบบเดียว
                        let creditString = `${data.course.Credit_total}(${data.course.Credit_lecture}-${data.course.Credit_lab}-${data.course.Credit_independent})`;
                        document.getElementById("Credit_combined").value = creditString;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Fetch error:", error));
        }

        
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
                "B.Eng. Biomedical Engineering (International Program)",
                "B.Eng. Robotics and AI Engineering (International Program)",
                "B.Eng. Financial Engineering (International Program)",
                "B.Eng. Software Engineering (International Program)",
                "B.Eng. Civil Engineering (International Program)",
                "B.Eng. Mechanical Engineering (International Program)",
                "B.Eng. Chemical Engineering (International Program)",
                "B.Eng. Industrial Engineering and Logistics Management (International Program)",
                "B.Eng. Engineering Management and Entrepreneurship (International Program)",
                "B.Eng. Electrical Engineering (International Program)",
                "B.Eng. Energy Engineering (International Program)",
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

        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".course-checkbox");

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    checkboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                            const inputField = document.getElementById(cb.getAttribute("data-input"));
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
            form.addEventListener("submit", function(event) {
                event.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

                const formData = new FormData(this);

                fetch("Add_data.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    //.then(data => alert(data))
                    .catch(error => console.error("Error:", error));
            });
        });

        // เมื่อโหลดหน้าเว็บ
        document.addEventListener("DOMContentLoaded", function() {
            const facultySelect = document.getElementById("Student_faculty");
            const departmentSelect = document.getElementById("Student_department");
            const weekItems = document.querySelectorAll(".week-item");
            const allWeeksCheckbox = document.getElementById("all-weeks");
            const customWeeksCheckbox = document.getElementById("custom-weeks");
            const form = document.querySelector("form");

            // การจัดการ dropdown คณะและสาขา
            facultySelect.addEventListener("change", function() {
                const selectedFaculty = this.value;
                departmentSelect.innerHTML =
                    '<option value="" disabled selected>เลือกสาขา</option>';

                if (selectedFaculty && departments[selectedFaculty]) {
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



            // การจัดการสัปดาห์ที่สอน
            weekItems.forEach((weekItem) => {
                weekItem.addEventListener("click", function() {
                    const customWeeksChecked = customWeeksCheckbox.checked;
                    if (customWeeksChecked) {
                        this.classList.toggle("selected");
                        const checkbox = this.querySelector(".week-checkbox");
                        checkbox.checked = this.classList.contains("selected");
                    }
                });
            });

            allWeeksCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    customWeeksCheckbox.checked = false;
                    weekItems.forEach((item) => {
                        item.classList.add("selected");
                        item.querySelector(".week-checkbox").checked = true;
                    });
                } else if (!customWeeksCheckbox.checked) {
                    weekItems.forEach((item) => {
                        item.classList.remove("selected");
                        item.querySelector(".week-checkbox").checked = false;
                    });
                }
            });

            customWeeksCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    allWeeksCheckbox.checked = false;
                    weekItems.forEach((item) => {
                        item.classList.remove("selected");
                        item.querySelector(".week-checkbox").checked = false;
                    });
                } else if (!allWeeksCheckbox.checked) {
                    weekItems.forEach((item) => {
                        item.classList.remove("selected");
                        item.querySelector(".week-checkbox").checked = false;
                    });
                }
            });

            // การส่งฟอร์ม
            form.addEventListener("submit", function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const selectedWeeks = [];
                weekItems.forEach((item) => {
                    if (item.classList.contains("selected")) {
                        selectedWeeks.push(item.querySelector(".week-number").textContent);
                    }
                });
                if (allWeeksCheckbox.checked) {
                    for (let i = 1; i <= 15; i++) {
                        selectedWeeks.push(i);
                    }
                }
                formData.append("selected_weeks", selectedWeeks.join(","));

                fetch("Add_data.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        console.log("Success:", data);
                        // อาจเพิ่มการ redirect หรือแจ้งเตือนที่นี่
                    })
                    .catch((error) => console.error("Error:", error));
            });


        });
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("details");

            form.addEventListener("submit", function(event) {
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