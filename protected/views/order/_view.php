<tr>
    <td><?= CHtml::encode($data->order_id); ?></td>
    <td><?= CHtml::encode($data->model->name); ?></td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->sizeLeft->size) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->sizeRight->size); ?>
    </td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->urkLeft->urk) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->urkRight->urk); ?>
    </td>
    <td><?= CHtml::encode($data->material->material); ?></td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->heightLeft->height) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->heightRight->height); ?>
    </td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->topVolumeLeft->Value) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->topVolumeRight->Value); ?>
    </td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->ankleVolumeLeft->Value) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->ankleVolumeRight->Value); ?>
    </td>
    <td><?php
        echo 'л ';
        echo CHtml::encode($data->kvVolumeLeft->Value) . '<br />';
        echo 'п ';
        echo CHtml::encode($data->kvVolumeRight->Value); ?>
    </td>
    <td><?= CHtml::encode($data->customer->surname) . ' '
            . iconv_substr(CHtml::encode($data->customer->name), 0, 1, 'utf-8') . '. '
            . iconv_substr(CHtml::encode($data->customer->patronymic), 0, 1, 'utf-8') . ".";?>
    </td>
    <td><?= CHtml::encode($data->employee->surname) . ' '
            . iconv_substr(CHtml::encode($data->employee->name), 0, 1, 'utf-8') . '. '
            . iconv_substr(CHtml::encode($data->employee->patronymic), 0, 1, 'utf-8') . '.'
        ?>
    </td>
    <td><?= CHtml::encode(date('d.m.Y H:i', strtotime($data->date_created))); ?></td>
    <td><?= CHtml::encode($data->comment); ?></td>

    <?php if (!Yii::app()->user->isGuest): ?>
        <td><?= CHtml::link('', $this->createUrl('order/update', ['id' => $data->order_id]), ['class' => 'editrow']); ?></td>
        <td><?= CHtml::link('', '#', [
                    'class' => 'delrow',
                    'submit' => $this->createUrl('order/delete', ['id' => $data->order_id]),
                    'params' => [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken],
                    'confirm' => 'Вы действительно хотите удалить этот заказ?',
                    'csrf' => true
                ]);?>
        </td>
    <?php endif; ?>
</tr>
