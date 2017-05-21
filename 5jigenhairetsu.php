<!-- <?php


$area1 = array('name' => 'Philippines_1', 'area' => 'cebu');
$area2 = array('name' => 'Philippines_2', 'area' => 'mactan');
$area3 = array('name' => 'Philippines_3', 'area' => 'manira');

$kind1 = array('name' => 'Japanese', 'money' => 'yen');
$kind2 = array('name' => 'Korean', 'money' => 'won');

$school1 = array('name' => 'NexSeed', 'place' => 'near_Ayala');
$school2 = array('name' => 'QQEnglish', 'time' => 'near_ITpark');
$school3 = array('name' => 'Target', 'time' => 'near_GaisanoMall');

$course1 = array('name' => 'programing_1', 'time' => 'morning');
$course2 = array('name' => 'programing_2', 'time' => 'afternoon');
$course3 = array('name' => 'english_1', 'time' => '6_lessons');
$course4 = array('name' => 'english_2', 'time' => '7_lessons');

$teacher1 = array('name' => 'Teacher_Eriko', 'gender' => 'female');
$teacher2 = array('name' => 'Teacher_Shinya', 'gender' => 'male');


$areas = array($area1, $area2, $area3);
$kinds = array($kind1, $kind2);
$shools = array($school1, $school2, $school3);
$courses = array($course1, $course2, $course3, $course4);
$teachers = array($teacher1, $teacher2);



echo 'I\'m taking' .$teachers[0][0][0][0]['name'] .'\'s class';
?> -->





<!-- <?php


$area1 = array('name' => 'Philippines_1', 'area' => 'cebu');
$area2 = array('name' => 'Philippines_2', 'area' => 'mactan');
$area3 = array('name' => 'Philippines_3', 'area' => 'manira');

$kind1 = array('name' => 'Japanese', 'money' => 'yen');
$kind2 = array('name' => 'Korean', 'money' => 'won');

$school1 = array('name' => 'NexSeed', 'place' => 'near_Ayala');
$school2 = array('name' => 'QQEnglish', 'time' => 'near_ITpark');
$school3 = array('name' => 'Target', 'time' => 'near_GaisanoMall');

$course1 = array('name' => 'programing_1', 'time' => 'morning');
$course2 = array('name' => 'programing_2', 'time' => 'afternoon');
$course3 = array('name' => 'english_1', 'time' => '6_lessons');
$course4 = array('name' => 'english_2', 'time' => '7_lessons');

$teacher1 = array('name' => 'Teacher_Eriko', 'time' => 'a.m.');
$teacher2 = array('name' => 'Teacher_Eriko', 'time' => 'p.m.');
$teacher3 = array('name' => 'Teacher_Shinya', 'time' => 'a.m.');
$teacher4 = array('name' => 'Teacher_Shinya', 'time' => 'p.m.');


$class = array($area1, $area2, $area3);
$area1 = array($kind1, $kind2);
$kind1 = array($school1, $school2, $school3);
$shool1 = array($course1, $course2, $course3);
$course1 = array($teacher1, $teacher2, $teacher3, $teacher4);

// $teachers = array($teacher1, $teacher2, $teacher3, $teacher4);



echo 'I\'m taking' .$class[0][0][0][0][0]['name'] .'\'s class';
echo 'and it starts at 9 ' .$class[0][0][0][0][0]['time'];

?>
 -->


 <!-- <?php


$teacher1 = array('name' => 'Teacher_Eriko', 'time' => 'a.m.');
$teacher2 = array('name' => 'Teacher_Eriko', 'time' => 'p.m.');
$teacher3 = array('name' => 'Teacher_Shinya', 'time' => 'a.m.');
$teacher4 = array('name' => 'Teacher_Shinya', 'time' => 'p.m.');
$teacher5 = array('name' => 'Teacher_Cledy', 'time' => '1p.m.');
$teacher6 = array('name' => 'Teacher_Blanche', 'time' => '2p.m.');
$teacher7 = array('name' => 'Teacher_Hubert', 'time' => '3p.m.');

$teacher8 = array('name' => 'Teacher_A', 'time' => '4p.m.');
$teacher9 = array('name' => 'Teacher_B', 'time' => '5p.m.');
$teacher10 = array('name' => 'Teacher_C', 'time' => '6p.m.');
$teacher11 = array('name' => 'Teacher_D', 'time' => '7p.m.');
$teacher12 = array('name' => 'Teacher_E', 'time' => '8p.m.');

$teacher13 = array('name' => 'Teacher_F', 'time' => '9p.m.');
$teacher14 = array('name' => 'Teacher_G', 'time' => '10p.m.');
$teacher15 = array('name' => 'Teacher_H', 'time' => '11p.m.');
$teacher16 = array('name' => 'Teacher_I', 'time' => '12a.m.');


$programing = array($teacher1, $teacher2, $teacher3, $teacher4);
$english = array($teacher5, $teacher6, $teacher7);

$NexSeed = array($programing, $english);

$school = array($NexSeed);

$Japanese = array($school);



echo 'I\'m taking' .$Japanese[0][0][0][0]['name'] .'\'s class. <br>';
echo 'It starts at 9 ' .$Japanese[0][0][0][0]['time'];


?> -->





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
echo 'It starts at 9 ' .$Japanese[0][0][0][0]['time'] .'<br>';
echo 'I\'m also taking ' .$Japanese[0][1][3][0]['name'] .'\'s class at 1' .$Japanese[0][1][3][0]['time'] .',<br>';
echo $Japanese[0][1][4][0]['name'] .'\'s class at 2' .$Japanese[0][1][4][0]['time'] .',<br>';
echo 'and ' .$Japanese[0][1][5][0]['name'] .'\'s class at 3' .$Japanese[0][1][5][0]['time'] .',<br>';
echo 'I\'m not taking ' .$Japanese[0][0][1][1]['name'] .'\'s class. <br>';


?>




