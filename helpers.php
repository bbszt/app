<?php

function build_order_no()
{
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);
 
    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}