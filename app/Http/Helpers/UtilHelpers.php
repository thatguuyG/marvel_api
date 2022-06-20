<?php


/**
 * Add 254
 * @param $phone
 * @return string|string[]|null
 */

function international($phone)
{
    $phone = str_replace("+", "", $phone);
    $phone =  preg_replace('/^07/', '2547', $phone);
    $phone =  preg_replace('/^01/', '2541', $phone);
    return $phone;
}

function testfunc() {
    return 'sample';
}