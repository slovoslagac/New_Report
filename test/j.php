<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 24.7.2018.
 * Time: 10:39
 */

//function solution($X, $A) {
//    $leavesArray = array();
//    $i = 0;
//    $end = null;
//    foreach($A as $item){
//        $tmpArray = range(1,$X);
//        if(!in_array($item, $leavesArray)){
//            array_push($leavesArray, $item);
//        }
//
//        $result = array_diff($tmpArray, $leavesArray);
//
//        print_r($result);
//        print_r($tmpArray);
//        print_r($leavesArray);
//        if(empty($result)) {
//            $end = $i;
//            break;
//        }
//
//        echo "$i - $end\n";
//        $i = $i + 1;
//
//
//    }
//
//    if($end >= 0){
//        return $end;
//    } else {
//        return -1;
//    }
//
//}

function solution($X, $A) {
    $leavesArray = array();
    $i = 0;
    $end = null;
    foreach($A as $item){
        $tmpArray = range(1,$X);
        if(!in_array($item, $leavesArray)){
            array_push($leavesArray, $item);
        }

        $result = array_diff($tmpArray, $leavesArray);

        if(empty($result)) {
            $end = $i;
            break;
        }


        $i = $i + 1;


    }

    if($end != null or $end == 0){
        return $end;
    } else {
        return -1;
    }

}


$N = array(1,2,3,4,5,6);
//$N = range(-10000,10000);

$N1 = array(1,3,2,4,5,6);

$N2 = array(1);

//echo "test1 " . solution(3,$N);

//echo "test2 " . solution(3,$N1);

echo "test3 " . solution(1,$N1);