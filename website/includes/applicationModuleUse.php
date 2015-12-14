<?php
/**
 * Class: Represents a single applicant for insertion into the MySQL persistent store.
 * @RT
 * @version 8/29/2013 - Oroginally by Seth Hobson
 */
require_once(RET_LIB_PATH.DS.'databaseModule.php');

class applicationModuleUse extends modulePerson
{
    private $temp_path_essay;
    private $temp_path_resume;
    protected $table_name = 'moduleUse';
    protected $db_fields = array(
        'useID',
        'teacherName',
        'classSubject',
        'schoolName',
        'emailAddress',
        'moduleNumber',
        'dateOfUse',
        'additionalComments',
    );

    public $useID;
    public $teacherName;
    public $classSubject;
    public $schoolName;
    public $emailAddress;
    public $moduleNumber;
    public $dateOfUse;
    public $additionalComments;

    
    public function save()
    {
        // Can't save if there are pre-existing errors
        if (!empty($this->errors))
            return false;

        if ($this->create()) {
            $this->send_ourselves_mail();
            return true;
        } else {
            // File was not moved.
            $this->errors[] = "The data could not be saved.";
            return false;
        }
    }

    private function send_ourselves_mail()
    {
        $subject = 'Research Experience for Teachers Module Use Submission form';
        $message = "Thank you very much {$this->first_name} {$this->last_name} for submitting this report on the module you have used.\n";
        mail("ret@cs.appstate.edu", $subject, $message);
    }
}
