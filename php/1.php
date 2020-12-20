<?php
//Реализовать функцию findSimple ($a, $b).
// $a и $b – целые положительные числа.
//Результат ее выполнение: массив простых чисел от $a до $b.
$a = 1;
$b = 8;
$max_number = $b;
function findSimple($max_number) //решето Эратосфена

{
    $primes = [];
    $is_composite = [];
    for ($i = 4; $i <= $max_number; $i += 2) {
        $is_composite[$i] = true;
    }
    $next_prime = 3;
    while ($next_prime <= (int) sqrt($max_number)) {
        for ($i = $next_prime * 2; $i <= $max_number; $i += $next_prime) {
            $is_composite[$i] = true;
        }
        $next_prime += 2;
        while ($next_prime <= $max_number && isset($is_composite[$next_prime])) {
            $next_prime += 2;
        }
    }
    for ($i = 2; $i <= $max_number; $i++) {
        if (!isset($is_composite[$i])) {
            $primes[] = $i;
        }

    }
    return $primes;
}
$primes = findSimple($max_number);
print_r($primes);
echo "<br>";

/*Реализовать функцию createTrapeze($a).
$a – массив положительных чисел, количество элементов кратно 3.
Результат ее выполнение: двумерный массив
(массив состоящий из ассоциативных массива с ключами a, b, c).
ер для входных массива [1, 2, 3, 4, 5, 6]
результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]]*/
$a = [1, 2, 3, 4, 5, 6]; //1 вариант
var_dump(createTrapeze($a));
function createTrapeze($a)
{
    if (count($a) % 3 !== 0) {
        return false;
    }
    $arrays = array_chunk($a, 3);
    $array_keys = ["a", "b", "c"];
    $new_array = [];

    foreach ($arrays as $a) {
        $new_array[] = array_combine($array_keys, $a);
    }

    return $new_array;
}

$a = [1, 2, 3, 4, 5, 6]; //2 вариант
$chunks = array_chunk($a, 3); //делим исходный по 3 шт.
$result = array_map(squareTrapeze, $chunks); //мапим новый массив из старого фунцией squareTrapeze
print_r($result); //выводим результат

function squareTrapeze($chunk) //На входе получаем элемент нового массива

{
    $chunk = array_combine(['a', 'b', 'c'], $chunk); //комбайним буквы и числа
    return $chunk; //возвращаем элемент
};
echo "<br>";

/*Реализовать функцию squareTrapeze($a).
$a – массив результата выполнения функции createTrapeze().
Результат ее выполнение: в исходный массив
для каждой тройки чисел добавляется дополнительный ключ s,
содержащий результат расчета площади трапеции со сторонами a и b, и высотой c.*/

$result2 = array_map(squareTrapeze2, $result);
print_r($result2);

function squareTrapeze2($chunk) //На входе получаем элемент нового массива

{
    $chunk['s'] = ($chunk['a'] + $chunk['b']) * $chunk['c'] / 2; //добавляем элемент площади
    return $chunk; //возвращаем элемент
};
echo "<br>";

/*5. Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения функции squareTrapeze(),
$b – максимальная площадь. Результат ее выполнение:
массив размеров трапеции с максимальной площадью, но меньше или равной $b.*/
$a = $result2;
$b = 27;

function getSizeForLimit($a, $b)
{
    if (max($a[0]) == $b):
        print_r($a[0]);

    elseif (max($a[1]) == $b):
        print_r($a[1]);

    elseif (max($a[0]) > max($a[1])):
        print_r($a[0]);

    else:print_r($a[1]);

    endif;

}
getSizeForLimit($a, $b);
echo "<br>";

/*6. Реализовать функцию getMin($a).
$a – массив чисел. Результат ее выполнения:
минимальное числа в массиве (не используя функцию min,
ключи массив может быть ассоциативный)*/

$a = [1, 4, 8, 0, 2.587];
function getMin($a)
{
    $min = null;
    $min_key = null;
    $max = null;
    $max_key = null;

    foreach ($a as $k => $v) {

        if ($v < $min or $min === null) {
            $min = $v;
            $min_key = $k;
        }
    }
    echo "Min value: $min <br> Min key: $min_key <br>";

}
getMin($a);

$a = $result2;
function printTrapeze($a)
{
    echo "<table>";
    foreach ($a as $result) {
        echo "<tr>";
        foreach ($result as $rValue) {
            if ($rValue % 2 == 0) {
                $background = 'yellow';
            } else {
                $background = 'white';
            }

            echo "<td>{$rValue}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
printTrapeze($a);

abstract class BaseMath
{
    protected function exp1($a, $b, $c)
    {
        return $a * ($b ^ $c);
    }

    protected function exp2($a, $b, $c)
    {
        return ($a / $b) ^ $c;
    }

    abstract public function getValue();

}

final class F1 extends BaseMath
{
    protected $a;
    protected $b;
    protected $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function getValue()
    {
        return $this->exp1($this->a, $this->b, $this->c) + ($this->exp2($this->a, $this->b,
            $this->c) % 3) ^ min($this->a,
            $this->b, $this->c);

    }

}

$f1 = new F1(111, 21, 31);
echo $f1->getValue();
