# BeConnectEd_website
This is an Learning Management System (LMS) website and it is named BeConnectEd.

## Tech Stack
* Backend: PHP (mysqli)
* Database: MySQL (phpMyAdmin)
* Frontend: HTML, CSS, Bootstrap 
* Local server: XAMPP (Apache + MySQL)

## Project Overview
The project is aimed for two account types
* Institute users (registered by admins)
* Independent users (self-registration)

### Multiple user roles 
* Students 
* Teachers or Lecturers 
* Administrators 

## What has been implemented so far

### Accessibility 
* This website has some accessibility features such as 
    - Dark/light Mode (so far, it has only JS to support it therefore, if used on different computer, it will not keep the change)
    - Keyboard Navigation  
        - tab - to move forward
        - shift + tab - to move backwards
        - enter - to click
        - alt + left /right arrow - to go back/forward
        - space – to scroll down 
        - shift + space – to scroll up 
    - Alt Text for images
    - Colour Contrast 
    - Responsive to different screens 

### Profile
* The profile shows the user's name, surname and role
* Can Upload a picture and Save
* Can remove picture
* Can Sign Out

### Welcome Banner 
* The welcome banner has 
    * stating if it is morning, afternoon or evening 
    * user's name and surname
    * positive messages 

### Login with Institute 
    - Note to login with institute - Demo accounts (for testing):
        - katiakurmi@gmail.com  password: katia123456 (Administrator)
        - kevinp@gmail.com  password: kevin123456  (Student)
        - ian@gmail.com password: ian123456  (Teacher)
* Registered users who login for the first time are obliged to change the password by redirect them to the Reset Password page. (At later stage a verification Code will be sent to the user for authentication)
* Registered users should write e-mail and password and be able to login 
* The registered users can change password through the Reset Password page

### Create account and Login as Independent user
    - Note to create an account or login as independent 
        - You can create an account and login as independent user 
* Register yourself as independent users by filling the form with personal details and choose your role (student or teacher). 
* Registered users who login for the first time are obliged to change the password by redirect them to the Reset Password page. (At later stage a verification Code will be sent to the user for authentication)
* Registered users should write e-mail and password and be able to login 
* The registered users can change password through the Reset Password page
* The users will be redirected to the institute home page depending on the role (at later stage independent pages will be created)

## Home Pages (Role-Based)
* After login, users are redirected to a role-based home page:
  - Administrator - `admin_index.php`
  - Teacher - `teacher_index.php`
  - Student - `student_index.php`
  - Parent - ` parent_index.php `(still empty)
  - Independent teacher - `independent_teacher_index.php`(Not created yet)
  - Independent student - `independent_student_index.php`(Not created yet)
* Each home page includes shared navigation and a welcome banner.

### Administrators 
#### Register users 
* Fill in the new registration form 
    - Choose role 
    - Write first name and last name 
    - E-mail address 
    - Date of Birth 
    - Choose is active or inactive 
    - Choose which institute are you 
    - The hashed password is generated automatically 
    - The must_change_password is =1
* Edit/View - Administrators can edit the data of the users and update the database 
#### Enrolment of Students 
* Fill in the form 
    - Choose course 
    - Choose Class 
    - Choose and add students 
    - Admin can remove a student from a class (removal updates the database)
#### Courses and Units 
* Fill in the Add Course form 
    - Write course name, course code, MQF Level, Course Duration, Credits(int) and Description
    - Choose is active or inactive
    - Choose which institute you are creating the course for 
* Edit/View - Administrators can edit the data of the course and update the database 

* Fill in the Add Unit form 
    - Write unit name, unit code, ECTS credits, unit duration and unit description 
    - Choose is active or inactive 
* Edit/View - Administrators can edit the data of the unit and update the database 
#### Assign Units to Course 
* Fill in the form 
    - Choose a course 
    - Choose multiple unit 
    - Remove one or more units and updates the DB 
#### Classes 
* Fill in the New Class form 
    - Write class name 
    - Choose a course 
 * Edit/View - Administrators can change the class name and the course it is assigned with and update the database  
 #### Assign Teachers 
 * Fill in the Assign New Teacher to Unit and Class form 
    - Choose a unit 
    - Choose a teacher 
    - Choose a class 
* Edit/View - Administrators can change the class and tick or untick multiple units that the teacher will be teaching to that particular class

### Students 
#### Enrolment 
* The Enrolment page for the students is view only, showing the particular course details that the student is enrolled in 
    - Course name
    - Course Code
    - Unit name
    - Unit Code
    - Lecturer name/s

### Authentication & Security (implemented so far)
* Passwords are stored securely using password_hash()
* Database actions use prepared statements (mysqli_stmt_prepare) to reduce SQL injection risk.
* Independent users and institute users are separated using is_independent:
  - Independent users cannot log in from the institute login page.
  - Institute users cannot log in from the independent login page.