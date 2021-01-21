<?php
namespace Test3;

use Exception;

class newBase
{
    private static $count = 0;
    private static $arSetName = [];
    /*@param string $name
     */
    public function __construct(int $name = 0)
    {
        if (empty($name)) {
            while (array_search(self::$count, self::$arSetName) != false) {
                ++self::$count;
            }
            $name = self::$count;
        }
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }
    protected $name;
    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name . '*';
    }
    protected $value;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    /**
     * @return string
     */
    public function getSize(): string//Missing function's return type declaration

    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }
    public function __sleep(): array//Missing function's return type declaration

    {
        return ['value'];
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        $value = [];
        $value = str_split(serialize($value)); // преобразовали строку в массив
        return $this->name . ':' . sizeof($value) . ':' . $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public static function load(string $value): newBase// return type

    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
                 + strlen($arValue[1]) + 1), $arValue[1]));
    }
}
class newView extends newBase
{
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
    }
    public function setProperty($value): newView//Missing function's return type declaration

    {
        $this->property = $value;
        return $this;
    }
    private function setType()
    {
        $this->type = gettype($this->value);
    }
    private function setSize()
    {
        if (is_subclass_of($this->value, "Test3\newView")) {
            $n = strlen($this->property); //привели к строке
            $m = (string) $n;
            $this->size = (parent::getSize() . "1") . $m;
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = strlen($this->value);
        }
    }
    /**
     * @return string[]
     */
    public function __sleep(): array
    {
        return ['property']; //возвращаемое значение массив
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getName(): string
    {
        if (empty($this->name)) { //name protected
            throw new Exception("The object does\'t have name"); //не найден класс, нужно импортировать
        }
        return '"' . $this->name . '": ';
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type . ';';
    }
    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }
    public function getInfo()
    {
        try {
            echo $this->getName()
            . $this->getType()
            . $this->getSize()
                . "\r\n";
        } catch (Exception $exc) {
            echo 'Error: ' . $exc->getMessage();
        }
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        if ($this->type == 'test') {
            $this->value = $this->value->getSave();
        }
        return parent::getSave() . serialize($this->property);
    }

    /**
     * @param string $value
     * @return newView
     */
    public static function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
                 + strlen($arValue[1]) + 1), $arValue[1]))
            ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1// setProperty Не найден, нужно его импортировать
                 + strlen($arValue[1]) + 1 + $arValue[1])))
        ;
    }
}
function gettype($value): string
{
    if (is_object($value)) {
        $type = get_class($value);
        do {
            if (strpos($type, "Test3\newBase") !== false) {
                return 'test';
            }
        } while ($type = get_parent_class($type));
    }
    return gettype($value);
}

$obj = new newBase('12345');
$obj->setValue('text');

$obj2 = new newView('O9876');
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();

$save = $obj2->getSave();

$obj3 = newView::load($save);

var_dump($obj2->getSave() == $obj3->getSave());
