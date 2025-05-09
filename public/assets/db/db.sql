CREATE DATABASE IF NOT EXISTS EduGrow_DB;
USE EduGrow_DB;
-- drop database EduGrow_DB;

CREATE TABLE students (
student_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE teachers (
teacher_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subjects (
subject_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
description TEXT NULL,
teacher_id INT(11) NOT NULL,
img VARCHAR(255) NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_teacher
	FOREIGN KEY (teacher_id)
	REFERENCES teachers(teacher_id)
	ON DELETE CASCADE
);

-- drop table subjects;

CREATE TABLE class_groups (
class_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
class_name VARCHAR(255) NOT NULL,
student_id INT(11) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE
);

CREATE TABLE student_subject (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  student_id INT(11) NOT NULL,
  subject_id INT(11) NOT NULL,
  joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_student_subject_student 
    FOREIGN KEY (student_id) 
    REFERENCES students(student_id) 
    ON DELETE CASCADE,
  CONSTRAINT fk_student_subject_subject 
    FOREIGN KEY (subject_id) 
    REFERENCES subjects(subject_id) 
    ON DELETE CASCADE
);


CREATE TABLE semester_goals (
goal_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
student_id INT(11) NOT NULL,
subject_id INT(11) NOT NULL,
title VARCHAR(255) NOT NULL,
semester VARCHAR(255) NOT NULL,
description TEXT NULL,
status VARCHAR(255) NOT NULL,
deadline DATE NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_semester_goal_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE,
CONSTRAINT fk_semester_goal_subject
	FOREIGN KEY (subject_id)
	REFERENCES subjects(subject_id)
	ON DELETE CASCADE
);

CREATE TABLE learning_journal (
learning_journal_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
id INT(11) NOT NULL,
semester VARCHAR(255) NOT NULL,
week_number INT(11) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_student_subject
	FOREIGN KEY (id)
	REFERENCES student_subject(id)
	ON DELETE CASCADE
);

CREATE TABLE learning_journal_contents (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
learning_journal_id INT(11) NOT NULL,
isClass BOOLEAN DEFAULT FALSE,
isSelf BOOLEAN DEFAULT FALSE,
content TEXT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_learning_journal
	FOREIGN KEY (learning_journal_id)
	REFERENCES learning_journal(learning_journal_id)
	ON DELETE CASCADE
);

CREATE TABLE study_plans (
plan_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
student_id INT(11) NOT NULL,
title VARCHAR(255) NOT NULL,
day_of_week VARCHAR(255) NOT NULL,
start_time TIME NOT NULL,
end_time TIME NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_study_plan_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE
);

CREATE TABLE achievements (
achievement_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
student_id INT(11) NOT NULL,
title VARCHAR(255) NOT NULL,
description TEXT NULL,
file_path VARCHAR(255) NOT NULL,
uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_achievement_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE
);

-- drop table achievements;

CREATE TABLE tags (
tag_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
learning_journal_id INT(11) NOT NULL,
teacher_id INT(11) NOT NULL,
student_id INT(11) NOT NULL,
message TEXT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_tag_learning_journal
	FOREIGN KEY (learning_journal_id)
	REFERENCES learning_journal(learning_journal_id)
	ON DELETE CASCADE,
CONSTRAINT fk_tag_teacher
	FOREIGN KEY (teacher_id)
	REFERENCES teachers(teacher_id)
	ON DELETE CASCADE,
CONSTRAINT fk_tag_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE
);

CREATE TABLE tag_replies (
reply_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
tag_id INT(11) NOT NULL,
sender_type VARCHAR(255) NOT NULL,
sender_id INT(11) UNSIGNED NOT NULL,
content TEXT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_replies_tag
	FOREIGN KEY (tag_id)
	REFERENCES tags(tag_id)
	ON DELETE CASCADE
);

-- drop table tag_replies;

CREATE TABLE support_requests (
request_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
student_id INT(11) NOT NULL,
teacher_id INT(11) NOT NULL,
admin_id INT(11) NOT NULL,
message TEXT NOT NULL,
status VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_support_student
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE CASCADE,
CONSTRAINT fk_support_teacher
	FOREIGN KEY (teacher_id)
	REFERENCES teachers(teacher_id)
	ON DELETE CASCADE,
CONSTRAINT fk_support_admin
	FOREIGN KEY (admin_id)
	REFERENCES admins(admin_id)
	ON DELETE CASCADE
);

INSERT INTO students (name, email, password, created_at) 
VALUES 
('To Nga', 'tonga@gmail.com', 'password123', NOW()),
('Van Dat', 'vandat@gmail.com', 'password456', NOW()),
('Phuc Hien', 'phuchien@gmail.com', 'password789', NOW()),
('Xuan Dieu', 'xuandieu@gmail.com', 'password321', NOW()),
('Tien Phat', 'tienphat@gmail.com', 'password654', NOW()),
('Anh Minh', 'anhminh@gmail.com', 'password987', NOW()),
('Kim Ngan', 'kimngan@gmail.com', 'passwordabc', NOW()),
('Duy Khoa', 'duykhoa@gmail.com', 'passworddef', NOW());

INSERT INTO teachers (name, email, password, created_at) 
VALUES 
('Trang Nguyen', 'trangnguyen@gmail.com', 'password101', NOW()),
('Nhan Le', 'nhanle@gmail.com', 'password102', NOW()),
('Uyen Tran', 'uyentran@gmail.com', 'password103', NOW()),
('Long Hai', 'longhai@gmail.com', 'password104', NOW()),
('Mai Do', 'maido@gmail.com', 'password105', NOW());

INSERT INTO admins (name, email, password, created_at) 
VALUES 
('Admin1', 'admin1@example.com', 'adminpass101', NOW()),
('Admin2', 'admin2@example.com', 'adminpass102', NOW()),
('Admin3', 'admin3@example.com', 'adminpass103', NOW()),
('Admin4', 'admin4@example.com', 'adminpass104', NOW()),
('Admin5', 'admin5@example.com', 'adminpass105', NOW());

INSERT INTO subjects (name, description, teacher_id, img, created_at) 
VALUES 
('TOEIC', 'A course focused on TOEIC exam preparation, including listening and reading skills.', 2, 'toeic.png', NOW()),
('Speaking', 'A course designed to improve English speaking and conversational skills.', 1, 'speaking.png', NOW()),
('IT English', 'An English course specialized for the IT field, focusing on vocabulary and communication in tech environments.', 3, 'it_english.png', NOW());

INSERT INTO class_groups (class_name, student_id, created_at) 
VALUES 
('TOEIC 101', 1, NOW()),
('TOEIC 101', 2, NOW()),
('TOEIC 101', 3, NOW()),
('Speaking 101', 4, NOW()),
('Speaking 101', 5, NOW()),
('Speaking 101', 6, NOW()),
('IT English 101', 7, NOW()),
('IT English 101', 8, NOW()),
('IT English 101', 1, NOW());

INSERT INTO student_subject (student_id, subject_id, joined_at, created_at) 
VALUES 
(1, 1, NOW(), NOW()),
(2, 1, NOW(), NOW()),
(3, 1, NOW(), NOW()),
(4, 2, NOW(), NOW()),
(5, 2, NOW(), NOW()),
(6, 2, NOW(), NOW()),
(7, 3, NOW(), NOW()),
(8, 3, NOW(), NOW()),
(1, 3, NOW(), NOW());

INSERT INTO semester_goals (student_id, subject_id, title, semester, description, status, deadline, created_at) 
VALUES 
(1, 1, 'Complete TOEIC Practice Tests', 'Spring 2025', 'Achieve target TOEIC score', 'In Progress', '2025-05-30', NOW()),
(2, 1, 'Finish TOEIC Listening Lessons', 'Spring 2025', 'Improve listening skill for TOEIC', 'In Progress', '2025-05-30', NOW()),
(3, 1, 'Improve Reading Speed', 'Spring 2025', 'Enhance reading comprehension for TOEIC', 'In Progress', '2025-05-30', NOW()),
(4, 2, 'Improve Speaking Fluency', 'Spring 2025', 'Gain confidence in speaking', 'Not Started', '2025-06-15', NOW()),
(5, 2, 'Join English Conversations', 'Spring 2025', 'Practice with peers weekly', 'In Progress', '2025-06-15', NOW()),
(7, 3, 'Master IT Vocabulary', 'Spring 2025', 'Focus on key tech terms', 'In Progress', '2025-06-20', NOW());

INSERT INTO learning_journal (id, semester, week_number, created_at) 
VALUES 
(1, 'Semester 4', 1, NOW()),
(2, 'Semester 4', 2, NOW()),
(3, 'Semester 4', 3, NOW());

INSERT INTO learning_journal_contents (learning_journal_id, isClass, isSelf, content, created_at) 
VALUES 
(1, TRUE, FALSE, 'Practiced listening part 1', NOW()),
(2, TRUE, FALSE, 'Reviewed reading strategies', NOW()),
(3, TRUE, FALSE, 'Completed vocabulary quiz', NOW());

INSERT INTO study_plans (student_id, title, day_of_week, start_time, end_time, created_at) 
VALUES 
(1, 'TOEIC Study Plan', 'Monday', '09:00:00', '11:00:00', NOW()),
(2, 'TOEIC Listening Plan', 'Wednesday', '14:00:00', '16:00:00', NOW()),
(3, 'TOEIC Reading Plan', 'Friday', '10:00:00', '12:00:00', NOW()),
(4, 'Speaking Practice', 'Tuesday', '13:00:00', '14:00:00', NOW()),
(5, 'Group Speaking', 'Thursday', '15:00:00', '16:00:00', NOW());

INSERT INTO achievements (student_id, title, description, file_path, uploaded_at) 
VALUES 
(1, 'TOEIC Mock Test Result', 'Scored 850 in practice test', 'toeic_mock_1.pdf', NOW()),
(2, 'TOEIC Listening Certificate', 'Completed full listening course', 'listening_cert.pdf', NOW()),
(3, 'TOEIC Reading Progress', 'Improved reading score by 100 points', 'reading_progress.pdf', NOW()),
(4, 'Speaking Practice Record', 'Attended 10 speaking sessions', 'speaking_record.pdf', NOW()),
(7, 'Tech Terms Mastery', 'Scored 90% in IT English vocab test', 'it_vocab_test.pdf', NOW());

INSERT INTO tags (learning_journal_id, teacher_id, student_id, message, created_at) 
VALUES 
(1, 2, 1, 'Keep improving your listening skills!', NOW()),
(2, 2, 2, 'Well done on reading practice!', NOW()),
(3, 2, 3, 'Good job with vocabulary tests!', NOW());

-- INSERT INTO tag_replies (tag_id, sender_type, sender_id, content, created_at) 
-- VALUES 
-- (1, 'teacher', 2, 'Thanks! I will continue practicing.', NOW()),
-- (2, 'teacher', 2, 'Glad to see your progress.', NOW()),
-- (3, 'teacher', 2, 'Excellent effort!', NOW());

INSERT INTO support_requests (student_id, teacher_id, admin_id, message, status, created_at) 
VALUES 
(1, 2, 1, 'Need help with TOEIC reading section.', 'Pending', NOW()),
(2, 2, 1, 'Having trouble with listening part 2.', 'Pending', NOW()),
(3, 2, 1, 'Looking for more vocabulary materials.', 'Pending', NOW()),
(4, 1, 2, 'Need feedback on speaking recordings.', 'Pending', NOW()),
(7, 3, 2, 'Requesting more IT reading exercises.', 'Pending', NOW());

