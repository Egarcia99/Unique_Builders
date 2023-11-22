CREATE OR REPLACE FUNCTION generate_random_password(p_empl_id IN CHAR) RETURN VARCHAR2 IS
    v_password VARCHAR2(20); -- You can adjust the length of the password as needed
BEGIN
    -- Generate a random password (you may want to implement a more sophisticated logic)
    v_password := DBMS_RANDOM.STRING('A', 10) || DBMS_RANDOM.STRING('X', 5);

    -- Update the Employee table with the new password for the specified employee
    UPDATE Employee
    SET empl_password = v_password
    WHERE EMPL_ID = p_empl_id;


    -- Return the generated password
    RETURN v_password;
END generate_random_password;
/
show errors