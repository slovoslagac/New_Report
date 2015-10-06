<tr class="naslov">
	<td class="liga" colspan="5" value="<?php echo $liga_id?>"><<?php echo $liga?></td>
	
	<?php for($i=0; $i<=$numBookmakers; $i++) {?>
	<td class="rightb" colspan="3"><?php echo $mat['klad_1'.$i]?></td>
	<?php }?>
	<?php for($i=0; $i<=$numBookmakers; $i++) {?>
	<td colspan="1"><?php echo substr($mat['klad_1'.$i], 0,3)?></td>
	<?php }
		
	?>
	<td class="leftrightb">VT</td>
</tr>