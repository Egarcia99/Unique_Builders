-- This procedure is used to unlock users who have been locked out of their account
CREATE OR REPLACE PROCEDURE unlock_users_proc AS
BEGIN
    UPDATE UserLockout 
    SET unlock_time = NULL, failed_attempts = NULL 
    WHERE unlock_time IS NOT NULL AND unlock_time <= CURRENT_TIMESTAMP;
END unlock_users_proc;
/