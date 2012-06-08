<?php

$view = '
<div class="view split-view">
	
	<!-- '. $module_name .' List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record[\''.$primary_key_field.'\']; ?>">
						<p>
							<b><?php echo (empty($record[\''.$module_name_lower.'_name\']) ? $record[\''.$primary_key_field.'\'] : $record[\''.$module_name_lower.'_name\']); ?></b><br/>
							<span class="small"><?php echo (empty($record[\''.$module_name_lower.'_description\']) ? lang(\''.$module_name_lower.'_edit_text\') : $record[\''.$module_name_lower.'_description\']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang(\''.$module_name_lower.'_no_records\'); ?> <?php echo anchor(SITE_AREA .\'/'.$controller_name.'/'.$module_name_lower.'/create\', lang(\''.$module_name_lower.'_create_new\'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- '. $module_name .' Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .\'/'.$controller_name.'/'.$module_name_lower.'/create\')?>"><?php echo lang(\''.$module_name_lower.'_create_new_button\');?></a>

				<h3><?php echo lang(\''.$module_name_lower.'_create_new\');?></h3>

				<p><?php echo lang(\''.$module_name_lower.'_edit_text\'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>'.$module_name.'</h2>
	<table>
		<thead>
			<tr>';

for($counter=1; $field_total >= $counter; $counter++)
{
	// only build on fields that have data entered. 

	//Due to the requiredif rule if the first field is set the the others must be

	if (set_value("view_field_label$counter") == NULL)
	{
		continue; 	// move onto next iteration of the loop
	}
	$view .= '
		<th>'. set_value("view_field_label$counter").'</th>';
}
if ($use_soft_deletes == 'true')
{
	$view .= '
		<th>Deleted</th>';
}
if ($use_created == 'true')
{
	$view .= '
		<th>Created</th>';
}
if ($use_modified == 'true')
{
	$view .= '
		<th>Modified</th>';
}

$view .= '
		<th><?php echo lang(\''.$module_name_lower.'_actions\'); ?></th>
		</tr>
		</thead>
		<tbody>
<?php
foreach ($records as $record) : ?>
			<tr>';
for($counter=1; $field_total >= $counter; $counter++)
{
	// only build on fields that have data entered. 

	//Due to the requiredif rule if the first field is set the the others must be

	if (set_value("view_field_name$counter") == NULL || set_value("view_field_name$counter") == $primary_key_field)
	{
		continue; 	// move onto next iteration of the loop
	}
	$field_name = $db_required ? $module_name_lower . '_' . set_value("view_field_name$counter") : set_value("view_field_name$counter");

	$view .= '
				<td><?php echo $record->'.$field_name.'?></td>';
}
if ($use_soft_deletes == 'true')
{
	$view .= '
				<td><?php echo $record->deleted > 0 ? lang(\''.$module_name_lower.'_true\') : lang(\''.$module_name_lower.'_false\')?></td>';
}
if ($use_created == 'true')
{
	$view .= '
				<td><?php echo $record->'.set_value("created_field").'?></td>';
}
if ($use_modified == 'true')
{
	$view .= '
				<td><?php echo $record->'.set_value("modified_field").'?></td>';
}
$view .= '
				<td><?php echo anchor(SITE_AREA .\'/'.$controller_name.'/'.$module_name_lower.'/edit/\'. $record->'.$primary_key_field.', lang(\''.$module_name_lower.'_edit\'), \'class="ajaxify"\'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
';

	echo $view;
?>
