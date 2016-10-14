<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 8.10.2016
 * Time: 15:19
 */
//class testEvent
//{
//    function getAllEvents()
//    {
//        global $conn_oracle;
//
//        $sql = $conn_oracle->query("select *
//from TELEBET.SP_EVENT e
//where E.DATE_TIME > sysdate - interval '1' day
//and e.date_time < sysdate + interval '2' day");
//        $sql->execute();
//        $testEvent = $sql->fetchAll(PDO::FETCH_OBJ );
//        return $testEvent;
//    }
//}


class testEvent
{
    function getAllEvents()
    {
        global $conn_oracle;

        $sql = oci_parse($conn_oracle,"select *
from TELEBET.SP_EVENT e
where E.DATE_TIME > sysdate - interval '1' day
and e.date_time < sysdate + interval '2' day");
        oci_execute($sql);
        while (($row = oci_fetch_object($sql)) != false) {
            $testEvent[] = $row;
        }
//        $testEvent = $sql->fetchAll(PDO::FETCH_OBJ );
        return $testEvent;
    }
}