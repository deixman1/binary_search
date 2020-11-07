<?php
class FileSearch
{
    /**
     *Установка стартового времени
     */
    public function __construct()
    {
        $this->time = microtime(true);
    }

	private $time;

    /**
     * Возвращает время выполнения скрипта
     * @return float
     */
    public function getResultTime(): float
    {
        return round(microtime(true) - $this->time, 4);
    }
    /**
     *Создание файла с ключами и значениями
     * @param string $fileName
     * @param int $count
     */
	public function createFileAndValues(string $fileName, int $count)
	{
	    $file = new SplFileObject($fileName, "w");
	    $str = "";
	    for ($i = 0; $i < $count; $i++)
	    {
	        $str .= "ключ".$i."\t"."значение".$i."\x0A";
	    }
        $file->fwrite($str);
        $file = null;
	}

    /**
     *Поиск в файле ключа
     * @param string $fileName
     * @param string $search
     * @return string
     */
	public function intoFileSearch(string $fileName, string $search): string
	{
        $file = new SplFileObject($fileName,"r");
        $start = 0;
        $end = sizeof(file($fileName)) - 1;
        while ($start <= $end)
        {
            $middle = floor(($start + $end) / 2);
            $file->seek($middle);
            $elem = explode("\t", $file->current());
            $strnatcmp_result = strnatcmp($elem[0],$search);
            if ($strnatcmp_result > 0)
            {
                $end = $middle-1;
            }
            elseif ($strnatcmp_result < 0)
            {
                $start = $middle+1;
            }
            else
            {
                return $elem[1];
            }
        }
        $file = null;
        return 'undef';
	}
}
$key = "ключ22131"; //искомый ключ
$file = new FileSearch();
//$file->createFileAndValues("values.db", 999999); //Создание файла
$result = $file->intoFileSearch("values.db", $key);//поиск ключа в файле
$time = $file->getResultTime(); //время выполнения скрипта
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
    Искомый ключ:
    <?php echo $result; ?>
    <br>
    Результат:
    <?php echo $result; ?>
    <br>
    Время выполнения:
	<?php echo $time; ?>
</body>
</html>
