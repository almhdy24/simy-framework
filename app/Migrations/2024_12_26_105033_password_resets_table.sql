-- Migration: password_resets_table
-- Created at: 2024_12_26_105033

-- Write your migration SQL 
-- Create password_resets table
CREATE TABLE password_resets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    token TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP
);