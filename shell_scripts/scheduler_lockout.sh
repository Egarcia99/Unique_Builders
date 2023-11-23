#!/bin/bash

# file: scheduler_lockout.sh
# by: Gracie Ceja
# last modified: November 22, 2023
# this file automatically unlocks user accounts, if their lockout time has run out
# it should run every hour, using crontab on nrs-projects (or a sql job on the database for our project)
#
# CS 458 Software Engineering
# Semester Project: Unique Builders Company Website & Database
# Team: Tech Titans
# Fall 2023
#
# this is how to make it run hourly with crontab:
# at the command prompt, enter EDITOR=nano crontab -e, then put the following line in the file (without the #):
# 0 * * * * ~/public_html/cs458/Unique_Builders-main/shell_scripts/scheduler_lockout.sh
# then save and exit. it will be automatically added to your personal cron file



# Set Oracle environment variables
export ORACLE_HOME=/usr/lib/oracle/12.1/client64
export LD_LIBRARY_PATH=/usr/lib/oracle/12.1/client64/lib:$LD_LIBRARY_PATH
export PATH=$ORACLE_HOME/bin:$PATH

# Database connection details
DB_CONN_STR="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = cedar.humboldt.edu) (PORT = 1521)) (CONNECT_DATA = (SID = STUDENT)))"

# Source the configuration file (with your username, password, & database name (STUDENT.HUMBOLDT.EDU))
source  ~/private/config.conf

# Run SQL*Plus command to unlock user accounts
echo "BEGIN unlock_users_proc; END;
/" | /usr/lib/oracle/12.1/client64/bin/sqlplus $username/$password@$database