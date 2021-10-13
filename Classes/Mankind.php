<?php


class Mankind implements Iterator, MankindInterface
{

    use SingletonTrait;

    private int $position = 0;

    private mixed $filePath;

    private array $persons = [];

    /**
     * Load file with persons
     *
     * @param $filename
     * @throws Exception
     */
    public function load($filename): void
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $filename;

        if (!file_exists($filePath))
            throw new Exception('File not found!');
        else {
            // set file path
            $this->filePath = $filePath;

            $this->setPersons();

        }
    }

    /**
     * Set person array from file
     *
     * @throws ReflectionException
     */
    private function setPersons(): void
    {

        $this->persons = [];

        foreach ($this->getFileData() as $line) {

            $dataArray = explode(';', rtrim($line, "\n"));

            $reflector = new ReflectionClass('Person');

            // new person item by args array
            $personItem = $reflector->newInstanceArgs($dataArray);

            // set first array item position
            if ($this->position === 0)
                $this->position = $personItem->getId();

            $this->persons[$personItem->getId()] = $personItem;
        }

    }

    /**
     * Get the Person based on ID
     *
     * @param $personId
     * @return Person|null
     */
    public function getPersonById($personId): Person|null
    {
        return $this->persons[$personId] ?? null;
    }

    /**
     * @return Generator
     */
    private function getFileData()
    {

        $file = fopen($this->filePath, 'r');

        if (!$file)
            throw new Exception('file does not exist or cannot be opened');

        while (!feof($file))
            yield trim(fgets($file));

        fclose($file);

    }

    /**
     * Get next key by prev key
     *
     * @param $key
     * @return int
     */
    private function getNextKeyArray($prevKey): int
    {
        $nextKey = 0;
        $keys = array_keys($this->persons);
        $position = array_search($prevKey, $keys);

        if (isset($keys[$position + 1]))
            $nextKey = $keys[$position + 1];

        return $nextKey;
    }


    /**
     * Get man count
     *
     * @return int
     */
    private function getManCount(): int
    {
        $count = 0;

        if (count($this->persons))
            foreach ($this->persons as $personItem)
                if ($personItem->getSex() === Person::$sexAllowArray[0])
                    $count++;

        return $count;
    }


    /**
     * Get the percentage of Men in Mankind
     *
     * @return float
     */
    public function getManPercent(): float
    {
        $manCount = $this->getManCount();

        return $manCount > 0 ? round($manCount * 100 / count($this->persons), 2) : 0;
    }


    /**
     * Get current array item
     *
     * @return Person
     */
    public function current(): Person
    {
        return $this->persons[$this->position];
    }

    /**
     * Get current key
     *
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Set next array position
     */
    public function next(): void
    {
        $this->position = $this->getNextKeyArray($this->position);
    }

    /**
     * Set first position of array
     */
    public function rewind(): void
    {
        $this->position = count($this->persons) ? array_key_first($this->persons) : 0;
    }

    /**
     * IS valid position?
     *
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->persons[$this->position]);
    }

}