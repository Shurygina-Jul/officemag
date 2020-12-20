<?php

/*функцию convertString($a, $b).
Результат ее выполнение: если в строке $a содержится 2 и более подстроки $b,
то во втором месте заменить подстроку $b на инвертированную подстроку*/
$a = "Hello world, how you doing world...world ?";
$b = "world";
$offset = 0;

function convertString($a, $b)
{
  function  first ($offset)
  {
    $offset = 0; /*находит номер второго вхождения */
    $findLength = strlen($find);
    $occurrence = 0;
    while (($offset = strpos($a, $b, $offset)) !== false) {
        if ($occurrence++) {
            break;
        }
        $offset += $findLength;
    };
    return $offset;};
    $new_offset = first ($offset);}

//отрезать от строки длинну $offset, отрезать от строки длинну этой строки + подстроки, склеить 1 инверт и 2

    $if ($new_offset!=0){
     //оставили начальную часть
      $o = a.substr(0, $new_offset)
      $od = mb_strlen ($b);
      $v =( $new_offset + $od + 1);
      // оставили конечную  часть
      $dva_otrezat = $source.slice($dva);
      //конкатенация
     return $otvet = $o + strrev($b)+ $v; 
         
    } 
    else {return $otvet = "Ничего не вышло , друг!";} 
      
}
convertString($a, $b);

/*функию mySortForKey($a, $b). $a – двумерный массив вида [['a'=>2,'b'=>1],['a'=>1,'b'=>3]],
$b – ключ вложенного массива. Результат ее выполнения: двумерном массива $a
отсортированный по возрастанию значений для ключа $b.
В случае отсутствия ключа $b в одном из вложенных массивов,
выбросить ошибку класса Exception с индексом неправильного массива.*/
$a = [['a' => 2, 'b' => 1], ['a' => 1, 'b' => 3]];
function mySortForKey($a, $b)
{
    usort($a, "mySort");
    function mySort($v1, $v2)
    {
        if ($v1["b"] == $v2["b"]) {
            return 0;
        }

        return ($v1["b"] < $v2["b"]) ? -1 : 1;
    }
} 
if (!file_exists($b)) {
    throw new Exception("Ошибка");
}


/*Реализовать функцию importXml($a). $a – путь к xml файлу
(структура файла приведена ниже). Результат ее выполнения:
прочитать файл $a и импортировать его в созданную БД.*/
$a = "../2.sql";

// Подключение к БД.
$dbh = new PDO('mysql:dbname=2;host=localhost', 'root', 'root');

$data = simplexml_load_file($a);
foreach ($data->item as $row) {
    $code = strval($row->Код['Код']);

    $price1 = intval($row->Цена['Базовая']);
    $price2 = intval($row->Цена['Москва']);
    $properties = floatval($row->ЕдИзм['%']);

    // Поиск товара в БД по артикулу.
    $sth = $dbh->prepare("SELECT * FROM `a_products` WHERE `код` = 201");
    $sth->execute(array($code));
    $prod = $sth->fetch(PDO::FETCH_ASSOC);

    // Обновление товара.
    if (!empty($prod)) {
        $sth = $dbh->prepare("UPDATE `a_product` SET `price1` = ?, `price2` = ? `properties` = ? WHERE `code` = 201");
        $sth->execute(array($price1, $price2, $prod['code']));
    }
}

/*Реализовать функцию exportXml($a, $b). $a – путь к xml файлу вида
(структура файла приведена ниже), $b – код рубрики. Результат ее выполнения:
выбрать из БД товары (и их характеристики, необходимые для формирования файла)
выходящие в рубрику $b или в любую из всех вложенных в нее рубрик, сохранить результат в файл $a.*/
function exportXml($a, $b)
{
    $a ="../table.xml";
    $b = 201;

    $mysqli = new mysqli('localhost','user','password','database');
$mysqli->set_charset("utf8");

if (mysqli_connect_errno()) {printf("Код ошибки: %s\n", mysqli_connect_error()); exit;}

$dom = new DOMDocument('1.0');
$dom->formatOutput = true;
$dom -> encoding = "windows-1251";
$root = $dom->createElement('list');
$root = $dom->appendChild($root);

$offers = $dom->createElement('Товар');
$offers = $root->appendChild($offers);

/* Посылаем запрос серверу */

if ($result = $mysqli->query("SELECT * FROM `a_products` WHERE `код` = 201"))
{while( $row = $result->fetch_assoc() ){
//Выбираем результаты запроса: /
$url_offer=$row['url'];

$offer = $dom->createElement('Товар');
$url = $dom->createElement('url');
$text = $dom->createTextNode($url_offer);
$url->appendChild($text);
$offer->appendChild($url);
} # end while $result->close();

// Освобождаем память /

} #end out sql query 
$mysqli->close();

//Закрываем соединение /

$fp = fopen( "table.xml", "w" ); fputs( $fp, $dom->saveXML() ); fclose( $fp );
}
