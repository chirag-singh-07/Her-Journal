-- Migration script to add media support to journal_entries table
-- Run this if you already have the database created

USE her_journal;

ALTER TABLE journal_entries 
ADD COLUMN attachment_path VARCHAR(255) DEFAULT NULL AFTER lock_password,
ADD COLUMN attachment_type VARCHAR(50) DEFAULT NULL AFTER attachment_path;
