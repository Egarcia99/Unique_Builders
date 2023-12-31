-- Employee Table Creation
prompt ===== Employee Table Creation =====

drop table Employee cascade constraints;
create table Employee (
    EMPL_ID CHAR(6),
    empl_first_name VARCHAR2(30),
    empl_last_name VARCHAR2(30),
    empl_password VARCHAR2(60),
    email VARCHAR2(50),
    phone_number CHAR(12),
    empl_role VARCHAR2(35),
    empl_status VARCHAR2(1) DEFAULT 'T' CHECK (empl_status IN ('T', 'F')),
    empl_hourly_pay_rate REAL DEFAULT 1 NOT NULL,
    first_login VARCHAR2(1) DEFAULT 'Y' CHECK (first_login IN ('Y', 'N')),
    is_temporary VARCHAR2(1) DEFAULT 'N' CHECK (is_temporary IN ('Y', 'N')),
    PRIMARY KEY (EMPL_ID)
);

/*-- Address Table Creation
prompt ===== Address Table Creation =====

drop table Address cascade constraints;
create table Address (
    ADDRESS_ID CHAR(6),
    street VARCHAR2(50),
    unit_number VARCHAR2(10),
    city VARCHAR2(50),
    state VARCHAR2(30),
    zipcode CHAR(5),
    PRIMARY KEY (ADDRESS_ID)
);
*/
-- Work Order Table Creation
prompt ===== Work Order Table Creation =====

drop table Work_Order cascade constraints;
create table Work_Order (
    WORKORDER_ID CHAR(7),
    work_address VARCHAR2(255),
    empl_id CHAR(6),
    job_type VARCHAR2(30),
    call_date DATE,
    ext_company_name VARCHAR2(50),
    property_name VARCHAR2(50),
    invoice_estimate REAL,
    invoice_amount REAL,
    job_description VARCHAR2(500),
    current_status VARCHAR(150) DEFAULT 'In Progress',
    PRIMARY KEY (WORKORDER_ID),
    FOREIGN KEY (empl_id) REFERENCES Employee(empl_id)
);

-- Payroll Table Creation
prompt ===== Payroll Table Creation =====

drop table Payroll cascade constraints;
create table Payroll (
    PAYROLL_ID CHAR(6),
    EMPL_ID CHAR(6),
    pay_week DATE,
    hours_worked INTEGER,
    deductions REAL,
    extra_amount REAL,
    total_weekly_amount REAL DEFAULT 1 NOT NULL,
    payment_type VARCHAR2(1) CHECK (payment_type IN ('T', 'F')),
    PRIMARY KEY (PAYROLL_ID, EMPL_ID),
    FOREIGN KEY (EMPL_ID) REFERENCES Employee(EMPL_ID)
);

-- Customer Table Creation
prompt ===== Customer Table Creation =====

drop table Customer cascade constraints;
create table Customer (
    CUST_ID CHAR(6),
    cust_first_name VARCHAR2(50),
    cust_last_name VARCHAR2(50),
    email VARCHAR2(50),
    phone_number CHAR(12),
    job_inquiry CLOB,
    PRIMARY KEY (CUST_ID)
);
-- UserLockout Table Creation
prompt ===== UserLockout Table Creation =====

drop table UserLockout cascade constraints;
create table UserLockout (
    lockout_id NUMBER,
    username CHAR(6) NOT NULL,
    lockout_time TIMESTAMP,
    unlock_time TIMESTAMP,
    failed_attempts NUMBER NOT NULL,
    PRIMARY KEY (lockout_id),
    FOREIGN KEY (username) REFERENCES Employee(EMPL_ID)
);

-- Create sequence for lockout_id
DROP SEQUENCE lockout_id_seq;
create sequence lockout_id_seq start with 1 increment by 1;

-- Trigger to populate lockout_id using the sequence

CREATE OR REPLACE TRIGGER userlockout_trigger
BEFORE INSERT ON UserLockout
FOR EACH ROW
BEGIN
    :NEW.lockout_id := lockout_id_seq.NEXTVAL;
END;
/
CREATE OR REPLACE TRIGGER update_unlock_time_trigger
BEFORE UPDATE OF lockout_time ON UserLockout
FOR EACH ROW
BEGIN
    :NEW.unlock_time := :NEW.lockout_time + INTERVAL '24' HOUR;
END;
/
COMMIT;