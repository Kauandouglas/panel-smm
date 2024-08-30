<?php

if (!function_exists('colorStatusOrder')) {
    function colorStatusOrder(int $status)
    {
        if ($status == 1) {
            return "primary";
        } elseif ($status == 2 || $status == 3) {
            return "warning";
        } elseif ($status == 4) {
            return "success";
        } else {
            return "danger";
        }
    }
}
