<?php
function formatarDataHora($data, $hora) {
    $timestamp = strtotime("$data $hora");
    return date('d/m/Y H:i', $timestamp);
}