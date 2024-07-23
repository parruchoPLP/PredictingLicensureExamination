<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

$password = '0123';
$hashedPassword = Hash::make($password);

echo "Hashed Password: " . $hashedPassword . PHP_EOL;
