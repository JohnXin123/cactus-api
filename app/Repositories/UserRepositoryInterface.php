<?php

namespace App\Repositories;


interface UserRepositoryInterface {

	function getAllUsers();

	function getUserById(int $id);

	function storeUser(object $request);

	function updateUser(int $id, object $request);

	function deleteUser(int $id);
}