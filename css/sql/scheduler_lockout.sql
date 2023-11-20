BEGIN
    DBMS_SCHEDULER.create_job (
        job_name        => 'UNLOCK_USERS_JOB',
        job_type        => 'PLSQL_BLOCK',
        job_action      => 'BEGIN unlock_users_proc; END;',
        start_date      => SYSTIMESTAMP,
        repeat_interval => 'FREQ=HOURLY; BYMINUTE=0', -- Run every hour
        enabled         => TRUE
    );
END;
/