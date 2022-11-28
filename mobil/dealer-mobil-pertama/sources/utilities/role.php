<?php
$roleLevel = array(
    "siswa" => 1,
    "operator" => 2,
    "admin" => 3
);

function convertRole($role)
{
    global $roleLevel;

    $level = $roleLevel[$role];

    return $level;
};

function checkRole($role, $minimumLevel)
{
    $level = convertRole($role);

    if ($level >= $minimumLevel) {
        return true;
    } else if ($level < $minimumLevel) {
        return false;
    }
}

function guardRole($role, $minimumLevel, $path)
{
    if (!checkRole($role, $minimumLevel)) {
        echo "<script>window.location.href = '$path';</script>";
    };
}
