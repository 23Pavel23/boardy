<?php

sleep(2); // Имитация долгого запроса к БД

echo json_encode([

'result' => 'done',

'pid' => getmypid(),

'time' => date('H:i:s')

]);

# Один запрос — 2 секунды

time curl https://фамилия.ai-info.ru/demo-slow.php


# 10 параллельных — зависит от числа воркеров!

time for i in $(seq 10); do

curl -s https://фамилия.ai-info.ru/demo-slow.php &

done

wait
