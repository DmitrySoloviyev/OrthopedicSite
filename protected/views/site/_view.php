<tr>
	<td><?php echo CHtml::encode($data->OrderID); ?></td>
	<td><?php echo CHtml::encode($data->model->ModelName); ?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->sizeLEFT->SizeValue)."<br />"; echo 'п '; echo CHtml::encode($data->sizeRIGHT->SizeValue);?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->urkLEFT->UrkValue)."<br />";  echo 'п '; echo CHtml::encode($data->urkRIGHT->UrkValue);?></td>
	<td><?php echo CHtml::encode($data->material->MaterialValue); ?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->heightLEFT->HeightValue)."<br />"; echo 'п '; echo CHtml::encode($data->heightRIGHT->HeightValue);?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->topVolumeLEFT->TopVolumeValue)."<br />"; echo 'п '; echo CHtml::encode($data->topVolumeRIGHT->TopVolumeValue);?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->ankleVolumeLEFT->AnkleVolumeValue)."<br />"; echo 'п '; echo CHtml::encode($data->ankleVolumeRIGHT->AnkleVolumeValue);?></td>
	<td><?php echo 'л '; echo CHtml::encode($data->kvVolumeLEFT->KvVolumeValue)."<br />"; echo 'п '; echo CHtml::encode($data->kvVolumeRIGHT->KvVolumeValue);?></td>
	<td><?php echo CHtml::encode($data->customer->CustomerSN)." "
						.iconv_substr(CHtml::encode($data->customer->CustomerFN), 0, 1, 'utf-8').". "
						.iconv_substr(CHtml::encode($data->customer->CustomerP), 0, 1, 'utf-8')."."
		;?></td>
	<td><?php echo CHtml::encode($data->employee->EmployeeSN)." "
						.iconv_substr(CHtml::encode($data->employee->EmployeeFN), 0, 1, 'utf-8').". "
						.iconv_substr(CHtml::encode($data->employee->EmployeeP), 0, 1, 'utf-8')."."
		?></td>
	<td><?php echo CHtml::encode($data->Date); ?></td>
	<td><?php echo CHtml::encode($data->Comment); ?></td>
	<td><?php echo CHtml::link('', array('site/update', 'id'=>$data->OrderID), array('class'=>'editrow'));?></td>
	<td><?php echo CHtml::link('', '#', array(
					'class'=>'delrow',
					'submit'=>array(
						'site/delete',
						'id'=>$data->OrderID,
					),
					'confirm'=>'Вы действительно хотите удалить этот заказ?', 
					'csrf' => true)
				);?>
	</td>
</tr>