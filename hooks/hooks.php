<?php

$content    =   file_get_contents("php://input");
$respuesta  =   json_encode($content);

$res = "{\"type\":\"verification\",\"event_date\":\"2018-05-30T09:51:59-05:00\",\"verification_code\":\"xxxxxxx\",\"id\":\"xxxxxxxxxxxxxxxxxx\"}";