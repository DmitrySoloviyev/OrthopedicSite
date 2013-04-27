<?
/***
 * Copyright (C) 2012 Dmitry Soloviyev
 *
 * This file is part of Orthopedic website.
 *
 * Orthopedic website is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Orthopedic website is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Orthopedic website.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * Этот файл — часть Orthopedic website.
 *
 * Это свободная программа: вы можете перераспространять ее и/или изменять
 * ее на условиях Стандартной общественной лицензии GNU в том виде, в каком
 * она была опубликована Фондом свободного программного обеспечения; либо
 * версии 3 лицензии, либо (по вашему выбору) любой более поздней версии.
 *
 * Эта программа распространяется в надежде, что она будет полезной,
 * но БЕЗО ВСЯКИХ ГАРАНТИЙ; даже без неявной гарантии ТОВАРНОГО ВИДА
 * или ПРИГОДНОСТИ ДЛЯ ОПРЕДЕЛЕННЫХ ЦЕЛЕЙ. Подробнее см. в Стандартной
 * общественной лицензии GNU.
 *
 * Вы должны были получить копию Стандартной общественной лицензии GNU
 * вместе с этой программой. Если это не так, см. <http://www.gnu.org/licenses/>.
 **/
 ?>
<p>
<hr><br/>
Сделать резервную копию Базы Данных и сохранить к себе на компьютер:
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <input type="submit" class="button" value="Сделать резервную копию" />
    <input type="hidden" name="form" value="backupdb" />
</form><br />
</p>
<p>
Восстановить Базу Данных из сохраненной ранее резервной копии:
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
    <input type="file" class="button" name="new_db" /><br />
    <input type="submit" class="button" value="Восстановить" name="new_db" />
    <input type="hidden" name="form" value="recoverydb" />
</form>
</p><br />
Оптимизировать базу данных:
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <input type="submit" class="button" value="Оптимизация" />
    <input type="hidden" name="form" value="optimizedb" />
</form>
<br /><hr />
<div id="hint">
  <i><a href="index.php?id=about#3">Подробности...</a></i>
</div><p>