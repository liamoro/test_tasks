<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP</title>
</head>

<body>
<style>
	* {
	font-family: 'Arial';
	letter-spacing: 1px;
	line-height: 1.5;
	}
	h3 {
		color: rgba(0,0,0,.4);
	}
	.container {
		display: inline-block;
		margin: 50px auto;
		padding: 20px 30px;
	}
	p {
		text-align: left;
		white-space: normal;
	}
	.lab-1 {
		border-bottom: 1px rgba(0,0,0,.3) solid;
	}
	.encrypt {
		color: green;
	}
</style>
	<div class="container">
		<div>
			<?php
			//Input data
			$message = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";

			// lab-1 tesk-1 перестановочный шифр
			function Transposition($message){
				//удаление симвоов отличных от латиницы 'a-z'
				$message = preg_replace("/[^A-Z]/i","",$message);
				//преобразование строки в массив
				$mess_arr = str_split($message);

				$count = count($mess_arr) - 1;
				$i = 1;
				// перестановка рвноудаленных элементов от начала и конца сообщения для каждой четной пары, т.е. для строки 123456789 шифр = 183654729
				while( $i < ceil($count/2) ){
				$tmp = $mess_arr[$i];
				$mess_arr[$i] = $mess_arr[$count - $i];
				$mess_arr[$count - $i] = $tmp;
				$i+=2;
				}
				// преобразование масства в строку
				$message = implode($mess_arr);
				return $message;
			}

			//lab-1 task-2 подстановочный шифр
			function cryptSubstitution ($message){
				$key = 10;
				//удаление симвоов отличных от латиницы 'a-z'
				$message = preg_replace("/[^A-Z]/i","",$message);
				//преобразование строки в массив
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				$i = 0;
				while ($i < $count) {
					if ((ord('A') <= ord($mess_arr[$i]) and ord($mess_arr[$i]) <= (ord('Z')-$key)) or (ord('a') <= ord($mess_arr[$i]) and ord($mess_arr[$i]) <= (ord('z')-$key))){
							$mess_arr[$i] = chr(ord($mess_arr[$i]) + $key);
					} else if (ord($mess_arr[$i]) > (ord('Z')-$key) and ord($mess_arr[$i]) <= (ord('Z'))) {
						$mess_arr[$i] = chr(ord('A') - 1 + $key - ord('Z') + ord($mess_arr[$i]));
					} else if (ord($mess_arr[$i]) > (ord('z')-$key) and ord($mess_arr[$i])  <= (ord('z'))) {
						$mess_arr[$i] = chr(ord('a') - 1 + $key - ord('z') + ord($mess_arr[$i]));
					}
					$i++;
				}
				// преобразование масства в строку
				$message = implode($mess_arr);
				return $message;
			}
			function decryptSubstitution($message){
				$key = 10;
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				$i = 0;
				while ($i < $count) {
					if ((ord($mess_arr[$i]) <= ord('Z') and ord($mess_arr[$i]) >= (ord('A')+$key)) or (ord($mess_arr[$i]) <= ord('z') and ord($mess_arr[$i]) >= (ord('a')+$key))){
							$mess_arr[$i] = chr(ord($mess_arr[$i]) - $key);
					} else if (ord($mess_arr[$i]) <= (ord('A') - 1 + $key) and ord($mess_arr[$i]) >= (ord('a'))) {
							$mess_arr[$i] = chr(ord('Z') - $key + ord($mess_arr[$i]) - ord('A') + 1);
					} else if (ord($mess_arr[$i]) <= (ord('a') - 1 + $key) and ord($mess_arr[$i]) >= (ord('a'))) {
						$mess_arr[$i] = chr(ord('z') - $key + ord($mess_arr[$i]) - ord('a') + 1);
					}
					$i++;
				}
				$message = implode($mess_arr);
				return $message;
			}
			// lab-1 task3 монотонный подстановочный шифр
			function cryptMonotonous($message){
				//удаление симвоов отличных от латиницы 'a-z'
				$message = preg_replace("/[^A-Z]/i","",$message);
				//преобразование строки в массив
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				for ($i=0; $i < $count; $i++) { 
					// создаем возмжные пары символов для замены исходного
						$set[0] = $mess_arr[$i].$mess_arr[$i];
					if ($mess_arr[$i] == 'Z' or $mess_arr[$i] == 'z'){
						$set[1] = $mess_arr[$i].chr(ord($mess_arr[$i])-25);
						$set[2] = chr(ord($mess_arr[$i])-25).$mess_arr[$i];
					} else {
						$set[1] = $mess_arr[$i].chr(ord($mess_arr[$i])+1);
						$set[2] = chr(ord($mess_arr[$i])+1).$mess_arr[$i];
					}
					//меняем исходный символ на рандомно выбранную пару замены
					$mess_arr[$i] = $set[rand(0,count($set)-1)];
				}
					$message = implode($mess_arr);
					return $message;
			}
			function decryptMonotonous($message){
				$message = preg_replace("/[^A-Z]/i","",$message);
				$mess_arr = str_split($message);
				$count = count($mess_arr)-2;
				$decrypt_arr;
				for ($i=0; $i <= $count; $i+=2) { 
					if ($mess_arr[$i] == $mess_arr[$i+1] or ((ord($mess_arr[$i]) - ord($mess_arr[$i+1])) == -1)) {
						$decrypt_arr[] = $mess_arr[$i];
					} elseif ((ord($mess_arr[$i]) - ord($mess_arr[$i+1])) == 1) {
						$decrypt_arr[] = $mess_arr[$i+1];
					}
				}
				$message = implode($decrypt_arr);
				return $message;
			}
			// lab-1 task 4 полиграммный подстановочный шифр. Шифр Плейфера
			function cryptPolygamous ($message, $key_phrase) {
				$message = preg_replace("/[^A-Z]/i","",$message);
				$mess_arr = str_split(strtoupper($message));
				$key_phrase = str_split(strtoupper($key_phrase));
				// в алфавите опускаем символ 'J', так чтобы всего было 25 символов
				$alphabet = ['A', 'B','C','D','E','F','G','H','I','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
				// дополняем $key_phrase символами алфавита
				$set = array_merge($key_phrase, $alphabet);
				// удаляем все повторения символов в массиве
				$set = array_unique($set);
				// переиндексируем массив, чтобы не было пробелов в индексах после удаления повторений
				$set = array_values($set);
				// формируем матрицу
				$matrix = array_chunk($set, 5);
				// разбиваем входное сообщение на пары, если встречаются пары одинаковых символов, вставляем между ними Х, повторяем разбивку и вставку
				$count = count($mess_arr);
				for ($i=0; $i < $count - 1; $i+=2) { 
					if ($mess_arr[$i] == $mess_arr[$i+1]) {
						array_splice($mess_arr, $i+1 , 0, 'X');
					}
				}
				// если длина сообщения не четная, то к последнему символу добавляем Х, чтобы у него тоже была пара
				if (count($mess_arr)%2!=0) {
					array_push($mess_arr, 'X');
				}
				// шифруем кажду пару по по правилуам шифра Плейфера
				for ($i=0; $i <= $count; $i+=2) {
					$m_count = count($matrix)-1;
					$flag_1 = false;
					$flag_2 = false; 
					for ($j=0; $j <= $m_count; $j++) {
						if ($mess_arr[$i] == 'J'){$mess_arr[$i]='I';}
						if(!$flag_1){
							if (array_search($mess_arr[$i], $matrix[$j]) !== false) {
								$row_1 = $j; 
								$index_1 = array_search($mess_arr[$i], $matrix[$j]);
								$flag_1 = true;
							}
						}
						if(!$flag_2){
							if (array_search($mess_arr[$i+1], $matrix[$j]) !== false) {
								$row_2 = $j; 
								$index_2 = array_search($mess_arr[$i+1], $matrix[$j]);
								$flag_2 = true;
							}
						}
					}
					if ($row_1 == $row_2) {
						if ($index_1 == count($matrix[$row_1])-1) {
							$crypt_mess[$i] = $matrix[$row_1][0];
						} else {
							$crypt_mess[$i] = $matrix[$row_1][$index_1+1];
						}
						if ($index_2 == count($matrix[$row_2])-1) {
							$crypt_mess[$i+1] = $matrix[$row_2][0];
						} else {
							$crypt_mess[$i+1] = $matrix[$row_2][$index_2+1];
						}
					} elseif ($index_1 == $index_2) {
						if ($row_1 == $m_count) {
							$crypt_mess[$i] = $matrix[0][$index_1];
						} else {
							$crypt_mess[$i] = $matrix[$row_1+1][$index_1];
						}
						if ($row_2 == $m_count) {
							$crypt_mess[$i+1] = $matrix[0][$index_1];
						} else {
							$crypt_mess[$i+1] = $matrix[$row_2+1][$index_2];
						}
					} else {
						$crypt_mess[$i] = $matrix[$row_1][$index_2];
						$crypt_mess[$i+1] = $matrix[$row_2][$index_1];
					}
				}
				$crypt_mess = implode($crypt_mess);
				return $crypt_mess;
			}
			function decryptPolygamous ($message, $key_phrase) {
				$mess_arr = str_split(strtoupper($message));
				$key_phrase = str_split(strtoupper($key_phrase));
				// в алфавите опускаем символ 'J', так чтобы всего было 25 символов
				$alphabet = ['A', 'B','C','D','E','F','G','H','I','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
				// дополняем $key_phrase символами алфавита
				$set = array_merge($key_phrase, $alphabet);
				// удаляем все повторения символов в массиве
				$set = array_unique($set);
				// переиндексируем массив, чтобы не было пробелов в индексах после удаления повторений
				$set = array_values($set);
				// формируем матрицу
				$matrix = array_chunk($set, 5);

				// дешифруем кажду пару по по правилуам шифра Плейфера
				$count = count($mess_arr);
				for ($i=0; $i <= $count-2; $i+=2) {
					$m_count = count($matrix)-1;
					$flag_1 = false;
					$flag_2 = false; 
					for ($j=0; $j <= $m_count; $j++) {
						if(!$flag_1){
							if (array_search($mess_arr[$i], $matrix[$j]) !== false) {
								$row_1 = $j; 
								$index_1 = array_search($mess_arr[$i], $matrix[$j]);
								$flag_1 = true;
							}
						}
						if(!$flag_2){
							if (array_search($mess_arr[$i+1], $matrix[$j]) !== false) {
								$row_2 = $j; 
								$index_2 = array_search($mess_arr[$i+1], $matrix[$j]);
								$flag_2 = true;
							}
						}
					}
					if ($row_1 == $row_2) {
						if ($index_1 == 0) {
							$crypt_mess[$i] = $matrix[$row_1][count($matrix[$row_1])-1];
						} else {
							$crypt_mess[$i] = $matrix[$row_1][$index_1-1];
						}
						if ($index_2 == 0) {
							$crypt_mess[$i+1] = $matrix[$row_2][count($matrix[$row_2])-1];
						} else {
							$crypt_mess[$i+1] = $matrix[$row_2][$index_2-1];
						}
					} elseif ($index_1 == $index_2) {
						if ($row_1 == 0) {
							$crypt_mess[$i] = $matrix[$m_count][$index_1];
						} else {
							$crypt_mess[$i] = $matrix[$row_1-1][$index_1];
						}
						if ($row_2 == 0) {
							$crypt_mess[$i+1] = $matrix[$m_count][$index_1];
						} else {
							$crypt_mess[$i+1] = $matrix[$row_2-1][$index_2];
						}
					} else {
						$crypt_mess[$i] = $matrix[$row_1][$index_2];
						$crypt_mess[$i+1] = $matrix[$row_2][$index_1];
					}
				}
				$crypt_mess = implode($crypt_mess);
				return $crypt_mess;
			}

			//lab-1 task-5 Полиалфавитный подстановочный шифр. Шифр Гронсфельда
			function cryptPolyalphabetic ($message, $key){
				//удаление симвоов отличных от латиницы 'a-z'
				$message = preg_replace("/[^A-Z]/i","",$message);
				// удлиняем ключ до длины сообщения
				while (strlen($key) < strlen($message)) {
					$str = (string)$key;
					$key = $key.$str;
				}
				if(strlen($key)>strlen($message)){
					$key = substr($key,0, strlen($message));
				}
				//преобразование строки в массив
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				$i = 0;
				while ($i < $count) {
					if ((ord('A') <= ord($mess_arr[$i]) and ord($mess_arr[$i]) <= (ord('Z')-$key[$i])) or (ord('a') <= ord($mess_arr[$i]) and ord($mess_arr[$i]) <= (ord('z')-$key[$i]))){
							$mess_arr[$i] = chr(ord($mess_arr[$i]) + $key[$i]);
					} else if (ord($mess_arr[$i]) > (ord('Z')-$key[$i]) and ord($mess_arr[$i]) <= (ord('Z'))) {
						$mess_arr[$i] = chr(ord('A') - 1 + $key[$i] - ord('Z') + ord($mess_arr[$i]));
					} else if (ord($mess_arr[$i]) > (ord('z')-$key[$i]) and ord($mess_arr[$i])  <= (ord('z'))) {
						$mess_arr[$i] = chr(ord('a') - 1 + $key[$i] - ord('z') + ord($mess_arr[$i]));
					}
					$i++;
				}
				$message = implode($mess_arr);
				return $message;
			}
			function decryptPolyalphabetic ($message, $key){
				//удаление симвоов отличных от латиницы 'a-z'
				$message = preg_replace("/[^A-Z]/i","",$message);
				// удлиняем ключ до длины сообщения
				while (strlen($key) < strlen($message)) {
					$str = (string)$key;
					$key = $key.$str;
				}
				if(strlen($key)>strlen($message)){
					$key = substr($key,0, strlen($message));
				}
				//преобразование строки в массив
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				$i=0;
				while ($i < $count) {
					if ((ord($mess_arr[$i]) <= ord('Z') and ord($mess_arr[$i]) >= (ord('A')+$key[$i])) or (ord($mess_arr[$i]) <= ord('z') and ord($mess_arr[$i]) >= (ord('a')+$key[$i]))){
							$mess_arr[$i] = chr(ord($mess_arr[$i]) - $key[$i]);
					} else if (ord($mess_arr[$i]) <= (ord('A') - 1 + $key[$i]) and ord($mess_arr[$i]) >= (ord('a'))) {
							$mess_arr[$i] = chr(ord('Z') - $key[$i] + ord($mess_arr[$i]) - ord('A') + 1);
					} else if (ord($mess_arr[$i]) <= (ord('a') - 1 + $key[$i]) and ord($mess_arr[$i]) >= (ord('a'))) {
						$mess_arr[$i] = chr(ord('z') - $key[$i] + ord($mess_arr[$i]) - ord('a') + 1);
					}
					$i++;
				}
				$message = implode($mess_arr);
				return $message;
			}
			// lab-1 task 6
			function helpDecrypt ($message){
				$mess_arr = str_split($message);
				$count = count($mess_arr);
				$key =0;
				while ($key <= 25) {
					$i = 0;
					while ($i < $count) {
						if ((ord($mess_arr[$i]) <= ord('Z') and ord($mess_arr[$i]) >= (ord('A')+$key)) or (ord($mess_arr[$i]) <= ord('z') and ord($mess_arr[$i]) >= (ord('a')+$key))){
								$mess_arr[$i] = chr(ord($mess_arr[$i]) - $key);
						} else if (ord($mess_arr[$i]) <= (ord('A') - 1 + $key) and ord($mess_arr[$i]) >= (ord('a'))) {
								$mess_arr[$i] = chr(ord('Z') - $key + ord($mess_arr[$i]) - ord('A') + 1);
						} else if (ord($mess_arr[$i]) <= (ord('a') - 1 + $key) and ord($mess_arr[$i]) >= (ord('a'))) {
							$mess_arr[$i] = chr(ord('z') - $key + ord($mess_arr[$i]) - ord('a') + 1);
						}
						$i++;
					}
				$key++;
				$message = implode($mess_arr);
				printf ("Сдвиг - ".$key." . сообщение: ".$message."\n\n");
				}
				// $message = implode($mess_arr);
				// return $message;
			}
		?>
		</div>
<!-- вывод -->
		<div class="lab-1">
		 <h3>"Лаб.1 | З.1 | Перестановочный шифр."</h3>
			<p><!-- вывод входного сообщения --><?php
					echo "Input message: ".$message."\n";
				?></p>
			<p><!-- вывов функции для шифровния --><?php
					$encrypted_mes = Transposition($message);
					echo "Encrypted message: ".$encrypted_mes."\n";?></p>
			<p><!-- вызов функции для расшифровки --><?php
					echo "Decrypted message: ".Transposition($encrypted_mes)."\n";?></p>
		</div>
		<div class="lab-1">
		 <h3>"Лаб.1 | З.2 | Подстановочный шифр (моноалфавитный шифр)."</h3>
			<p><?php
					echo "Input message: ".$message."\n";?></p>
			<p><?php
					$encrypted_mes = cryptSubstitution($message);
					echo "Encrypted message: ".$encrypted_mes."\n";?></p>
			<p><?php
					echo "Decrypted message: ".decryptSubstitution($encrypted_mes)."\n";?></p>
		</div>
		<div class="lab-1">
		 <h3>"Лаб.1 | З.3 | Однозвучный подстановочный шифр."</h3>
			<p><?php
					echo "Input message: ".$message."\n";?></p>
			<p><?php
					$encrypted_mes = cryptMonotonous($message);
					echo "Encrypted message: ".$encrypted_mes."\n";?></p>
			<p><?php
					echo "Decrypted message: ".decryptMonotonous($encrypted_mes)."\n";
				?></p>
		</div>
		<div class="lab-1">
		 <h3>"Лаб.1 | З.4 | Полиграммный подстановочный шифр. Шифр Плейфера."</h3>
			<p><?php
					echo "Input message: ".$message."\n";?></p>
			<p><?php
					$encrypted_mes = cryptPolygamous($message, "thePlayfaircipher");
					echo "Encrypted message: ".$encrypted_mes."\n";?>
			</p>
			<p><?php
					echo "Decrypted message: ".decryptPolygamous($encrypted_mes, "thePlayfaircipher")."\n";?></p>
		</div>
		<div class="lab-1">
		 <h3>"Лаб.1 | З.5 | Полиалфавитный подстановочный шифр. Шифр Гронсфельда."</h3>
			<p><?php
					echo "Input message: ".$message."\n";?></p>
			<p><?php
					$encrypted_mes = cryptPolyalphabetic($message, "20153");
					echo "Encrypted message: ".$encrypted_mes."\n";?></p>
			<p><?php
					echo "Decrypted message: ".decryptPolyalphabetic($encrypted_mes, "20153")."\n";?></p>
		</div>
		<div class="lab-1">
		 <h3>"Лаб.1 | З.6 | Расшифровать. Шифр Цезаря."</h3>
			<p><?php
					echo "Input message: ".$message."\n";?></p>
			<p>Pbatenghyngvbaf! Vg'f n Pnrfne pvcure!</p>
			<pre>Decripted message:
<?php echo helpDecrypt("Pbatenghyngvbaf! Vg'f n Pnrfne pvcure!")."\n";?>
<!-- Наиболее читаемое со свдаигом 14 -->
			</pre>
		</div>
	</div>
</body>

</html>