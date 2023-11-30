<?php

class PasswordChange
{
	private $userID;
	private $currentPassword;
	private $newPassword;

	// Constructor
	public function __construct($userID, $currentPassword, $newPassword)
	{
		$this->userID = $userID;
		$this->currentPassword = $currentPassword;
		$this->newPassword = $newPassword;
	}

	// Getters y setters

	public function getUserID()
	{
		return $this->userID;
	}

	public function setCurrentPassword($currentPassword)
	{
		$this->currentPassword = $currentPassword;
	}

	public function getCurrentPassword()
	{
		return $this->currentPassword;
	}

	public function setNewPassword($newPassword)
	{
		$this->newPassword = $newPassword;
	}

	public function getNewPassword()
	{
		return $this->newPassword;
	}

	public function verifyPassword()
	{
		// Lógica para verificar si la contraseña actual es válida
		$conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

		// Ejemplo de consulta para verificar la contraseña actual
		$query = "SELECT * FROM user WHERE id = ? AND pwd = ?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "is", $this->userID, $this->currentPassword);

		// Ejecutar la consulta
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);

		// Verificar si se encontró un usuario con las credenciales proporcionadas
		$isValidPassword = mysqli_stmt_num_rows($stmt) == 1;

		// Cerrar la declaración y la conexión
		mysqli_stmt_close($stmt);
		mysqli_close($conn);

		return $isValidPassword;
	}


	public function updatePassword()
	{
		$conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

		// Ejemplo de consulta para actualizar la contraseña del usuario
		$query = "UPDATE user SET pwd = ? WHERE id = ?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "si", $this->newPassword, $this->userID);

		// Ejecutar la consulta
		$success = mysqli_stmt_execute($stmt);

		// Cerrar la declaración y la conexión
		mysqli_stmt_close($stmt);
		mysqli_close($conn);

		$result = array();

		// Verificar el resultado de la actualización y proporcionar un mensaje
		if ($success) {
			$result['success'] = true;
		} else {
			$result['success'] = false;
			$result['error'] = "Error al actualizar la contraseña";
		}

		return $result;
	}
}
