<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notenoptionen
 *
 * @author henning
 */
class Notenoptionen {
    
    public function __construct() 
    {
    }
    
    public function gibOptionenUST()
    {
        return    "<option value=\"1\">"
                . "<option value=\"2\">"
                . "<option value=\"3\">"
                . "<option value=\"4\">"
                . "<option value=\"5\">"
                . "<option value=\"6\">";
    }
    
    public function gibOptionenOST()
    {
        return    "<option value=\"1+\">"
                . "<option value=\"1\">"
                . "<option value=\"1-\">"
                . "<option value=\"2+\">"
                . "<option value=\"2\">"
                . "<option value=\"2-\">"
                . "<option value=\"3+\">"
                . "<option value=\"3\">"
                . "<option value=\"3-\">"
                . "<option value=\"4+\">"
                . "<option value=\"4\">"
                . "<option value=\"4-\">"
                . "<option value=\"5+\">"
                . "<option value=\"5\">"
                . "<option value=\"5-\">"
                . "<option value=\"6\">";
    }
            
    public function gibOptionenSO()
    {
        return    "<option value=\"NB\">"
                . "<option value=\"AT\">"
                . "<option value=\"E1\">"
                . "<option value=\"E2\">"
                . "<option value=\"E3\">";
    }
}
