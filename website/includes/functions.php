<?php
/**
 * File: Template and class utility functions.
 * @author: Seth Hobson
 * @version: 02/13/2013
 */
 
/**
 * Function: Redirects to a given URL.
 * @param null $location the URL to be redirected to
 */
function redirect_to($location = NULL)
{
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

/**
 * Function: Outputs error messages as paragraphs within template file.
 * @param string $message
 * @return string the error message wrapped in a paragraph with styling.
 */
function output_message($message = "")
{
    if (!empty($message))
        return "<p style=\"color:red;\" class=\"message\">{$message}</p>";
    return $message;
}

/**
 * Function: Formats a given phone number to standard US form, i.e. (555) 555-5555
 * @param $phone
 * @return mixed the formatted phone number
 */
function format_phone($phone)
{
    $phone = preg_replace("/[^0-9]/", "", $phone);

    if (strlen($phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
    else if (strlen($phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    else
        return $phone;
}

/**
 * Function: Validates an email address for correctness.
 * @param $email_value
 * @return bool whether the email is valid
 */
function validate_email($email_value)
{
    return filter_var($email_value, FILTER_VALIDATE_EMAIL);
}
