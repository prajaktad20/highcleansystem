<?php if($induction_company_model->single_induction == '1') { ?>

<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><input type="checkbox" id="selecctall_site" checked="checked" onclick="CheckSelectAllSite();"/>&nbsp;&nbsp;&nbsp;<h2>Site</h2></th></tr>
<?php foreach ($loop_site_contacts as $value)  { ?>
<tr><td><input class="checkbox_site" type="checkbox" name="induction_sites[]" checked="checked"  value="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->site_name; ?></td></tr>
<?php } ?>



<?php } else { ?>
	

<tr><th bgcolor="#5B9BD5" align="center" class="titlebar"><input type="checkbox" id="selecctall_site" onclick="CheckSelectAllSite();"/>&nbsp;&nbsp;&nbsp;<h2>Site</h2></th></tr>
<?php foreach ($loop_site_contacts as $value)  { ?>
<tr><td><input class="checkbox_site" type="checkbox" name="induction_sites[]" value="<?php echo $value->id; ?>" >&nbsp;&nbsp; <?php echo $value->site_name; ?></td></tr>
<?php } ?>


	
<?php } ?>	