<?php
$selected1 = "selected";
$selected2 = "";
  
if ($sexo == "F"){
  $selected2 = "selected";
  $selected1 = "";
}

?>

<select size="1" name="sexo" id="sexo" class="form-control" style="background:#E0FFFF;">
	<option <?php echo $selected1;?> value="M">Masculino</option>
    <option <?php echo $selected2;?> value="F">Feminino</option>
</select>