Vagabond School Student Management System
==============
## Basic Design Concepts
#### Students
* Students can be assigned to categories

#### Employees
* Employees can be assigned to categories

#### Courses
* Courses MUST be assigned a unique batch, but can have more
 * Batches are only assigned to one course

## Setup Configuration
* 'innodb_log_file_size' must be increased (preferably to 48M) in my.ini.
* 'innodb_buffer_pool_size' should be raised, as a consequence (preferably to 192M) in my.ini.
