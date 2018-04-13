<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 19.5.2017
 * Time: 12:31
 */
class lotto
{
    public $name;
    public $day;
    public $time;
    public $endtime;

    public function __construct($name, $day, $time, $etime)
    {
        $this->name = $name;
        $this->day = $day;
        $this->time = $time;
        $this->endtime = $etime;
    }

}


$date = new DateTime();
$time = date_format($date, 'G:i');
$day = date_format($date, 'N');


$allLoto = array();
$displayLoto = array();

//Sva izvlacenja lotoa;

$kanadaMax = new lotto('Kanada Max Loto 7/49', 6, '03:30', '05:30');
array_push($allLoto, $kanadaMax);

for ($i = 1; $i < 7; $i++) {
    $TexasALL = new lotto('Texas all or not 12/24', $i, '01:00', '03:00');
    array_push($allLoto, $TexasALL);
}

for ($i = 1; $i < 7; $i++) {
    $TexasALL = new lotto('Texas all or not 12/24', $i, '05:10', '07:10');
    array_push($allLoto, $TexasALL);
}

for ($i = 1; $i < 7; $i++) {
    $TexasALL = new lotto('Texas all or not 12/24', $i, '17:00', '19:00');
    array_push($allLoto, $TexasALL);
}

for ($i = 1; $i < 7; $i++) {
    $TexasALL = new lotto('Texas all or not 12/24', $i, '19:25', '21:25');
    array_push($allLoto, $TexasALL);
}


for ($i = 1; $i <= 7; $i++) {
    $grckaExtra = new lotto('Grcka extra 5  5/35', $i, '14:00', '16:00');
    array_push($allLoto, $grckaExtra);
}


for ($i = 1; $i <= 7; $i++) {
    $grckaExtra = new lotto('Grcka extra 5  5/35', $i, '18:00', '20:00');
    array_push($allLoto, $grckaExtra);
}

$southAfrica = new lotto('Juzno Africka Republika  6/49', 3, '19:30', '21:30');
array_push($allLoto, $southAfrica);

$southAfrica = new lotto('Juzno Africka Republika  6/49', 5, '19:30', '21:30');
array_push($allLoto, $southAfrica);


$rumunija = new lotto('Rumunski loto 6/49', 4, '18:00', '20:00');
array_push($allLoto, $rumunija);

$rumunija = new lotto('Rumunski loto 6/49', 7, '18:00', '20:00');
array_push($allLoto, $rumunija);


for ($i = 1; $i <= 7; $i++) {
    $poljskaKaskada = new lotto('Poljska kaskada 12/24', $i, '14:00', '16:00');
    array_push($allLoto, $poljskaKaskada);
}

for ($i = 1; $i <= 7; $i++) {
    $poljskaKaskada = new lotto('Poljska kaskada 12/24', $i, '21:40', '23:40');
    array_push($allLoto, $poljskaKaskada);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 6/45', $i, '09:00', '11:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 6/45', $i, '21:00', '23:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 5/36', $i, '10:00', '12:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 5/36', $i, '13:00', '15:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 5/36', $i, '16:00', '18:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 5/36', $i, '19:00', '21:00');
    array_push($allLoto, $russiaGos);
}

for ($i = 1; $i <= 7; $i++) {
    $russiaGos = new lotto('Ruski  GosLoto 5/36', $i, '22:00', '24:00');
    array_push($allLoto, $russiaGos);
}

$turska = new lotto('Turski  6/49', 6, '18:15', '20:15');
array_push($allLoto, $turska);

//Provera da li treba prikazati izvlacenje ;

foreach ($allLoto as $item) {
    if ($item->day == $day and $time > $item->time and $time < $item->endtime) {
        array_push($displayLoto, $item);
    }
}



if(!empty($displayLoto)) {
    ?>
    <h2 class="text-center" style = "color :#FF0000"> Loto rezultati koje treba proveriti</h2>
    <table class="table table-striped">
        </br>
        <thead>
        <tr>
            <th>Igra</th>
            <th>Vreme izvlačenja</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($displayLoto as $item) {
?>
            <tr>
                <th><?php echo $item->name ?></th>
                <th><?php echo $item->time ?></th>
            </tr>
        <?php } ?>
        </tbody>
    </table>


    <?php

}
//Prikazivanje izvlacenja
//foreach ($displayLoto as $item) {
//    echo "$item->name - $item->day - $item->time <br>";
//
//}