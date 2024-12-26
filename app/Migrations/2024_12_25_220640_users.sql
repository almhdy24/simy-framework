-- Migration: users
-- Created at: 2024_12_25_220640

-- Write your migration SQL here
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,         -- Unique identifier
    username TEXT NOT NULL UNIQUE,                -- Unique username
    email TEXT NOT NULL UNIQUE,                   -- Unique email address
    password_hash TEXT NOT NULL,                  -- Hashed password
    first_name TEXT,                              -- User's first name
    last_name TEXT,                               -- User's last name
    bio TEXT,                                     -- User bio
    profile_picture TEXT,                          -- Profile picture URL
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Account creation time
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Last update time
    status TEXT CHECK(status IN ('active', 'inactive', 'banned')) DEFAULT 'active', -- Account status
    last_login DATETIME                            -- Last login timestamp
);