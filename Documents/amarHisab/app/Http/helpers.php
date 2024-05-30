<?php

use Carbon\Carbon;

function dateFormat($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}
