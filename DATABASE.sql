-- Create the OBE database
CREATE DATABASE IF NOT EXISTS OBE;

-- Switch to OBE database
USE OBE;

-- Main table
CREATE TABLE csd_main (
    serial_number INT,
    subject_number VARCHAR(20),
    subject_code VARCHAR(20) PRIMARY KEY NOT NULL,
    scheme_year INT NOT NULL,
    semester INT NOT NULL
);

-- Subjects table
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20),
    subject_name VARCHAR(100) NOT NULL,
    faculty VARCHAR(100),
	credits INT NOT NULL,
    FOREIGN KEY (subject_code) REFERENCES csd_main(subject_code)
);

-- Course outcomes table
CREATE TABLE course_outcomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20),
    course_outcome TEXT,
    FOREIGN KEY (subject_code) REFERENCES csd_main(subject_code)
);

-- Insert data into csd_main table
INSERT INTO csd_main (serial_number, subject_number, subject_code, scheme_year, semester)
VALUES
(1, 'C201', 'BCS301', 2022, 3),
(2, 'C202', 'BCS302', 2022, 3),
(3, 'C203', 'BCS303', 2022, 3),
(4, 'C204', 'BCS304', 2022, 3),
(5, 'C205', 'BCSL305', 2022, 3),
(6, 'C206', 'BCS306A', 2022, 3),
(7, 'C207', 'BCSK307', 2022, 3),
(8, 'C208', 'BCG358A', 2022, 3),
(9, 'C210', 'BYOK359', 2022, 3),
(10, 'C211', 'BCS401', 2022, 4),
(11, 'C212', 'BCG402', 2022, 4),
(12, 'C213', 'BCS403', 2022, 4),
(13, 'C214', 'BCSL404', 2022, 4),
(14, 'C215', 'BCS405A', 2022, 4),
(15, 'C216', 'BCGL456B', 2022, 4),
(16, 'C217', 'BBOK407', 2022, 4),
(17, 'C218', 'BUHK408', 2022, 4),
(18, 'C219', 'BYOK459', 2022, 4);

-- Insert data into subjects table
INSERT INTO subjects (subject_code, subject_name, faculty, credits)
VALUES
('BCS301', 'Mathematics for CSE stream', 'Dr. Soumya', 4),
('BCS302', 'Digital Design & Computer Organization', 'Mrs. Sheethal Lobo', 4),
('BCS303', 'Operating Systems', 'Dr. Pramod', 4),
('BCS304', 'Data Structures and Applications', 'Mrs. Ayisha Khanum', 3),
('BCSL305', 'Data Structures Lab', 'Mrs. Ayisha Khanum', 1),
('BCS306A', 'Object Oriented Programming with Java', 'Ms. Preethi S Gowda', 3),
('BCSK307', 'Social Connect and Responsibility', 'Ms. Preethi S Gowda', 1),
('BCG358A', 'Web Application Design with HTML and PHP', 'Ms. Preethi S Gowda', 1),
('BYOK359', 'Yoga', 'Ms. Preethi S Gowda', 0),
('BCS401', 'Analysis & Design of Algorithms', 'Mrs. Ayisha Khanum', 3),
('BCG402', 'Computer Graphics and Visualization', 'Ms. Preethi S Gowda', 4),
('BCS403', 'Database Management System', 'Dr. Pramod', 4),
('BCSL404', 'Analysis & Design of Algorithms Lab', 'Mrs. Ayisha Khanum', 1),
('BCS405A', 'Discrete Mathematical Structures', 'Ms. Meghana R', 3),
('BCGL456B', 'Responsive Web design with Bootstrap 5.0', 'Ms. Preethi S Gowda', 1),
('BBOK407', 'Biology For Computer Engineers', 'Mr. Rohit', 2),
('BUHK408', 'Universal human values course', 'Dr. Pramod', 1),
('BYOK459', 'Yoga', 'Dr. Sendhil', 0);

