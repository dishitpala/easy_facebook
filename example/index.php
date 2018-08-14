<?php
require_once 'configuration.php';

echo ($facebook -> query_data('id,first_name,last_name,email,albums{id,name,count,picture{url},photos{id,name,images}}'));
?>