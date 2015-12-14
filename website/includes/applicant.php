<?php
/**
 * Class: Represents a single applicant for insertion into the MySQL persistent store.
 * @author Seth Hobson
 * @version 02/13/2013
 */
require_once(RET_LIB_PATH.DS.'database.php');

class Applicant extends Person
{
    private $temp_path_essay;
    private $temp_path_resume;
    protected $table_name = 'applicant';
    protected $db_fields = array(
        'first_name',
        'middle_initial',
        'last_name',
        'email',
        'home_phone',
        'cell_phone',
        'gender',
        'ethnicity',
        'street',
        'city',
        'state',
        'zip_code',
        'school',
        'county',
        'primary_course',
        'secondary_course',
        'title',
        'essay',
        'resume',
        'recommender_one_first',
        'recommender_one_last',
        'recommender_one_phone',
        'recommender_one_email',
        'recommender_two_first',
        'recommender_two_last',
        'recommender_two_phone',
        'recommender_two_email',
        'supervisor_first',
        'supervisor_last',
        'supervisor_phone',
        'supervisor_email'
    );

    public $first_name;
    public $middle_initial;
    public $last_name;
    public $email;
    public $home_phone;
    public $cell_phone;
    public $gender;
    public $ethnicity;
    public $street;
    public $city;
    public $state;
    public $zip_code;
    public $school;
    public $county;
    public $primary_course;
    public $secondary_course;
    public $title;
    public $essay;
    public $resume;
    public $recommender_one_first;
    public $recommender_one_last;
    public $recommender_one_phone;
    public $recommender_one_email;
    public $recommender_two_first;
    public $recommender_two_last;
    public $recommender_two_phone;
    public $recommender_two_email;
    public $supervisor_first;
    public $supervisor_last;
    public $supervisor_phone;
    public $supervisor_email;

    
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
            if ($resume) {
                $this->temp_path_resume = $file['tmp_name'];
                $this->resume = basename($file['name']);
            } else {
                $this->temp_path_essay = $file['tmp_name'];
                $this->essay = basename($file['name']);
            }
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
        if (empty($this->essay) || empty($this->temp_path_essay) || empty($this->temp_path_resume)) {
            $this->errors[] = "The file location was not available.";
            return false;
        }

        $personal_dir = $this->upload_dir . DS . strtolower($this->first_name) . '_' . strtolower($this->last_name);

        mkdir($personal_dir, 0777, true);
        chmod($personal_dir, 0777);
    
        // Determine the target_path
        $essay_target_path = RET_SITE_ROOT . DS . $personal_dir . DS . $this->essay;
        $resume_target_path = RET_SITE_ROOT . DS . $personal_dir . DS . $this->resume;
    
        // Make sure a file doesn't already exist in the target location
        if (file_exists($essay_target_path)) {
            $this->errors[] = "The file {$this->essay} already exists.";
            return false;
        }

        if (file_exists($resume_target_path)) {
            $this->errors[] = "The file {$this->resume} already exists";
            return false;
        }

        // check to see if e-mail is valid
        if (!validate_email($this->email)) {
            $this->errors[] = "Please enter a valid e-mail address.";
            return false;
        }
    
        // Attempt to move the file 
        if (move_uploaded_file($this->temp_path_essay, $essay_target_path) && move_uploaded_file($this->temp_path_resume, $resume_target_path)) {
            // Success
            // Save a corresponding entry to the database
            if ($this->create()) {
                // We are done with temp_path, the file isn't there anymore
                unset($this->temp_path_essay);
                unset($this->temp_path_resume);
                $this->send_reference_mail();
                $this->send_supervisor_mail();
                $this->send_ourselves_mail();
                return true;
            }
        } else {
            // File was not moved.
            $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
            return false;
        }
    }

    private function send_reference_mail()
    {
        $reference_emails = array($this->recommender_one_email, $this->recommender_two_email);
        $reference_first_names = array($this->recommender_one_first, $this->recommender_two_first);
        $reference_last_names = array($this->recommender_one_last, $this->recommender_two_last);

        $subject = 'Research Experience for Teachers Reference Information Request';

        for ($i = 0; $i < 2; $i++) {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
            $headers .= "To: {$reference_first_names[$i]} {$reference_last_names[$i]} <{$reference_emails[$i]}>" . "\r\n";
            $headers .= 'From: Rahman Tashakkori <rt@cs.appstate.edu>' . "\r\n";
            $message = "{$this->first_name} {$this->last_name} has listed you as a reference.\n";
            $message .= "This is a request for information. Please go to the following link in your to submit a reference for this individual:\n\n";
            $message .= 'http://cs.appstate.edu/ret/reference_submission.php?applicant_first=' . $this->first_name . '&applicant_last=' . $this->last_name;
            $message .= '&referer=' . "{$reference_first_names[$i]}_{$reference_last_names[$i]}";
            $message .= "\n\nThank you for your time.\n\nDr. Rahman Tashakkori\nDepartment of Computer Science";
            mail($reference_emails[$i], $subject, $message, $headers);
        }
    }

    private function send_supervisor_mail()
    {
        $subject = 'Research Experience for Teachers Reference Information Request';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
        $headers .= "To: {$this->supervisor_first} {$this->supervisor_last} <{$this->supervisor_email}>" . "\r\n";
        $headers .= 'From: Rahman Tashakkori <rt@cs.appstate.edu>' . "\r\n";
        $message = "{$this->first_name} {$this->last_name} has listed you as a supervisor who will provide a support letter for the RET summer program at Appalachian State University.
        The letter should indicate your support of the applicant's participation and provide some details on why the RET program
        will be benefit the applicant's school. We appreciate your comments on the applicant's qualifications and teaching style 
        that fits the goals of this unique program.\n";
        $message .= "Please go to the following link to submit your reference letter.\n\n";
        $message .= 'http://cs.appstate.edu/ret/supervisor_submission.php?applicant_first=' . $this->first_name . '&applicant_last=' . $this->last_name;
        $message .= '&supervisor=' . "{$this->supervisor_first}_{$this->supervisor_last}";
        $message .= "\n\nThank you very much.\n\nDr. Rahman Tashakkori\nDepartment of Computer Science";
        mail($this->supervisor_email, $subject, $message, $headers);
    }

    private function send_ourselves_mail()
    {
        $subject = 'Research Experience for Teachers Submission';
        $message = "{$this->first_name} {$this->last_name} has submitted an application.\n";
        mail("ret@cs.appstate.edu", $subject, $message);
    }
}
