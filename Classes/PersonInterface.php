<?php

interface PersonInterface
{
    public function getId(): int;
    public function getSex(): string;
    public function getAgeInDays() : int;
}