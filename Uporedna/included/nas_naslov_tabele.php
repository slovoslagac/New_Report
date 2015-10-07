<tr class="table_header">
	<th colspan="5" value="<?php echo $league_id?>"><?php echo $league?></th>
	<?php for($i=1; $i <= $numBookmakers; $i++) { ?>
	<th colspan="3"><?php ?><?php echo $d['klad'.$i]?></th>
	<?php }?>
	<?php for($i=1; $i <= $numBookmakers; $i++) { ?>
	<th><?php echo substr($d['klad'.$i], 0,3)?></th>
	<?php }?>
	<th>VT</th>
</tr>