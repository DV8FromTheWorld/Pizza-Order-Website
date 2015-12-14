<?php

require_once(RET_LIB_PATH.DS.'database.php');

class Supervisor extends Person
{
    private $temp_path;
    protected $table_name = 'supervisor';
    protected $db_fields = array(
        'first_name',
        'last_name',
        'phone',
        'email',
        'filename',
        'applicant_first',
        'applicant_last'
    );
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $filename;
    public $applicant_first;
    public $applicant_last;

    public function attach_file($file, $resume = false)
    {
        // Perform error checking on the form parameters
        if (!$file || empty($file) || !is_array($file)) {
            // error: nothing uploaded or wrong argument usage
            $this->errors[] = "No file was uploaded.";
            return false;
        } else if ($file['error'] != 0) {
            // error: report what PHP says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            // Set object attributes to the form parameters.
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename($file['name']);
            // Don't worry about saving anything to the database yet.
            return true;
        }
    }

    public function save()
    {
        // Can't save if there are pre-existing errors
        if (!empty($this->errors))
            return false;

        // Can't save without filename and temp location
        if (empty($this->filename) || empty($this->temp_path)) {
            $this->errors[] = "The file location was not available.";
            return false;
        }

        $personal_dir = $this->upload_dir . DS . strtolower($this->applicant_first) . '_' . strtolower($this->applicant_last);

        // Determine the target_path
        $target_path = RET_SITE_ROOT . DS . $personal_dir . DS . $this->filename;

        // Make sure a file doesn't already exist in the target location
        if (file_exists($target_path)) {
            $this->errors[] = "Another reference has submitted a file with the same name: {$this->filename}. Please change the filename, press the back button in your browser, and resubmit.";
            return false;
        }

        // check to see if e-mail is valid
        if (!validate_email($this->email)) {
            $this->errors[] = "Please enter a valid e-mail address.";
            return false;
        }

        // Attempt to move the file
        if (move_uploaded_file($this->temp_path, $target_path)) {
            // Success
            // Save a corresponding entry to the database
            if ($this->create()) {
                // We are done with temp_path, the file isn't there anymore
                unset($this->temp_path);
                return true;
            }
        } else {
            // File was not moved.
            $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
            return false;
        }
    }
}
