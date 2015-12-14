# Pizza-Order-Website
A website to create Pizza orders. Provides the required Website files and the Sql files to setup the database.<br>
This was created as the final project for Appalachian State University's CS 3430: Database course.
<p>
The outer frame displayed by the different webpages was taken from [Appalachian State University's Food Services](http://foodservices.appstate.edu/) page.<br>
As such, the majority of the **/website/includes/** and **/website/images/** are Appalachian State property.
<p>
Project Members:
 * Austin Keener ([DV8FromTheWorld](https://github.com/DV8FromTheWorld))
 * James Corsi   ([WamboJambo](https://github.com/WamboJambo))
 * Tamarcus Garcia
 * Drew Morton

Class Name: **CS 3430, Database**<br>
Class Teacher: **[Dr. Rahman Tashakkori](http://cs.appstate.edu/~rt/)**<br>
Class Semester: **Spring Semester, 2015** 

## Dependencies
 * Bootstrap.js
   * Version: **3.3.4**
   * [Download](https://github.com/twbs/bootstrap/releases/tag/v3.3.4)
   * [Website](http://getbootstrap.com/)
 * Bootstrap-Validator
   * Version: **0.8.1**
   * [Download](https://github.com/1000hz/bootstrap-validator/releases/tag/v0.8.1)
   * [Website](http://1000hz.github.io/bootstrap-validator/)
 * BootstrapFormHelpers
   * Version: **2.3.0**
   * [Download](https://github.com/winmarkltd/BootstrapFormHelpers/releases/tag/2.3.0)
   * [Website](http://bootstrapformhelpers.com/)
 * JQuery
   * Version: **1.11.2**
   * Download: Unneeded, it is downloaded in-line.
   * [Website](https://jquery.com/)

## Requirements
 * All dependencies
 * A PHP enabled Webserver (Apache HTTPd with PHP is recommended)
 * An SQL compliant database implementation (MySQL is recommended)

# Setup
### Step 1: Get project
You need to download the project either using Git pull or download a snapshot of the Master branch of this repo.<br>
[Snapshot](https://github.com/DV8FromTheWorld/Pizza-Order-Website/archive/master.zip)<br>
After you've downloaded, place **/website/** in the web folder for your PHP enabled Webserver

### Step 2: Dependency Setup
**NOTE:** Do not include the root folder, only the contents of the root folder.
* Bootstrap.js
  * Install Directory: **/website/bootstrap/**
  * Copy contents of the bootstrap-*VERSION*-dist folder into the Install Directory.
  * Files copied should include 
    * /css/
    * /fonts/
    * /js/
* Bootstrap-Validator
  * Install Directory: **/website/bootstrap/bootstrap-validator/**
  * Copy contents of the bootstrap-validator-*VERSION* folder into the Install Directory.
  * Files copied should include
    * /dist/
    * /docs/
    * /js/
    * All other files in this folder.
* BootstrapFormHelpers
  * Install Directory: **/website/bootstrap/BootstrapFormHelpers/**
  * Copy contents of the BootstrapFormHelpers-*VERSION* folder into the Install Directory.
  * Files copied should include
    * /dist/
    * /img/
    * /js/
    * /less/
    * bfh-*PLUGIN*.jquery.json
    * All other files in this folder

### Step 3: Create the database.
In the **/sql/** folder there are 3 shell files to pay attention to: **CreateDB.sh**, **DropDB.sh** and **Sql.sh**.<br>
These all interface directly with the MySql server through the linux command line. If you wish to use these to automate creating the database, then you need to edit them and populate their user, password and database values.
<p>
If you don't want to use the shell files, aren't using MySQL or you aren't on a unix based machine you can also use the **CreateDB.sql** files to create the database.<br>
You will need to be logged into the Sql server and have created and selected the database which you want to work with.<br>
[How to Create and Select a Database](http://dev.mysql.com/doc/refman/5.7/en/creating-database.html)<br>w
After you have created and selected you database, you will need to **source** the **CreateDB.sql** file into the database.

### Step 4: Database Connection information
In the **/website/** folder locate the **connect.php** file. You will need to populate the **$server**, **$user**, **$pass** and **$db** variables with the proper information needed to connect to the database you just created.<br>
If the SQL server is running on the same machine as the PHP enabled Webserver, then **$server** should be "localhost".

### Setup Complete
Hopefully the setup process the went well and it all you now have a working website!
