<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library of functions and constants for module customlabels
 *
 * @package mod_customlabels
 * @copyright  2019 Jimmy WIMS  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * return thr firstname of the user
 *
 * @return string
 */
function getUser_firstname()
{
    global $USER, $DB;
    $sql = "SELECT firstname from mdl_user where id=?";
    $student = $DB->get_record_sql($sql,array($USER->id));
    if(!empty($student))
        return $student->firstname;
}


/**
 * return thr lastname of the user
 *
 * @return string
 */
function getUser_lastname()
{
    global $DB,$USER;
    $sql = "SELECT lastname from mdl_user where id=?";
    $student = $DB->get_record_sql($sql,array($USER->id));
    if(!empty($student))
        return $student->lastname;
}

/**
 * Gives the url with the firstname and lastname of the user
 *
 * @param object $customlabels
 * @param string $change
 * @param string $name
 * @param string $url
 * @return string
 */
function setInfo($customlabels, $change, $name, $url)
{
    unset($posFirst);
    $newUrl=$url;
    if($posFirst=strpos($newUrl,$change))
    {
        while($newUrl[$posFirst]!='=')
        {
            $posFirst=$posFirst+1;
        }
        $posFirst=$posFirst+1;
        $cpt=0;
        $lengthUrl=strlen($newUrl);

        unset($endUrl);

        while($cpt<strlen($name)) 
        {
            if($posFirst<$lengthUrl)
            {
                if($newUrl[$posFirst]=='&'&&!(isset($endUrl)))
                    $endUrl = substr($newUrl, $posFirst);
            }
            if($cpt<strlen($name))
                $newUrl[$posFirst] = $name[$cpt];
            $posFirst = $posFirst+1;
            $cpt=$cpt+1;
        }

        if(!isset($endUrl) && $posFirst<strlen($newUrl)-1)
        {
            $posEt = $posFirst;
            while($posEt<strlen($newUrl) && $newUrl[$posEt]!='&')
                $posEt = $posEt+1;
            $endUrl = substr($newUrl, $posEt);
        }
        else
            $endUrl="";

        $newUrl=substr($newUrl, 0,$posFirst);

        $newUrl=$newUrl.$endUrl;
        return $newUrl;
    }
    if(preg_match('`\?`',$newUrl))
        $newUrl = $newUrl . "&" . $change . "=" . $name;
    else
         $newUrl = $newUrl . "?" . $change . "=" .  $name;
    return $newUrl;
}

?>