<tr class="table_matches row<?php echo($j++ & 1 )?>">
	<td><input type="hidden" name="cmp_name[]" value="<?php echo $d['name']?>" /><?php echo $d['name']?></td>
	<input type="hidden" name="cmp_id[]" value="<?php echo $d['id']?>" />
	<td><input type="hidden" name="cmp_position[]" value="<?php echo $d['position']?>" /><?php echo $d['position']?></td>
	<td><input type="number" name="cmp_new_position[]"/></td>
</tr>