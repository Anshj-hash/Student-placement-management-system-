CREATE DATABASE IF NOT EXISTS placement_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE placement_portal;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','student') NOT NULL DEFAULT 'student',
 department VARCHAR(80) DEFAULT NULL,
 cgpa DECIMAL(4,2) NOT NULL DEFAULT 0,
 phone VARCHAR(20) DEFAULT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE companies (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 website VARCHAR(255) DEFAULT NULL,
 description TEXT DEFAULT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE jobs (
 id INT AUTO_INCREMENT PRIMARY KEY,
 company_id INT NOT NULL,
 title VARCHAR(150) NOT NULL,
 description TEXT NOT NULL,
 location VARCHAR(120) DEFAULT NULL,
 job_type ENUM('Full-time','Internship','Part-time') DEFAULT 'Full-time',
 salary VARCHAR(100) DEFAULT NULL,
 min_cgpa DECIMAL(4,2) NOT NULL DEFAULT 0,
 deadline DATE DEFAULT NULL,
 status ENUM('Open','Closed') NOT NULL DEFAULT 'Open',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_jobs_company FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE applications (
 id INT AUTO_INCREMENT PRIMARY KEY,
 job_id INT NOT NULL,
 student_id INT NOT NULL,
 resume_file VARCHAR(255) DEFAULT NULL,
 status ENUM('Applied','Shortlisted','Selected','Rejected') NOT NULL DEFAULT 'Applied',
 applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_student_job(student_id,job_id),
 CONSTRAINT fk_app_job FOREIGN KEY(job_id) REFERENCES jobs(id) ON DELETE CASCADE,
 CONSTRAINT fk_app_student FOREIGN KEY(student_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE interviews (
 id INT AUTO_INCREMENT PRIMARY KEY,
 application_id INT NOT NULL,
 interview_date DATETIME NOT NULL,
 mode VARCHAR(50) DEFAULT NULL,
 notes TEXT DEFAULT NULL,
 CONSTRAINT fk_interview_application FOREIGN KEY(application_id) REFERENCES applications(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Demo admin account: admin@college.test / password
-- Password hash below is generated with PHP password_hash('password', PASSWORD_DEFAULT).
INSERT INTO users(name,email,password,role,department,cgpa)
VALUES('Placement Administrator','admin@college.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','admin','Administration',10.00);

INSERT INTO companies(name,website,description) VALUES
('TechNova Solutions','https://example.com','Technology and software services company.'),
('BrightByte Systems','https://example.com','Digital product and IT consulting company.');

INSERT INTO jobs(company_id,title,description,location,job_type,salary,min_cgpa,deadline) VALUES
(1,'Junior Web Developer','Assist the development team with responsive websites, debugging and basic database tasks. Good knowledge of HTML, CSS, JavaScript and PHP is preferred.','Mohali, India','Full-time','₹3–4 LPA',6.00,DATE_ADD(CURDATE(), INTERVAL 30 DAY)),
(2,'Python Developer Intern','Work on small Python automation tasks, API integration and testing with mentorship from the engineering team.','Remote','Internship','₹12,000 / month',6.50,DATE_ADD(CURDATE(), INTERVAL 20 DAY));
