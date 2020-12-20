<?php
$hash_variable_salt = password_hash($_GET['pw'], 
        PASSWORD_DEFAULT, array('cost' => 12));

echo "HASH: ".$hash_variable_salt."<br>";
echo "Verify (should return 1): ". password_verify($argv[1],
    $hash_variable_salt ) . "<br>";
    