<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

// define variables and set to empty values
$name = $email = $surname = $password = $cpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validates User name
    if (empty($_POST["name"])) {
        throw new Exception("Introduce a user name, please");
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            throw new Exception("Only letters and white space allowed");
        }
    }
    //Validates User surname
    if (empty($_POST["surname"])) {
        throw new Exception("Introduce a user surname, please");
    } else {
        $surname = test_input($_POST["surname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
            throw new Exception("Only letters and white space allowed");
        }
    }
    //Validates email
    if (empty($_POST["email"])) {
        throw new Exception("Email is required");
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        // TO-DO: check if e-mail already exists

    }
    //Validates password & confirm passwords.
    if (!empty($_POST["password"]) && ($_POST["password"] == $_POST["cpassword"])) {
        $password = test_input($_POST["password"]);
        //$cpassword = test_input($_POST["cpassword"]);
        if (strlen($_POST["password"]) <= '8') {
            throw new Exception("Your password must contain at least 8 characters");
        } elseif (!preg_match("#[0-9]+#", $password)) {
            throw new Exception("Your password must contain at least 1 number");
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            throw new Exception("Your password must contain at least 1 capital letter");
        } elseif (!preg_match("#[a-z]+#", $password)) {
            throw new Exception("Your password must contain at least 1 lowercase letter");
        }        
    } elseif (!empty($_POST["password"])) {
        throw new Exception("Please check you've entered or confirmed your password");
    } else {
        throw new Exception("Please enter password");
    }
    // TO-DO: Create DB entry.

}
/*Each $_POST variable with be checked by the function*/
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
