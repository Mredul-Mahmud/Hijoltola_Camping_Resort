<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepoInterface
{
    public function all(): iterable;
    public function find(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
