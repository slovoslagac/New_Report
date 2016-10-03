<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 23.9.2016
 * Time: 13:40
 */
require (join(DIRECTORY_SEPARATOR, array('..','includes', 'init.php')));
$sourceId = 12;


if(isset($_POST["submit"])) {

//    $open_data =  fopen($_FILES['file_upload']['tmp_name']);
    $row = 0;
    clear_match_insert_table();
    if (($handle = fopen($_FILES['file_upload']['tmp_name'],'r')) !== FALSE) {

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $row++;
            $num = count($data);

            $league = $data[0];
            $leagueId = preg_replace('/\s+/', '',$data[0]);
            $homeTeam = $data[1];
            $homeTeamId = preg_replace('/\s+/', '',$data[1]);
            $visitorTeam = $data[2];
            $visitorTeamId = preg_replace('/\s+/', '',$data[2]);
            $match = "$homeTeam --- $visitorTeam";
            $matchId = $leagueId.$homeTeamId.$visitorTeamId;

            if($league != "" and $leagueId != "" and $homeTeam != "" and $homeTeamId != "" and $visitorTeam != "" and $visitorTeamId != "") {

                $match = new Match($league, $leagueId, $homeTeam, $homeTeamId, $visitorTeam, $visitorTeamId, $match, $matchId, $sourceId);
                $match ->add_match();
            }

        }

//        foreach ($matches as $mat) {
//
//            echo "$mat->league : $mat->match<br/>";
//        }

//        echo "<br/>";

        echo "Upisano je $row meceva";
        fclose($handle);
    }

}





$max_file_size = 200000;
?>
<form action="file_upload.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
        <input type="file" name="file_upload" />
        <input type="submit" name="submit" value="Upload">
</form>