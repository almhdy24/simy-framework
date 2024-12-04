<?php
namespace Almhdy\Simy\Core\Files;

class Files
{

  // Function to read a file
  public static function read(string $filename): string|false
  {
    if (is_readable($filename)) {
      return file_get_contents($filename);
    } else {
      throw new \Exception("Could not read the file. Check file permissions.");
    }
  }

  // Function to write to a file
  public static function write(string $filename, string $data): int|false
  {
    if (is_writable($filename)) {
      return file_put_contents($filename, $data);
    } else {
      throw new \Exception(
        "Could not write to the file. Check file permissions."
      );
    }
  }

  // Function to check if a file exists
  public static function exists(string $filename): bool
  {
    return file_exists($filename);
  }

  // Function to delete a file
  public static function delete(string $filename): bool
  {
    if (is_writable($filename)) {
      return unlink($filename);
    } else {
      throw new \Exception(
        "Could not delete the file. Check file permissions."
      );
    }
  }

  // Function to get the file size
  public static function size(string $filename): int
  {
    if (self::exists($filename)) {
      return filesize($filename);
    } else {
      throw new \Exception("File does not exist.");
    }
  }

  // Function to get the last modified time of a file
  public static function lastModified(string $filename): int
  {
    if (self::exists($filename)) {
      return filemtime($filename);
    } else {
      throw new \Exception("File does not exist.");
    }
  }

  // Function to upload a file with additional features
  public static function upload(
    string $source,
    string $destination = null,
    int $maxFileSize = 5242880, // 5mb
    array $allowedFileTypes = []
  ): string|false {
    if (!is_uploaded_file($source)) {
      throw new \Exception("Invalid file upload.");
    }

    // Check file size
    if ($_FILES["file"]["size"] > $maxFileSize) {
      throw new \Exception("File size exceeds the maximum limit.");
    }

    // Check file type
    if (!empty($allowedFileTypes)) {
      $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
      if (!in_array(strtolower($fileExtension), $allowedFileTypes)) {
        throw new \Exception(
          "Invalid file type. Allowed types are: " .
            implode(", ", $allowedFileTypes)
        );
      }
    }

    // Generate a unique filename to prevent overwriting existing files
    $newFilename = uniqid() . "_" . $_FILES["file"]["name"];
    $newDestination = $destination . "/" . $newFilename;

    // Move the uploaded file to the new destination
    if (move_uploaded_file($source, $newDestination)) {
      return $newFilename;
    } else {
      throw new \Exception("Failed to move the uploaded file.");
    }
  }
}
