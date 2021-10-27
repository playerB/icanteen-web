<?php 
    session_start();
    include('Connections/condb.php'); 
    //if(!isset($_SESSION['username'])){
        //$_SESSION['msg'] = "You must log in first";
        //header('location: login.php');
    //}
    $sql = "SELECT * FROM icanteen_menu WHERE m_id = 1"; //WHERE patient_id = $_SESSION['patient_id']
    $result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    //$sql1 = "SELECT * FROM appointment WHERE patient_id = ''";
    //$result1 = mysqli_query($conn,$sql1);
    //$sql2 = "SELECT * FROM vaccination WHERE patient_id = ''";
    //$result2 = mysqli_query($conn,$sql2);
?>

<!doctype html>
<html lang="en">

<head>
    <title>
        ประวัติบุตร
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Prompt" rel="stylesheet">
    <!-- <link rel="shortcut icon" href="https://www.pinclipart.com/picdir/middle/216-2163337_baby-head-with-a-small-heart-outline-comments.png" /> -->
</head>

<body style="font-family: 'Prompt', sans-serif;">
    <header>
        <div class="nav">
            <ul>
                <li>
                    <a href="login.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>
    <h1 style="text-align: center; font-weight: bold ;">
        ประวัติบุตร
    </h1>
    <p style = "font-size: x-large; margin-left: 60px;">
        ข้อมูลการนัด
    </p>
    <table style = "margin-left: 60px; border-color: black; border-collapse: collapse;" border=1px>
        <thead>
            <tr align="center" style="font-weight: bold;">
                <td width="200">วันที่</td>
                <td width="200">เวลา</td>
                <td width="200">วัคซีน</td>
            </tr>
        </thead>
        <tbody>
            <!--?php while $row1 = mysqli_fetch_assoc($result1)) : ?> -->
            <tr align="center">
                <td>12/04/2000<!--?php echo $row1['appointment_date']; ?--></td>
                <td>13.08<!--?php echo $row1['appointment_time']; ?--></td>
                <td>Covid<!--?php echo $row1['appointment_vaccine']; ?--></td>
            </tr>
            <!--?php endwhile ?-->
        </tbody>
    </table>
    <!-- ทำphp -->
    <p style = "font-size: x-large; margin-left: 60px;">
        ข้อมูลบุตร
    </p>
    <table style = "border: none; margin-left: 60px; margin-bottom: 0px">
        <tbody>
            
            <tr>
                <td width="200">ชื่อจริง</td>
                <td width="200"><strong><?php echo $result['m_name']; ?></strong></td>
                <td width="200">นามสกุล</td>
                <td width="200"><strong><?php echo $result['m_resname']; ?></strong></td>
            </tr>
            <tr>
                <td>ชื่อเล่น</td>
                <td><strong><?php echo $result['m_id']; ?></strong></td>
                <td>เพศ</td>
                <td><strong><?php echo $result['m_price']; ?></strong></td>
            </tr>
            <tr>
                <td>วัน/เดือน/ปีเกิด</td>
                <td><strong><?php echo $result['m_name']; ?></strong></td>
                <td>กรุ๊ปเลือด</td>
                <td><strong><?php echo $result['m_price']; ?></strong></td>
            </tr>
            <tr>
                <td>เลขประจำตัวประชาชน</td>
                <td><strong><?php echo $result['m_id']; ?></strong></td>
                <td>แพทย์ประจำตัว</td>
                <td><strong><?php echo $result['m_price']; ?></strong></td>
            </tr>
            
        </tbody>
    </table>
    <p style = "margin-left: 62px; margin-top: 0;">โรคหรืออาการแรกเกิด :<strong><?php echo $result['m_resname']; ?></strong></p>
    <p style = "font-size: x-large; margin-left: 60px;">
        ประวัติการฉีดวัคซีน
    </p>
    <table style = "margin-left: 60px; border-color: black; border-collapse: collapse;" border=1px>
        <thead>
            <tr align="center" style="font-weight: bold;">
                <td width="200">วันที่</td>
                <td width="200">วัคซีน</td>
                <td width="400">อาการข้างเคียง</td>
            </tr>
        </thead>
        <tbody>
            <!--?php while $row2 = mysqli_fetch_assoc($result2)) : ?> -->
            <tr align="center">
                <td>12/04/2000<!--?php echo $row2['vaccination_date']; ?--></td>
                <td>Covid<!--?php echo $row2['vaccination_vaccine']; ?--></td>
                <td>ปวดหัว ไข้ขึ้นสูง เป็นขี้เกียจ<!--?php echo $row2['vaccination_sideeffect']; ?--></td>
            </tr>
            <!-- ?php endwhile ? -->
        </tbody>
    </table><br>
    <!-- ทำphp -->
    <input class = "button" type="button" value="แก้ไขประวัติ" onclick="location.href='https://instagram.com/na.jaemin0813'" style="margin-left: 60px;">
    <input class = "button" type="button" onclick="location.href='https://instagram.com/oohsehun'" value="ย้อนกลับ">

</body>
</html>