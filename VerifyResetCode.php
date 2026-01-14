
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรอกรหัสรีเซ็ต</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <style>
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

        .back-icon img {
            width: 40px;
            height: 40px;
            cursor: pointer;
            margin-left: 20px;
            margin-top: 1px;

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
            height: 4%;
        }

        .reset-box {
            margin-top: -3%;
            width: 100%;
            max-width: 300px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: loginFadeIn 0.5s ease;
            padding-top: 30px;
            border: 3px groove #000000;
            margin-bottom: 5%;
        }

        .content {
            margin-top: 1%;
            text-align: center;
            color: #ffffff;
            font-size: 50px;
            text-shadow: black 0px 0px 3px;
        }

        form {
            display: inline-block;
            margin-top: 5px;
        }

        input[type="text"] {
            padding: 15px;
            margin: 2px 0;
            display: block;
            width: 300px;
            box-sizing: border-box;
            font-family: 'Noto Sans Thai', sans-serif;
            border-radius: 18px;
        }

        input[type="submit"] {
            padding: 15px 25px;
            background: linear-gradient(90deg, #f57c00, #ff9800);
            color: white;
            border: none;
            border-radius: 18px;
            cursor: pointer;
            font-family: 'Noto Sans Thai', sans-serif;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #ff9800, #f57c00);
            width: 130px;
            height: 50px;
        }

        .reset-label {
            font-size: 16px;
            font-weight: 500;
            color:rgb(2, 2, 2);
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        input[type="submit"]:hover {
            background-color: #130b5e;
            transform: scale(1.05);
            box-shadow: #000000 0px 0px 10px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .button-container form {
            margin: 0;
            padding: 0;
        }

        .button-container input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <a href="RequestReset.php">
            <span class="back-icon">
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>
    <div class="reset-box">
        <form action="CheckResetCode.php" method="post">
            <label class="reset-label">กรอกรหัสที่ส่งไปในอีเมล</label>
            <input type="text" name="code" placeholder="รหัสรีเซ็ต" required>
            <div class="button-container">
                <input type="submit" value="ยืนยัน">
            <div>
        </form>
    </div>

</body>

</html>

