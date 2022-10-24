<?php

namespace App\Service\Import;

class StringParser
{
    private string $userName;
    private int $userKey;

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserKey(): int
    {
        return $this->userKey;
    }

    public function parse(string $string): StringParser
    {
        $userName = $this->extractUserName($string);
        $this->userName = $userName;
        $this->userKey = $this->extractUserKey($string);
        return $this;
    }

    private function extractUserName(string $string): string
    {
        return explode('_', $string)[0];
    }

    private function extractUserKey(string $string): int
    {
        return (int)str_replace([$this->userName, '_'], '', $string);
    }
}
