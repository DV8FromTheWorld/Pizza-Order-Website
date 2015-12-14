<?php

require_once(RET_LIB_PATH.DS.'database.php');

abstract class Person
{
    protected $upload_dir = 'files';
    protected $db_fields = array();
    protected $table_name = '';
    protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK           => "No errors.",
        UPLOAD_ERR_INI_SIZE     => "Your file exceeds the maximum upload size set by the system administrator.",
        UPLOAD_ERR_FORM_SIZE    => "Your file is too large for submission. Only files smaller than 10 MB (megabytes) are valid.",
        UPLOAD_ERR_PARTIAL      => "Only a partial upload was successful. Please check your file and try again.",
        UPLOAD_ERR_NO_FILE      => "No file was selected for upload.",
        UPLOAD_ERR_NO_TMP_DIR   => "The temporary directory cannot be written to.",
        UPLOAD_ERR_CANT_WRITE   => "The file system cannot be written to.",
        UPLOAD_ERR_EXTENSION    => "File extension for the upload is invalid."
    );
    public $errors = array();

    abstract public function attach_file($file, $resume = false);
    abstract public function save();

    protected function attributes()
    {
        // return an array of attribute names and their values
        $attributes = array();
        foreach ($this->db_fields as $field) {
            if (property_exists($this, $field))
                $attributes[$field] = $this->$field;
        }
        return $attributes;
    }

    protected function sanitized_attributes()
    {
        global $database;

        $clean_attributes = array();
        // sanitize the values before submitting
        // I'm not altering the actual value of each attribute
        foreach ($this->attributes() as $key => $value)
            $clean_attributes[$key] = $database->escape_value($value);

        return $clean_attributes;
    }

    protected function create()
    {
        global $database;

        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . $this->table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        if ($database->query($sql))
            return true;
        else
            return false;
    }
}
