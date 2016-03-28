<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10.3.2016
 * Time: 15:29
 * Obračun bonusa
 */




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

function PinnbetBonus($num_of_rows,$ticket_hour)
{
    $happy_hour_time = array (9,10,21,22);
    if( in_array($ticket_hour,$happy_hour_time)) {
        if ($num_of_rows == 3) {
            return 3;
        } elseif ($num_of_rows > 3 and $num_of_rows < 20) {
            return ($num_of_rows - 3) * 5;
        } elseif ($num_of_rows >= 20 and $num_of_rows < 24) {
            return ($num_of_rows - 11) * 10;
        } elseif ($num_of_rows >= 24 and $num_of_rows < 29) {
            return ($num_of_rows - 10) * 10;
        } elseif ($num_of_rows >= 29 and $num_of_rows < 35) {
            return ($num_of_rows - 9) * 10;
        } else {
            return 0;
        }
    } else {
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
}

//Trenutni PinbetBonusi

$mega_days = array('25.03.2016', '26.03.2016', '27.03.2016', '28.03.2016');

function PlanetwinBonus($num_of_rows, $ticket_hour, $ticket_day)
{
    global $mega_days;
    if (in_array($ticket_day, $mega_days)) {
        if ($num_of_rows < 6) {
            return $num_of_rows * 2;
        } elseif ($num_of_rows > 5 and $num_of_rows < 23) {
            return ($num_of_rows - 5) * 5 + 10;
        }  elseif ($num_of_rows > 23 and $num_of_rows < 30) {
            return ($num_of_rows - 13) * 10;
        } elseif ($num_of_rows >= 30) {
            return 200;
        } else {
            return 0;
        }
    } else {
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
}


function ObracunBonusa($source_id, $num_of_rows, $ticket_hour, $ticket_day)
{
    switch ($source_id) {
        case(2):
            return SoccerBonus($num_of_rows);
        case(4):
            return PinnbetBonus($num_of_rows, $ticket_hour);
        case (5):
            return PlanetwinBonus($num_of_rows, $ticket_hour, $ticket_day);
        default:
    }
}


//echo ObracunBonusa(2, 8, 9);

//echo ObracunBonusa(4, 6, 9);