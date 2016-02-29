<?php
include(join(DIRECTORY_SEPARATOR, array('conn', 'mysqlNewPDO.php')));

$sql1 ="Select id, Name, LastName from Oddsters";

$allOddsters = $conn->prepare($sql1);
$allOddsters->execute();
$oddsterList = $allOddsters ->fetchAll(PDO::FETCH_ASSOC);
$SourceComments;

if ($sifraTiketa != "") {



	$sql2 = "select o.Name, o.LastName, DATE_FORMAT(c.tstamp,'%d.%c.%Y %H:%i') as time, c.comment, c.id as comment_id
from ticket_comment c, Oddsters o
where c.commented_by = o.id
and c.show_comment = 1
and c.ticket_id = $sifraTiketaShort
and c.bookie_shop = $uplatnoMesto
and round = $roundId
order by c.tstamp desc


";



	$curr_comments = $conn->prepare($sql2);
	$curr_comments->execute();
	$SourceComments = $curr_comments->fetchAll(PDO::FETCH_ASSOC);




}
?>