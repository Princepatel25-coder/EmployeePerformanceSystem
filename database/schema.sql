-- Create table for Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for Goals
CREATE TABLE IF NOT EXISTS goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for Reviews
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    reviewer_id INT NOT NULL,
    review_date DATE NOT NULL,
    performance_score INT,
    feedback TEXT,
    FOREIGN KEY (employee_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for Reports
CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample users
INSERT INTO users (username, password, email) VALUES
('john_doe', 'hashed_password_1', 'john.doe@example.com'),
('jane_smith', 'hashed_password_2', 'jane.smith@example.com'),
('manager_bob', 'hashed_password_3', 'bob.manager@example.com');

-- Insert sample goals
INSERT INTO goals (name, description, due_date) VALUES
('Increase Sales by 20%', 'Aim to increase sales by 20% in Q1 by adopting new marketing strategies.', '2024-03-31'),
('Improve Customer Support', 'Improve response time for customer support by training staff and improving the helpdesk system.', '2024-04-30'),
('Reduce Operational Costs', 'Focus on reducing operational costs by identifying inefficiencies in the supply chain.', '2024-06-30');

-- Insert sample reviews
INSERT INTO reviews (employee_id, reviewer_id, review_date, performance_score, feedback) VALUES
(1, 3, '2024-02-15', 85, 'John has shown consistent improvement in his tasks but needs to focus more on meeting deadlines.'),
(2, 3, '2024-03-05', 90, 'Jane has exceeded expectations in customer service and project management.'),
(1, 3, '2024-04-25', 78, 'John needs to work on time management but overall is improving.');

-- Insert sample reports
INSERT INTO reports (title, description, created_at) VALUES
('Q1 Performance Overview', 'This report provides an analysis of employee performance for the first quarter of 2024, focusing on overall department productivity and individual goal achievements.', '2024-03-31 14:45:00'),
('Employee Satisfaction Survey Results', 'An analysis of the Employee Satisfaction Survey conducted in April 2024. The report includes satisfaction rates, key areas of concern, and actionable insights for improvements.', '2024-04-20 09:15:00'),
('Departmental Goals Progress', 'This report outlines the progress of departmental goals for the marketing and sales teams, including key performance indicators and areas requiring attention.', '2024-05-15 11:30:00'),
('Mid-Year Performance Review', 'This report summarizes the mid-year performance of all employees, highlighting top performers, areas for improvement, and projected outcomes for the remainder of the year.', '2024-06-30 16:00:00'),
('Employee Training & Development Overview', 'A detailed report on the training programs conducted between Q1 and Q2 of 2024, including employee feedback, skills improved, and areas needing additional focus.', '2024-07-10 10:00:00'),
('Annual Performance Report', 'This comprehensive report details the overall performance of the company for the year 2023, analyzing productivity, revenue growth, and individual employee contributions.', '2024-01-15 13:45:00'),
('Sales Team Performance Analysis', 'A breakdown of the performance of the sales team in Q2 of 2024, including sales figures, client acquisition rates, and a comparison with Q1 performance.', '2024-07-25 15:00:00'),
('Leadership Feedback Summary', 'This report consolidates feedback from leadership across various departments regarding the effectiveness of leadership styles and their impact on team performance.', '2024-08-05 09:30:00'),
('Project Completion & Deadlines Review', 'An analysis of all projects completed in Q3 of 2024, reviewing completion rates, adherence to deadlines, and reasons for project delays.', '2024-09-20 12:00:00'),
('End-of-Year Bonus Evaluation', 'An evaluation of employee eligibility for end-of-year bonuses based on performance metrics, goal achievements, and overall contributions to the organization.', '2024-11-30 11:15:00');

