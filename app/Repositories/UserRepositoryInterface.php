<?php

namespace App\Repositories;


interface UserRepositoryInterface {

	function getAllUsers();

	function storeUser(array $request);

	function updateUser(int $id, array $request);

	function deleteUser(int $id);
}