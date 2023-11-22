--- Enable output in SQL*Plus
SET SERVEROUTPUT ON;

-- Declare variables to store the generated password and empl_id
var temp_pass VARCHAR2(20);
var empl_id CHAR(6);

-- Prompt the user to enter a value for empl_id
ACCEPT empl_id PROMPT 'Enter employee ID: '


-- Execute the generate_random_password function using the user input and store the result in the temp_pass variable
BEGIN
    :temp_pass := generate_random_password('&empl_id');
END;
/

-- Print the generated password and empl_id
PRINT 'Generated Password: ' || temp_pass;

