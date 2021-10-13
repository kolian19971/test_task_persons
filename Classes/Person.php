<?php

class Person implements PersonInterface
{
    public static array $sexAllowArray = [
        'M', 'F'
    ];

    private string $sex;
    private DateTime $birthDateObject;

    public function __construct(
        private int    $id,
        private string $name,
        private string $surname,
                       $sex,
        private string $birthDate,
    )
    {
        // Validate person sex
        if (!empty($sex) && in_array($sex, self::$sexAllowArray))
            $this->sex = $sex;
        else throw new Exception('Invalid person sex');

        // Validate person birth date
        $dt = DateTime::createFromFormat("d.m.Y", $birthDate);

        if ($dt !== false && !array_sum($dt::getLastErrors()))
            $this->birthDateObject = $dt;
        else
            throw new Exception('Invalid birth date format! It must look like: dd.mm.yyyy');

    }

    /**
     * Get person id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get person Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get person Surname
     *
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * Get person birth date
     *
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * Get person sex
     *
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * Get person age in days
     *
     * @return int
     */
    public function getAgeInDays(): int
    {
        $now = new DateTime('NOW');
        $interval = $this->birthDateObject->diff($now);

        return $interval->days;
    }

}