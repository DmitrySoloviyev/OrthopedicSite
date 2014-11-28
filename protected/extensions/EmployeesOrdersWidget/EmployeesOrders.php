<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 29.09.14
 * Time: 22:20
 */
class EmployeesOrders extends CWidget
{
    private $monthRu = [
        'January' => 'Январь',
        'February' => 'Февраль',
        'March' => 'Март',
        'April' => 'Апрель',
        'May' => 'Май',
        'June' => 'Июнь',
        'July' => 'Июль',
        'August' => 'Август',
        'September' => 'Сентябрь',
        'October' => 'Октябрь',
        'November' => 'Ноябрь',
        'December' => 'Декабрь',
    ];

    public function init()
    {
        $sql = 'SELECT
            COUNT(*) AS count_orders,
            MONTHNAME(o.date_created) AS month_name,
            CONCAT(e.surname, " ", LEFT(e.name, 1), ".", LEFT(e.patronymic, 1), ".") as employee
        FROM orders o JOIN employees e ON o.employee_id = e.id
        WHERE o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()
        GROUP BY month_name, employee
        with rollup';
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $assetsDir = dirname(__FILE__) . '/assets';
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish($assetsDir . '/employeesorders.js'));
        $result = array_reverse($result);

        foreach ($result as $res) {
            if (empty($res['month_name'])) continue;


            Yii::app()->clientScript->registerScript('show' . $res['month_name'], "
				$(' .for" . $res['month_name'] . "').hide();
				$('#" . $res['month_name'] . "').click(function(){
					$('.for" . $res['month_name'] . "').each(function () {
                        $(this) . slideToggle(300);
                    });
				});
			    ", CClientScript::POS_READY);
            echo '<div id="' . $res['month_name'] . '" style="padding:5px 20px 5px 20px; cursor:pointer;"><i>' .
                $this->monthRu[$res['month_name']] . ': выполнено заказов ' . $res['count_orders'] . '</i></div>';

            echo '<div class="for' . $res['month_name'] . '" style="padding:0 40px;"><i>' . $res['employee'] .
                ': выполнил(а) заказов ' . $res['count_orders'] . '</i></div>';

        }
    }

    public function run()
    {
        $this->render('employees_orders', [
//            'text' => $this->text,
        ]);
    }

}
