<?php


/**
 * @param null $title
 * @param null $message
 * @return \Illuminate\Foundation\Application|mixed
 * For the flash messages.
 */
function flash($title = null, $message = null) {
   
   
    $flash = app('App\Http\Flash');

   
   
    if (func_num_args() == 0) {
        return $flash;
    }

   
    return $flash->info($title, $message);
}

/**
 * @param $date
 * @return bool|string
 * Format the time to this
 */
function prettyDate($date) {
    return date("M d, Y", strtotime($date));
}