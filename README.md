# TP8DPBO2526C1


# Campus Data (PHP Native MVC)

Tugas Praktikum 8 DPBO 2026

Janji Saya Bozorov Huseyn (NIM: 2521812) mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahannya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

A PHP Native web application that manages campus data using the Model-View-Controller (MVC) architecture, PDO and prepared statements.

## Website Theme

The theme is campus data. Users can manage lecturers, the departments the lecturers belong to, and the courses that the lecturers teach. Every entity has full CRUD (Create, Read, Update, Delete).

The starting project (tp_mvc25) only had CRUD for the lecturers table, with the query and the HTML mixed together in single PHP files. For this assignment the project was restructured into MVC, two new tables were added, and CRUD was built for them.

## Database

The database is called tp_mvc25 and contains three tables. The full structure and sample data are in SQL/tp_mvc25.sql.

departments (new table) stores the study programs. Columns: id (primary key), name, faculty.

lecturers (original table) stores the lecturers. Columns: id (primary key), name, nidn, phone, join_date and department_id (new column).

courses (new table) stores the courses. Columns: id (primary key), code, name, credits and lecturer_id.

Relations: lecturers.department_id is a foreign key to departments.id, and courses.lecturer_id is a foreign key to lecturers.id. So one department has many lecturers, and one lecturer teaches many courses. Both foreign keys use ON DELETE SET NULL, so deleting a department or a lecturer does not delete the rows that point to it. Those rows only lose the link and show "-" in the table.

## Project Structure

Project/models/ contains one Model class per table: Lecturer.php, Department.php and Course.php, plus DB.php that creates the PDO connection (singleton). The Models only talk to the database and return arrays. They contain no HTML.

Project/views/ contains the View classes: LecturerView.php, DepartmentView.php and CourseView.php, plus Template.php which holds the shared layout (navbar), the escape helper, the delete button and the dropdown options. The Views only build HTML from the data they receive.

Project/controllers/ contains one Controller per table: LecturerController.php, DepartmentController.php and CourseController.php. Each Controller has the methods index, create, store, edit, update and delete. It reads the request, calls the Model, and passes the result to the View.

Project/assets/ contains the Bootstrap files.

Project/index.php is the entry point (front controller) that routes the request to the right Controller.

Project/config.php contains the database credentials.

SQL/ contains tp_mvc25.sql with the table structure and sample data.

Dokumentasi/ contains the screenshots and the screen recording.

## Code Flow

1. The browser sends a request to index.php, for example index.php?entity=courses&action=index.
2. index.php loads the three Controllers. The entity parameter is checked against a whitelist (lecturers, departments, courses) and the action parameter against a whitelist (index, create, store, edit, update, delete). An unknown value returns 404, and the default is the lecturers page.
3. The actions store, update and delete are only accepted through POST. Any other method returns 405.
4. index.php creates the Controller of the requested entity and calls the method named by action.
5. The Controller reads the input from $_GET or $_POST and calls the matching method of the Model (all, find, create, update, delete).
6. The Model runs a prepared statement through PDO on the database and returns the rows as a PHP array to the Controller.
7. For a page that is shown (index, create, edit), the Controller passes the data to the View. The View turns the array into HTML and sends it to the browser. The form pages of lecturers and courses also receive the list of departments or lecturers to fill the dropdown for the relation.
8. For store, update and delete, the Controller calls the Model and then redirects back to the list page (Post/Redirect/Get), which prevents duplicate submissions when the page is refreshed.
9. Clicking Edit opens ?action=edit&id=ID, the Controller loads the row with find, and the View fills the form with the existing data. Submitting the form sends the update action.

| Action | Method | Flow |
|---|---|---|
| index (Read) | GET | Controller -> Model::all() -> View::index() |
| create (form) | GET | Controller -> View::form(null) |
| store (Create) | POST | Controller -> Model::create() -> redirect |
| edit (form) | GET | Controller -> Model::find() -> View::form(row) |
| update (Update) | POST | Controller -> Model::update() -> redirect |
| delete (Delete) | POST | Controller -> Model::delete() -> redirect |

All queries use prepared statements with placeholders through PDO, so user input is never concatenated into SQL. All output in the Views is escaped with htmlspecialchars. Deleting is done with a POST form and a confirmation dialog instead of a plain link.

## How to Run

1. Start Apache and MySQL (XAMPP, MAMP, Laragon) or install PHP and MySQL locally.
2. Import SQL/tp_mvc25.sql with phpMyAdmin or the mysql command line. It creates the database tp_mvc25 with the three tables and sample data.
3. Check the credentials in Project/config.php (host, database name, username, password).
4. Put the Project folder in htdocs (XAMPP) or www (Laragon), for example as htdocs/tp_mvc25, and open http://localhost/tp_mvc25/index.php. Alternatively, run php -S localhost:8000 inside the Project folder and open http://localhost:8000.

## Run Documentation

A screen recording of the website running, where CRUD is tried on all tables, is in the Dokumentasi folder.
Screen record - Screen Recording TP8.mp4

Lecturers page:

![Lecturers](Dokumentasi/01_lecturers_index.png)

Create lecturer (with the department dropdown):

![Create Lecturer](Dokumentasi/02_lecturers_create.png)

Departments page:

![Departments](Dokumentasi/03_departments_index.png)

Create department:

![Create Department](Dokumentasi/04_departments_create.png)

Courses page:

![Courses](Dokumentasi/05_courses_index.png)

Create course (with the lecturer dropdown):

![Create Course](Dokumentasi/06_courses_create.png)

Edit course:

![Edit Course](Dokumentasi/07_courses_edit.png)
