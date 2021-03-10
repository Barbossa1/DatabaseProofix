<?php

require 'ActiveRecord.php';

$ar = new ActiveRecord();
$ar->setDbConfig("localhost", "root", "root", "test", "users");

$fields = ["email", "name", "surname"];
$values = ["'email.mail'", "'Имя'", "'Фамилия'"];

//$ar->createDB();
//$ar->createTable($fields);
//$ar->insert($fields, $values);
//$ar->update("email", "'test'", "id", 1);
//$ar->delete("id", 1);