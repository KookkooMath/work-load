<?php
        include 'phak_math.php';

        session_start(); // เปิด session
        // ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
        if (!isset($_SESSION['UserID'])) {
            header("Location: Login.html"); // แก้เป็นหน้าที่น้องต้องการให้ไป
            exit();
        }

        $userid = $_SESSION['UserID']; // ดึงค่า UserID ของผู้ใช้ที่ล็อกอิน

            // ถ้ามีค่า year และ term ใน URL (กดเลือกปี)
            if (isset($_GET['Year']) && isset($_GET['Term'])) {
            $_SESSION['Year'] = $_GET['Year'];
            $_SESSION['Term'] = $_GET['Term'];
        }

            // ใช้ค่าปีล่าสุดที่เลือก ถ้าไม่มีให้ใช้ค่าปัจจุบัน
            $year = isset($_SESSION['Year']) ? $_SESSION['Year'] : date("Y") + 543;
            $term = isset($_SESSION['Term']) ? $_SESSION['Term'] : 1;



            $Title = isset($_GET['Title']) ? $_GET['Title'] : '';
            $Fname = isset($_GET['First_name']) ? $_GET['First_name'] : '';
            $Lname = isset($_GET['Last_name']) ? $_GET['Last_name'] : '';
            $Dep = isset($_GET['Department']) ? $_GET['Department'] : '';


            $sql = "SELECT  Title, First_name, Last_name, Department FROM user WHERE UserID = ?";
            $stmt1 = $conn->prepare($sql);
            $stmt1->bind_param("s", $userid);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            
            // ตรวจสอบว่าพบข้อมูลหรือไม่
            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                $Title = $row1["Title"];
                $Fname = $row1["First_name"];
                $Lname = $row1["Last_name"];
                $Dep = $row1["Department"];
            } else {
                $Title = "ไม่พบคำนำหน้า";
                $Fname = "ไม่พบชื่อ";
                $Lname = "ไม่พบนามสกุล";
                $Dep = "ไม่พบภาควิชา";
            }
            
            $stmt1->close();


        $stmt = $conn->prepare("SELECT teach.CourseID, courses.Course_name, teach.Year, teach.Term, teach.Section, teach.Course_day, teach.Course_time_start_lecture, teach.Course_time_end_lecture, teach.Course_time_start_lab, teach.Course_time_end_lab
            FROM teach
            JOIN courses ON teach.CourseID = courses.CourseID
            WHERE teach.Year = ? AND teach.Term = ? AND teach.UserID = ?
            ORDER BY FIELD(Course_day, 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์')");
        $stmt->bind_param("iis", $year, $term, $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        $courses_by_day = [];
        while ($row = $result->fetch_assoc()) {
            $courses_by_day[$row['Course_day']][] = $row;
        }


        ?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลภาระงานสอน</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background: linear-gradient(180deg, #f57c00, #ffffff);
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
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

        .add-icon img,
        .menu-icon img {
            width: 40px;
            height: 40px;
            cursor: pointer;
            filter: brightness(0) invert(1);
        }

        .add-icon {
            margin-right: 30px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: white;
            min-width: 150px;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 8px rgba(245, 124, 0, 0.2);
            /* ปรับเงาให้เข้ากับโทนสีส้ม */
            border-radius: 5px;
            z-index: 1001;
        }

        .dropdown-menu a {
            color: #333;
            /* เปลี่ยนจาก black เป็นสีเทาเข้มเพื่อความนุ่มนวล */
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #ddd;
            transition: all 0.3s ease;
            /* เพิ่ม transition เพื่อความลื่นไหล */
        }

        .dropdown-menu a:hover {
            background-color: #fff3e0;
            /* ใช้สีส้มอ่อนสำหรับ hover */
            color: #f57c00;
            /* เปลี่ยนสีตัวอักษรเป็นส้มเข้มเมื่อ hover */
        }

        .dropdown-menu.show {
            display: block;
        }

        .content-container {
            margin-top: 80px;
            padding: 20px;
        }

        .button {
            display: block;
            width: 10%;
            padding: 10px;
            text-align: center;
            color: white;
            background: linear-gradient(90deg, #f57c00, #ff9800);
            /* ใช้ gradient ส้มเข้มไปส้มสว่าง */
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            text-decoration: none;
            margin: 20px auto;
            box-shadow: 0 4px 6px rgba(245, 124, 0, 0.2);
            /* เพิ่มเงาสีส้มเพื่อความทันสมัย */
            transition: all 0.3s ease;
            /* เพิ่ม transition เพื่อความลื่นไหล */
        }

        .button:hover {
            background: linear-gradient(90deg, #ff9800, #f57c00);
            /* สลับ gradient เมื่อ hover */
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(245, 124, 0, 0.3);
            /* เงเข้มขึ้นเมื่อ hover */
        }

        .day-จันทร์ {
            background-color: #FFD700;
            /* สีเหลืองสำหรับวันจันทร์ */
            color: #333;
            /* ตัวอักษรสีเทาเข้มเพื่อให้อ่านง่าย */
        }

        .day-อังคาร {
            background-color: #FF69B4;
            /* สีชมพูสำหรับวันอังคาร */
            color: #333;
        }

        .day-พุธ {
            background-color: #32CD32;
            /* สีเขียวสำหรับวันพุธ */
            color: #333;
        }

        .day-พฤหัสบดี {
            background-color: #FFA500;
            /* สีส้มสำหรับวันพฤหัสบดี */
            color: #333;
        }

        .day-ศุกร์ {
            background-color: #1E90FF;
            /* สีฟ้าสำหรับวันศุกร์ */
            color: #333;
        }

        .day-เสาร์ {
            background-color: #800080;
            /* สีม่วงสำหรับวันเสาร์ */
            color: #333;
        }

        .day-อาทิตย์ {
            background-color: #FF4500;
            /* สีแดงสำหรับวันอาทิตย์ */
            color: #333;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <span class="add-icon" onclick="toggleMenu('dropdownMenu1')">
            <img src="img/add.png" alt="Add Icon">
        </span>
        <div class="dropdown-menu" id="dropdownMenu1">
            <a href="Add_course.php">เพิ่มวิชา</a>
            <a href="Edit_course.php">แก้ไขวิชา</a>
        </div>

        <span class="menu-icon" onclick="toggleMenu('dropdownMenu2')">
            <img src="img/user.png" alt="Profile Icon">
        </span>
        <div class="dropdown-menu" id="dropdownMenu2">
            <a href="Profile.php">โปรไฟล์</a>
            <a href="Logout.php">ออกจากระบบ</a>
        </div>
    </div>
    <!-- <script>
    function toggleMenu() {
                const menu = document.getElementById("dropdownMenu");
                menu.style.display = (menu.style.display === "block") ? "none" : "block";
            }

            // ปิดเมนูเมื่อคลิกนอกเมนู
            window.onclick = function (event) {
                const menu = document.getElementById("dropdownMenu");
                if (!event.target.closest('.menu-icon')) {
                    if (menu.style.display === "block") {
                        menu.style.display = "none";
                    }
                }
            }
        </script>-->
        <script>
    function toggleMenu(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('.dropdown-menu');

        allMenus.forEach(m => {
            if (m.id !== menuId) {
                m.style.display = 'none'; // ซ่อนเมนูอื่น
            }
        });

        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    // ปิดเมนูเมื่อคลิกนอกเมนูหรือไอคอน
    window.onclick = function (event) {
        if (!event.target.closest('.add-icon') && !event.target.closest('.menu-icon')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    };
</script>


    <div class="content-container">
        <form action="" method="GET" class="mb-4">
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-2">
                    <label class="font-medium">ปีการศึกษา:</label>
                    <input type="number" name="Year" value="<?= htmlspecialchars($year) ?>" min="2500" onchange="this.form.submit()" class="p-2 border rounded w-24 text-center">
                </div>
                <div class="flex items-center gap-2">
                    <label class="font-medium">ภาคเรียนที่:</label>
                    <select name="Term" onchange="this.form.submit()" class="p-2 border rounded">
                        <option value="1" <?= $term == 1 ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= $term == 2 ? 'selected' : '' ?>>2</option>
                        <option value="3" <?= $term == 3 ? 'selected' : '' ?>>3</option>
                    </select>
                </div>
            </div>
        </form>

        <h1 class="text-center text-xl mb-4">ระบบจัดการภาระงานอาจารย์ ปีการศึกษา <?= htmlspecialchars($year) ?> ภาคเรียนที่ <?= htmlspecialchars($term) ?></h1>
        <h2 class="text-center text-xl mb-4"><?= htmlspecialchars($Title) ?> <?= htmlspecialchars($Fname) ?> <?= htmlspecialchars($Lname) ?> ภาควิชา <?= htmlspecialchars($Dep) ?></h2>

        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mb-4 ml-4" onclick="showYearPopup()">เลือกข้อมูลปีเก่า</button>
        <button class="bg-red-500 text-white py-2 px-4 rounded-lg mb-4" onclick="toggleDeleteMode()">ลบข้อมูล</button>

        <div class="grid grid-cols-7 gap-4">
            <?php
            $days = ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'];
            foreach ($days as $course_day):
            ?>
                <div>
                    <div class="day-<?= htmlspecialchars($course_day) ?> text-white text-center py-2 rounded-lg font-bold"><?= htmlspecialchars($course_day) ?></div>
                    <div class="space-y-2 mt-2">
                        <a href="Add_teaching.php?Year=<?= urlencode($year) ?>&Term=<?= urlencode($term) ?>&Course_day=<?= urlencode($course_day) ?>" class="block bg-white p-2 rounded-lg text-center hover:bg-gray-200 transition">เพิ่มข้อมูล</a>
                        <?php if (!empty($courses_by_day[$course_day])): ?>
                            <?php
                            // เรียงข้อมูลก่อนแสดง
                            foreach ($courses_by_day as $day => &$courses) {
                                usort($courses, function ($a, $b) {
                                    $timeA = $a['Course_time_start_lecture'] ?? $a['Course_time_start_lab'] ?? '00:00';
                                    $timeB = $b['Course_time_start_lecture'] ?? $b['Course_time_start_lab'] ?? '00:00';
                                    return strcmp($timeA, $timeB);
                                });
                            }
                            unset($courses);
                            ?>
                            <?php foreach ($courses_by_day[$course_day] as $course): ?>
                                <div class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-200 transition relative flex-col items-center justify-center text-center">
                                    <a href="Update_teach.php?Year=<?= urlencode($year) ?>&Term=<?= urlencode($term) ?>&CourseID=<?= urlencode($course['CourseID']) ?>&Course_day=<?= urlencode($course_day) ?>&Section=<?= urlencode($course['Section']) ?>" class="block">
                                        <div class="font-bold text-lg"><?= htmlspecialchars($course['CourseID']) ?></div>
                                        <div class="text-sm"><?= htmlspecialchars($course['Course_name']) ?></div>
                                        <?php
                                            $typeText = '';
                                            if (!empty($course['Course_time_start_lecture']) && empty($course['Course_time_start_lab'])) {
                                                $typeText = 'ทฤษฎี';
                                            } elseif (empty($course['Course_time_start_lecture']) && !empty($course['Course_time_start_lab'])) {
                                                $typeText = 'ปฏิบัติ';
                                            /*} elseif (!empty($course['Course_time_start_lecture']) && !empty($course['Course_time_start_lab'])) {
                                                // ถ้ามีทั้งสองอย่าง ก็เลือกแสดงอะไรก่อนก็ได้ หรือจะแสดงทั้งคู่ก็ได้
                                                // เช่น:
                                                $typeText = 'ทฤษฎี/ปฏิบัติ';*/
                                            }
                                            ?>
                                        <div  class="text-sm"><?= $typeText ?> กลุ่ม <?= htmlspecialchars($course['Section']) ?></div>
                                        <div class="text-sm">เวลา :
                                            <?php if (!empty($course['Course_time_start_lecture']) && !empty($course['Course_time_end_lecture'])): ?>
                                                <?= date('H:i', strtotime($course['Course_time_start_lecture'])) ?> - <?= date('H:i', strtotime($course['Course_time_end_lecture'])) ?> น.
                                            <?php endif; ?>
                                            <?php if (!empty($course['Course_time_start_lab']) && !empty($course['Course_time_end_lab'])): ?>
                                                <?= date('H:i', strtotime($course['Course_time_start_lab'])) ?> - <?= date('H:i', strtotime($course['Course_time_end_lab'])) ?> น.
                                            <?php endif; ?>
                                        </div>

                                    </a>
                                    <button class="delete-btn text-red-500 hover:text-red-700 absolute top-2 right-2 hidden" onclick="confirmDelete('<?= urlencode($year) ?>', '<?= urlencode($term) ?>', '<?= urlencode($course['CourseID']) ?>', '<?= urlencode($course_day) ?>', '<?= urlencode($course['Section']) ?>')">✖</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="bg-gray-200 p-4 rounded-lg text-center">ว่าง</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Popup Form -->
        <div id="yearPopup" class="fixed inset-0 bg-gray-700 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">คัดลอกข้อมูลจากปีเก่า</h2>
                <form action="copy_data.php" method="POST">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label>ปีการศึกษาเก่า:</label>
                            <select name="copyYear" class="w-full p-2 border rounded">
                                <?php
                                $sql_year = "SELECT DISTINCT Year FROM teach ORDER BY Year DESC";
                                $result_year = $conn->query($sql_year);
                                if ($result_year && $result_year->num_rows > 0) {
                                    while ($row_year = $result_year->fetch_assoc()):
                                ?>
                                        <option value="<?= htmlspecialchars($row_year['Year']) ?>"><?= htmlspecialchars($row_year['Year']) ?></option>
                                    <?php endwhile; ?>
                                <?php } else { ?>
                                    <option value="">ไม่มีข้อมูล</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label>ภาคเรียนเก่า:</label>
                            <select name="copyTerm" class="w-full p-2 border rounded">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label>ปีการศึกษาใหม่:</label>
                            <input type="number" name="newYear" value="<?= htmlspecialchars($year) ?>" class="w-full p-2 border rounded">
                        </div>
                        <div>
                            <label>ภาคเรียนใหม่:</label>
                            <select name="newTerm" class="w-full p-2 border rounded">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">ยืนยันคัดลอก</button>
                        <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded-lg ml-2 hover:bg-red-600" onclick="closeYearPopup()">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>

        <a href="Export_to_excel.php" class="button">📥 ดาวน์โหลด Excel</a>
    </div>

    <script>
        function toggleDeleteMode() {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.classList.toggle('hidden');
            });
        }

        function confirmDelete(year, term, courseID, course_day, section) {
            if (confirm("ต้องการลบรายวิชานี้หรือไม่?")) {
                window.location.href = `delete_teach.php?Year=${year}&Term=${term}&CourseID=${courseID}&Course_day=${course_day}&Section=${section}`;
            }
        }

        function showYearPopup() {
            document.getElementById('yearPopup').classList.remove('hidden');
        }

        function closeYearPopup() {
            document.getElementById('yearPopup').classList.add('hidden');
        }
    </script>

    <?php $conn->close(); ?>
</body>

</html>