<?php

if (!function_exists('timeLeft')) {
    /**
     * @throws Exception
     */
    function timeLeft(string $date_start, string $date_final)
    {
        $time_left_start = new DateTime($date_start);
        $time_left_final = new DateTime($date_final);
        $diff = $time_left_start->diff($time_left_final);
        return $diff->format('%H horas, %i minutos e %s segundos');
    }
}
