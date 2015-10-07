<tr class="table_matches row<?php echo($j++ & 1 )?>">
	<th class="leftborder"><?php echo $day?></th>
	<th class="leftborder"><?php echo $time?></th>
	<th class="leftborder"><?php echo $code?></th>
	<th class="leftborder team"><?php echo $home_team?></th>
	<th class="leftborder team"><?php echo $visitor_team?></th>
	<?php for($i=1; $i<=$numBookmakers; $i++) { $ki1=$d['ki1'.$i]; $ki3=$d['ki3'.$i];?>
	<th class="leftborder<?php echo ($fav == 1 && !empty($ki1) && $maxOdds[$code] == (double) $ki1) ? ' winner' : ''; ?>"><?php echo $ki1?></th>
	<th><?php echo $d['ki2'.$i]?></th>
	<th class="rightborder<?php echo ($fav == 3 && !empty($ki3) && $maxOdds[$code] == (double) $ki3) ? ' winner' : ''; ?>"><?php echo $ki3?></th>
	<?php }
	for($i=1; $i<=$numBookmakers; $i++) {  $ug=$d['ug1'.$i]?>
	<th class="rightborder<?php echo (!empty($ug) && $maxTG[$code] == (double) $ug) ? ' winner' : ''; ?>"><?php echo $ug?></th>
	<?php }?>
	<th class="rightborder">€</th>
</tr>