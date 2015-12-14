<?php
/**
 * Class: Represents a single applicant for insertion into the MySQL persistent store.
 * @author Seth Hobson
 * @version 02/13/2013
 */
require_once(RET_LIB_PATH.DS.'databaseW.php');

class applicantW extends PersonW
{
    private $temp_path_essay;
    private $temp_path_resume;
    protected $table_name = 'applicantsWorkshop';
    protected $db_fields = array(
        'appWID',
        'firstName',
        'MI',
        'lastName',
        'role',
        'gender',
        'address',
        'city',
        'state',
        'zipCode',
        'email',
        'workPhone',
        'cellPhone',
        'ethnicity',
        'course',
        'schoolName',
        'schoolType',
        'county',
        'additionalComments'
    );

    public $appWID;
    public $firstName;
    public $MI;
    public $lastName;
    public $role;
    public $gender;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $email;
    public $workPhone;
    public $cellPhone;
    public $ethnicity;
    public $course;
    public $schoolName;
    public $schoolType;
    public $county;
    public $additionalComments;

    public function save()
    {
        // Can't save if there are pre-existing errors
        if (!empty($this->errors))
            return false;

        if ($this->create()) {
            $this->send_ourselves_mail();
            $this->send_applicant_mail();
            return true;
        } else {
            // File was not moved.
            $this->errors[] = "The data could not be saved.";
            return false;
        }                                                                            
    }


   private function send_applicant_mail()
   {
        $subject = 'Research Experience for Teachers Workshop Application';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
        $headers .= "To: {$this->firstName} {$this->lastName} <{$this->email}>" . "\r\n";
        $headers .= 'From: Rahman Tashakkori <rt@cs.appstate.edu>' . "\r\n";
        $message = "Thank you very much for submitting this RET Workshop Application. You will be contacted very soon. Please 
        check the web page of the program at www.cs.appstate.edu/ret for updates.\n";
        mail($this->email, $subject, $message, $headers);
   }


   private function send_ourselves_mail()
   {

        $subject = 'Research Experience for Teachers Workshop Registration Form';
        $message = "{$this->firstName} {$this->lastName} {$this->lastName} <{$this->email}> has registered for the RET Workshop at ASU. \n";
        $headers = "From: RET Program\r\n";
        mail("rt@cs.appstate.edu", $subject, $message, $headers);

    }
}
