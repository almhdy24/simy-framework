# Lightweight PHP Framework for Modern Web Development

This repository contains a lightweight PHP framework designed for modern web development. The framework is built with simplicity, speed, and flexibility in mind, providing developers with a solid foundation to create web applications efficiently.

## Features
- **Modern PHP**: Utilizes the latest PHP features and best practices.
- **MVC Architecture**: Follows the Model-View-Controller architectural pattern for organized code structure.
- **Routing**: Simple and customizable routing system for handling HTTP requests.
- **Database Support**: Built-in support for connecting to various databases.
- **Template Engine**: Allows for easy integration of templates for frontend development.
- **Error Handling**: Comprehensive error handling to facilitate debugging.
- **Security**: Implements measures to enhance the security of web applications.
- **Middleware**: Supports middleware for easily adding additional layers to request/response handling.
- **Composer Ready**: Easily install dependencies using Composer.

## Getting Started
To get started with using the framework, follow these steps:
1. Clone the repository:  
   ```bash
   git clone https://github.com/almhdy24/simy-framework
   ```
2. Install dependencies using Composer:  
   ```bash
   composer install
   ```
3. Configure your web server to point to the `public` directory.
4. Start building your web application by creating controllers, models, and views in the appropriate directories.

## Usage
Below is a basic example of how to create a simple route in the framework:

// Example of handling a GET request
$router->get("/users", function () {
    echo "Displaying all users";
});

// Example of handling a POST request
$router->post("/users", function () {
    echo "Creating a new user";
});

// Example of handling a PUT request with a route parameter
$router->put("/users/{id}", function ($id) {
    echo "Updating user with ID: " . $id;
});

// Example of handling a DELETE request with multiple route parameters
$router->delete("/users/{id}/posts/{postId}", function ($id, $postId) {
    echo "Deleting post with ID $postId for user with ID $id";
});
## How can I integrate a third-party library into the framework using Composer?
To integrate a third-party library into your PHP framework using Composer, follow these steps:

1. Identify the Library:
   - Find the third-party library you want to integrate into your project on [Packagist](https://packagist.org/) or the library's official website.
   
2. Require the Library:
   - In your project directory, open the terminal and run the following Composer command to require the library:
     ```bash
     composer require vendor/package-name
     ```
     Replace `vendor/package-name` with the actual vendor and package name of the library you want to install.

3. Autoloading:
   - Composer will automatically download the library and add it to your `vendor` directory. The next step is to autoload the library by including Composer's autoloader in your project:
     ```php
     require 'vendor/autoload.php';
     ```

4. Use the Library:
   - You can now start using functions, classes, and methods provided by the third-party library in your PHP framework.

5. Update Composer:
   - To ensure that your `composer.json` and `composer.lock` files are updated with the new library dependency, run:
     ```bash
     composer update
     ```

6. Check for Compatibility:
   - Verify that the library you've integrated is compatible with your PHP framework version and does not conflict with any existing dependencies.

By following these steps, you can easily integrate third-party libraries into your lightweight PHP framework using Composer, expanding the functionality and capabilities of your project.
## Contributing
Contributions are welcome! If you'd like to contribute to the framework, please follow these guidelines:
- Fork the repository
- Create a new branch for your feature or bug fix
- Make your changes
- Write tests for your code
- Submit a pull request

## Support
If you encounter any issues or have questions about the framework, please [open an issue](https://github.com/almhdy24/simy-framework/issues) on GitHub.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

Thank you for checking out the Lightweight PHP Framework for Modern Web Development! Happy coding! 🚀