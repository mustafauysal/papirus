<?php

/**
 * @package Papirus
 * Sanitize data 
 * 
 */
class Papirus_Filter {

    
    public function esc_xss()
    {
        // TODO remove js
        // TODO remove special tags
    }
    
    public function esc_html($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);  
    }
    
    public function esc_email($email)
    {
        return filter_var($email,FILTER_SANITIZE_EMAIL);
    }
    
    public function esc_filename()
    {
        // TODO filename sanitasyon
    }
    
    
    
    
}