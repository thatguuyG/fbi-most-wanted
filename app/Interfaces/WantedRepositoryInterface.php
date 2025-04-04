<?php

namespace App\Interfaces;

interface WantedRepositoryInterface
{
    public function fetchList(array $filters = []);
}
