<?php

namespace Almhdy\Simy\Core\Files;

use Exception;

class Files
{
    /**
     * Read a file
     *
     * @param string $filename
     * @return string|false
     * @throws Exception
     */
    public static function read(string $filename): string|false
    {
        if (is_readable($filename)) {
            return file_get_contents($filename);
        } else {
            throw new Exception("Could not read the file. Check file permissions.");
        }
    }

    /**
     * Write to a file
     *
     * @param string $filename
     * @param string $data
     * @return int|false
     * @throws Exception
     */
    public static function write(string $filename, string $data): int|false
    {
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (is_writable($dir)) {
            return file_put_contents($filename, $data);
        } else {
            throw new Exception("Could not write to the file. Check file permissions.");
        }
    }

    /**
     * Check if a file exists
     *
     * @param string $filename
     * @return bool
     */
    public static function exists(string $filename): bool
    {
        return file_exists($filename);
    }

    /**
     * Delete a file
     *
     * @param string $filename
     * @return bool
     * @throws Exception
     */
    public static function delete(string $filename): bool
    {
        if (is_writable($filename)) {
            return unlink($filename);
        } else {
            throw new Exception("Could not delete the file. Check file permissions.");
        }
    }

    /**
     * Get the file size
     *
     * @param string $filename
     * @return int
     * @throws Exception
     */
    public static function size(string $filename): int
    {
        if (self::exists($filename)) {
            return filesize($filename);
        } else {
            throw new Exception("File does not exist.");
        }
    }

    /**
     * Get the last modified time of a file
     *
     * @param string $filename
     * @return int
     * @throws Exception
     */
    public static function lastModified(string $filename): int
    {
        if (self::exists($filename)) {
            return filemtime($filename);
        } else {
            throw new Exception("File does not exist.");
        }
    }

    /**
     * Upload a file with additional features
     *
     * @param array $file
     * @param string $destination
     * @param int $maxFileSize
     * @param array $allowedFileTypes
     * @return string|false
     * @throws Exception
     */
    public static function upload(
        array $file,
        string $destination,
        int $maxFileSize = 5242880, // 5MB
        array $allowedFileTypes = []
    ): string|false {
        if (!is_uploaded_file($file['tmp_name'])) {
            throw new Exception("Invalid file upload.");
        }

        // Check file size
        if ($file['size'] > $maxFileSize) {
            throw new Exception("File size exceeds the maximum limit.");
        }

        // Check file type
        if (!empty($allowedFileTypes)) {
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedFileTypes)) {
                throw new Exception(
                    "Invalid file type. Allowed types are: " . implode(", ", $allowedFileTypes)
                );
            }
        }

        // Generate a unique filename to prevent overwriting existing files
        $newFilename = uniqid() . "_" . basename($file['name']);
        $newDestination = rtrim($destination, '/') . '/' . $newFilename;

        // Move the uploaded file to the new destination
        if (move_uploaded_file($file['tmp_name'], $newDestination)) {
            return $newFilename;
        } else {
            throw new Exception("Failed to move the uploaded file.");
        }
    }

    /**
     * Create a directory
     *
     * @param string $dir
     * @param int $permissions
     * @return bool
     * @throws Exception
     */
    public static function createDir(string $dir, int $permissions = 0777): bool
    {
        if (!is_dir($dir)) {
            return mkdir($dir, $permissions, true);
        } else {
            throw new Exception("Directory already exists.");
        }
    }

    /**
     * Delete a directory and its contents
     *
     * @param string $dir
     * @return bool
     * @throws Exception
     */
    public static function deleteDir(string $dir): bool
    {
        if (!is_dir($dir)) {
            throw new Exception("Directory does not exist.");
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = "$dir/$file";
            is_dir($path) ? self::deleteDir($path) : unlink($path);
        }
        return rmdir($dir);
    }

    /**
     * List files in a directory
     *
     * @param string $dir
     * @return array
     * @throws Exception
     */
    public static function listFiles(string $dir): array
    {
        if (!is_dir($dir)) {
            throw new Exception("Directory does not exist.");
        }

        return array_diff(scandir($dir), ['.', '..']);
    }
}