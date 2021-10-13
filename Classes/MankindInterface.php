<?php

interface MankindInterface
{
    public function load($filename) : void;
    public function getPersonById($personId): Person|null;
    public function getManPercent(): float;
}