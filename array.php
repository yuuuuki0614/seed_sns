<?php


$teacher1 = array('name' => 'Teacher_Eriko', 'time' => 'a.m.');
$teacher2 = array('name' => 'Teacher_Eriko', 'time' => 'p.m.');
$teacher3 = array('name' => 'Teacher_Shinya', 'time' => 'a.m.');
$teacher4 = array('name' => 'Teacher_Shinya', 'time' => 'p.m.');
$teacher5 = array('name' => 'Teacher_Cledy', 'time' => 'p.m.');
$teacher6 = array('name' => 'Teacher_Blanche', 'time' => 'p.m.');
$teacher7 = array('name' => 'Teacher_Hubert', 'time' => 'p.m.');

$teacher8 = array('name' => 'Teacher_A', 'time' => 'a.m.');
$teacher9 = array('name' => 'Teacher_B', 'time' => 'a.m.');
$teacher10 = array('name' => 'Teacher_C', 'time' => 'a.m.');
$teacher11 = array('name' => 'Teacher_D', 'time' => 'a.m.');
$teacher12 = array('name' => 'Teacher_E', 'time' => 'a.m.');

$teacher13 = array('name' => 'Teacher_F', 'time' => 'a.m.');
$teacher14 = array('name' => 'Teacher_G', 'time' => 'p.m.');
$teacher15 = array('name' => 'Teacher_H', 'time' => 'p.m.');
$teacher16 = array('name' => 'Teacher_I', 'time' => 'p.m.');


$AM = array($teacher1, $teacher3);
$PM = array($teacher2, $teacher4);
$_9am = array($teacher8, $teacher9);
$_10am = array($teacher10, $teacher11);
$_11am = array($teacher12, $teacher13);
$_1pm = array($teacher5, $teacher14);
$_2pm = array($teacher6, $teacher15);
$_3pm = array($teacher7, $teacher16);


$programing = array($AM, $PM);
$english = array($_9am, $_10am, $_11am, $_1pm, $_2pm, $_3pm);


$NexSeed = array($programing, $english);
$QQEnglish = array($english);
$Target = array($english);


$Japanese = array($NexSeed);
$Korean = array($QQEnglish, $Target);



// echo $Japanese[0][0][0][1]['name'];

echo 'I\'m taking ' .$Japanese[0][0][0][0]['name'] .'\'s class. <br>';
echo 'It starts at 9 ' .$Japanese[0][0][0][0]['time'];

?>