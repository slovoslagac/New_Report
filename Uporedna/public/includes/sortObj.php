<?php

/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 3.10.2016
 * Time: 23:09
 */
class sortObj
{
    var $name = 'teamName';

    function SortObj($name)
    {
        $this->name = $name;
    }

    /* This is the static comparing function: */
    public function cmp_obj($a, $b)
    {

        $al = strtolower($a->threePlusSeria);
        $bl = strtolower($b->threePlusSeria);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? -1 : +1;
    }

}