<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 1.12.2016
 * Time: 10:38
 */

$url = "http://www.betexplorer.com/soccer/england/premier-league/fixtures/";

$html = file_get_contents($url);

$tmpData = 'tmp.txt';

file_put_contents($tmpData, $html);
