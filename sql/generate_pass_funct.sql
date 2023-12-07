/*
    function generate_random_password 
    create a random 12 character password to assign the empl_id that call this function
    
*/
CREATE OR REPLACE FUNCTION generate_random_password(p_empl_id IN CHAR) RETURN VARCHAR2 IS
    v_password VARCHAR2(20); -- Adjust the length of the password as needed
    v_exists NUMBER;
BEGIN
    -- Validate input
    IF p_empl_id IS NULL THEN
        RAISE_APPLICATION_ERROR(-20001, 'Employee ID cannot be NULL');
    END IF;

    -- Check if the employee ID exists
    SELECT COUNT(*) INTO v_exists FROM Employee WHERE EMPL_ID = p_empl_id;
    IF v_exists = 0 THEN
        RAISE_APPLICATION_ERROR(-20002, 'Employee ID does not exist');
    END IF;

    -- Generate a more secure random password
    v_password := DBMS_RANDOM.STRING('X', 4) ||
                  DBMS_RANDOM.STRING('A', 6) ||
                  DBMS_RANDOM.STRING('N', 5);

    -- Update the Employee table with the new password for the specified employee
    UPDATE Employee
    SET empl_password = v_password
    WHERE EMPL_ID = p_empl_id;
    commit;
    -- Return the generated password
    RETURN v_password;
EXCEPTION
    WHEN OTHERS THEN
        -- Handle exceptions (you can log or re-raise the exception as needed)
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
        RETURN NULL; -- Or handle the error in an appropriate way for your application
END generate_random_password;
/
show errors