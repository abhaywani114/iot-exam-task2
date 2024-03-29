<?php

if (!function_exists('message')) {
    function message($text, $status)
    {
        $msg = ["success" => $status, "msg" => $text];
        return view('message', compact('msg'));
    }
}