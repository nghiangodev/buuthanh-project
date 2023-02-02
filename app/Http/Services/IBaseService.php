<?php

namespace App\Http\Services;

interface IBaseService
{
	public function store(array $datas);

	public function update(array $datas, $model);

	public function delete($model);
}
