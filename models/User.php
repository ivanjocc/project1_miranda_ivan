<?php

class User
{
    private $id;
    private $userName;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $billingAddressId;
    private $shippingAddressId;
    private $token;
    private $roleId;

    // // Constructor
    // public function __construct($id, $userName, $email, $password, $firstName, $lastName, $billingAddressId, $shippingAddressId, $token, $roleId)
    // {
    //     $this->id = $id;
    //     $this->userName = $userName;
    //     $this->email = $email;
    //     $this->password = $password;
    //     $this->firstName = $firstName;
    //     $this->lastName = $lastName;
    //     $this->billingAddressId = $billingAddressId;
    //     $this->shippingAddressId = $shippingAddressId;
    //     $this->token = $token;
    //     $this->roleId = $roleId;
    // }

    // Constructor
    public function __construct($userName, $email, $password, $firstName, $lastName)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    // Ejemplo de método para verificar si el nombre de usuario está en uso
    public function isUserNameTaken($userName) {
        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        $query = "SELECT id FROM user WHERE user_name = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $userName);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $count = mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $count > 0;
    }

    // Ejemplo de método para verificar si el correo electrónico está en uso
    public function isEmailTaken($email) {
        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos
    
        $query = "SELECT id FROM user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
    
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    
        $count = mysqli_stmt_num_rows($stmt);
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    
        return $count > 0;
    }

    // Ejemplo de método para verificar si el correo electrónico está en uso
    public function createUser($userName, $email, $password, $firstName, $lastName) {
        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos
    
        $query = "INSERT INTO user (user_name, email, pwd, fname, lname) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $userName, $email, $password, $firstName, $lastName);
    
        mysqli_stmt_execute($stmt);
    
        // Obtener el ID del usuario recién creado
        $userId = mysqli_insert_id($conn);
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    
        return $userId;
    }
    

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getBillingAddressId()
    {
        return $this->billingAddressId;
    }

    public function setBillingAddressId($billingAddressId)
    {
        $this->billingAddressId = $billingAddressId;
    }

    public function getShippingAddressId()
    {
        return $this->shippingAddressId;
    }

    public function setShippingAddressId($shippingAddressId)
    {
        $this->shippingAddressId = $shippingAddressId;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }
}

?>
