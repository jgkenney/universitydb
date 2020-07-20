-- echo 'hi professor'

USE universitydb;

-- a)
SELECT budget AS 'old_budget' FROM department WHERE dept_name="Psychology";
UPDATE department SET budget = budget*1.05 WHERE dept_name = 'Psychology';
-- b)
SELECT budget AS 'new_budget' FROM department WHERE dept_name="Psychology";
-- c)
SELECT name, salary FROM instructor WHERE dept_name="Psychology";
-- d)
SELECT name, tot_cred FROM student; 



