<?php
function redirect(string $url)
{
    header("Location: $url");
}
function redirectMsg(string $url, string $message, bool $error)
{
    if ($error) {
        header("Location: $url?error=$message");
        exit();
    } else {
        header("Location: $url?success=$message");
        exit();
    }
}
