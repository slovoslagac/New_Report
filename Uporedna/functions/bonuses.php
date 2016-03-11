<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10.3.2016
 * Time: 15:29
 * Obračun bonusa
 */


//$soccer = array(6 => 5, 7 => 10);
//$pinnbet = array(4 => 3, 5 => 2, 6 => 10);


//Trenutni Soccer bonusi

function SoccerBonus($num_of_rows)
{
    global $soccer;
    if ($num_of_rows < 5) {
        return 0;
    } elseif ($num_of_rows > 15) {
        return 50;
    } else {
        return ($num_of_rows - 5) * 5;
    }
}

//Trenutni Innbet bonusi

function PinnbetBonus($num_of_rows)
{
    global $pinnbet;
    if ($num_of_rows < 4) {
        return 0;
    } elseif ($num_of_rows == 4) {
        return 3;
    } elseif ($num_of_rows > 4 and $num_of_rows < 21) {
        return ($num_of_rows - 4) * 5;
    } elseif ($num_of_rows >= 21 and $num_of_rows < 25) {
        return ($num_of_rows - 12) * 10;
    } elseif ($num_of_rows >= 25 and $num_of_rows < 29) {
        return ($num_of_rows - 11) * 10;
    } else {
        return ($num_of_rows - 10) * 10;
    }
}

//Trenutni PinbetBonusi

function PlanetwinBonus($num_of_rows, $ticket_hour)
{
    if ($ticket_hour == 9 or $ticket_hour == 21) {
        if ($num_of_rows < 3) {
            return 0;
        } elseif ($num_of_rows == 3) {
            return 3;
        } elseif ($num_of_rows == 4) {
            return 5;
        } elseif ($num_of_rows == 5) {
            return 9;
        } elseif ($num_of_rows > 5 and $num_of_rows < 25) {
            return ($num_of_rows - 5) * 5 + 8;
        } else {
            return ($num_of_rows - 14) * 10 + 5;
        }
    } else {
        if ($num_of_rows < 4) {
            return 0;
        } elseif ($num_of_rows == 4) {
            return 2;
        } elseif ($num_of_rows == 5) {
            return 6;
        } elseif ($num_of_rows > 5 and $num_of_rows < 25) {
            return ($num_of_rows - 4) * 5;
        } else {
            return ($num_of_rows - 14) * 10;
        }

    }
}


function ObracunBonusa($source_id, $num_of_rows, $ticket_hour)
{
    switch ($source_id) {
        case(2):
            return SoccerBonus($num_of_rows);
        case(4):
            return PinnbetBonus($num_of_rows);
        case (5):
            return PlanetwinBonus($num_of_rows, $ticket_hour);
        default:
    }
}


//echo ObracunBonusa(2, 8, 9);

//echo ObracunBonusa(4, 6, 9);