-- Insert data into course_outcomes table
INSERT INTO course_outcomes (subject_code, course_outcome)
VALUES
('BCS301', 'Explain the basic concepts of probability, random variables, probability distribution. Apply suitable probability distribution models for the given scenario. Apply the notion of a discrete-time Markov chain and n-step transition probabilities to solve the given problem. Use statistical methodology and tools in the engineering problem-solving process. Compute the confidence intervals for the mean of the population. Apply the ANOVA test related to engineering problems.'),
('BCS302', 'Apply the K–Map techniques to simplify various Boolean expressions. Design different types of combinational and sequential circuits along with Verilog programs. Describe the fundamentals of machine instructions, addressing modes and Processor performance. Explain the approaches involved in achieving communication between processor and I/O devices. Analyze internal Organization of Memory and Impact of cache/Pipelining on Processor Performance.'),
('BCS303', 'Explain the structure and functionality of operating system. Apply appropriate CPU scheduling algorithms for the given problem. Analyse the various techniques for process synchronization and deadlock handling. Apply the various techniques for memory management. Explain file and secondary storage management strategies. Describe the need for information protection mechanisms.'),
('BCS304', 'Explain different data structures and their applications. Apply Arrays, Stacks and Queue data structures to solve the given problems. Use the concept of linked list in problem solving. Develop solutions using trees and graphs to model the real-world problem. Explain the advanced Data Structures concepts such as Hashing Techniques and Optimal Binary Search Trees.'),
('BCSL305', 'Analyze various linear and non-linear data structures. Demonstrate the working nature of different types of data structures and their applications. Use appropriate searching and sorting algorithms for the given scenario. Apply the appropriate data structure for solving real world problems.'),
('BCS306A', 'Demonstrate proficiency in writing simple programs involving branching and looping structures. Design a class involving data members and methods for the given scenario. Apply the concepts of inheritance and interfaces in solving real world problems. Use the concept of packages and exception handling in solving complex problem. Apply concepts of multithreading, autoboxing and enumerations in program development.'),
('BCSK307', 'Communicate and connect to the surrounding. Create a responsible connection with the society. Involve in the community in general in which they work. Notice the needs and problems of the community and involve them in problem-solving. Develop among themselves a sense of social & civic responsibility & utilize their knowledge in finding practical solutions to individual and community problems. Develop competence required for group-living and sharing of responsibilities & gain skills in mobilizing community participation to acquire leadership qualities and democratic attitudes.'),
('BCG358A', 'Design tables and forms by using suitable CSS properties. Develop programs in PHP involving control structures. Develop programs to handle complex data items. Develop programs to access and manipulate the contents of files. Use super-global arrays in developing Web application.'),
('BYOK359', 'Learn and practice yoga.'),
('BCS401', 'Apply asymptotic notational method to analyze the performance of the algorithms in terms of time complexity. Demonstrate divide & conquer approaches and decrease & conquer approaches to solve computational problems. Make use of transform & conquer and dynamic programming design approaches to solve the given real world or complex computational problems. Apply greedy and input enhancement methods to solve graph & string based computational problems. Analyse various classes (P,NP and NP Complete) of problems. Illustrate backtracking, branch & bound and approximation methods.'),
('BCG402', 'Demonstrate simple algorithms using OpenGL Graphics primitives and attributes. Apply mathematical concepts for 2-D and 3-D geometric transformations. Make use of OpenGL functions for Interactive Input, GUI and animations. Explain clipping algorithms, color models and illumination models. Demonstrate visualization of surfaces and 3D objects.'),
('BCS403', 'Describe the basic elements of a relational database management system. Design entity relationship for the given scenario. Apply various Structured Query Language (SQL) statements for database manipulation. Analyse various normalization forms for the given application. Develop database applications for the given real world problem. Understand the concepts related to NoSQL databases.'),
('BCSL404', 'Develop programs to solve computational problems using suitable algorithm design strategy. Compare algorithm design strategies by developing equivalent programs and observing running times for analysis (Empirical). Make use of suitable integrated development tools to develop programs. Choose appropriate algorithm design techniques to develop solution to the computational and complex problems. Demonstrate and present the development of program, its execution and running time(s) and record the results/inferences.'),
('BCS405A', 'Apply concepts of logical reasoning and mathematical proof techniques in proving theorems and statements. Demonstrate the application of discrete structures in different fields of computer science. Apply the basic concepts of relations, functions and partially ordered sets for computer representations. Solve problems involving recurrence relations and generating functions. Illustrate the fundamental principles of Algebraic structures with the problems related to computer science & engineering.'),
('BCGL456B', 'Apply concepts of Bootstrap framework based layout and navigation classes to develop Web Pages. Design Web pages to organize data and present text with features using Bootstrap framework. Develop Web User interfaces for varieties of interactions with Bootstrap framework classes. Build Web pages involving animations, popups and accordions with Bootstrap framework classes. Make use of Bootstrap framework image, alert and modal classes in developing Web pages.'),
('BBOK407', 'Understand biological concepts relevant to computer engineers.'),
('BUHK408', 'Understand universal human values and ethics.'),
('BYOK459', 'Learn and practice yoga.');
