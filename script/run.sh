#!/bin/bash
php ./itemfingoods_jes_mysql.php > result.txt
php ./item_jes_mysql.php >> result.txt
php itemwhbal_jes_mysql.php >> result.txt
php producttype_jes_mysql.php >> result.txt
php warehouse_jes_mysql.php >> result.txt
php warehousetype_jes_mysql.php >> result.txt
