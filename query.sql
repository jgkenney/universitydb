USE universitydb;
SELECT * FROM department;
UPDATE department SET budget = budget*1.05 where dept_name = 'Psychology';
SELECT * FROM department;