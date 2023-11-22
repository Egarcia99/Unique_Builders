-- Enable output in SQL*Plus
SET SERVEROUTPUT ON;

-- Declare variables to store the generated password and empl_id
var temp_pass VARCHAR2(20);
var empl_id NUMBER;

-- Prompt the user to enter a value for empl_id
ACCEPT empl_id PROMPT 'Enter employee ID: '


-- Execute the generate_random_password function using the user input and store the result in the temp_pass variable
var temp_pass VARCHAR2(20);
exec :temp_pass := generate_random_password('empl_id') 
-- Print the generated password and empl_id
commit;
print temp_pass

