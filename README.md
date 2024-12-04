# Simy Framework

**Lightweight PHP Framework for Modern Web Development**

Welcome to Simy Framework! Simy is a powerful and lightweight PHP framework designed to facilitate modern web development using the Model-View-Controller (MVC) architecture. With Simy, you can build robust, scalable web applications quickly and efficiently.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Getting Started](#getting-started)
- [Documentation](#documentation)
- [License](#license)

## Features

- **MVC Architecture**: Clear separation of concerns for improved organization and manageability of code.
- **Routing System**: Simple and elegant routing to connect URLs to the corresponding controllers and actions.
- **Database Abstraction**: Unified interface to interact with various database systems seamlessly.
- **Template Engine**: Lightweight templating system for rendering views, promoting separation of business logic and presentation.

## Installation

To install Simy Framework, follow these steps:

1. **Create a New Project**:
   ```bash
   composer create-project almhdy/simy-framework app-name
   ```

2. **Navigate to the Project Directory**:
   ```bash
   cd app-name
   ```

3. **Install Dependencies**:
   Use Composer to install the required dependencies:
   ```bash
   composer install
   ```

4. **Configure Your Application**:
   Modify the configuration settings located in the `app/.env` file to set up your environment (database details, app settings, etc.).
## Getting Started

To create your first application with Simy Framework:

1. **Create a New Controller**:
   Create a new PHP file in the `app/controllers/` directory.

2. **Define Routes**:
   Open the `routes/Routes.php` file and define your application routes.

3. **Build Your Views**:
   Create views within the `app/views/` directory using the templating system provided.

 **Run Your Application**:
   Start a local PHP server:
   ```bash
   php simy serve
   ```
   Visit `http://localhost:8000` in your browser to see your application in action.
   
## Documentation

For detailed documentation, examples, and guides, visit our official documentation site:

[Simy Framework Documentation](https://www.simy-framework.com/docs)

## License

Simy Framework is open source and available under the LGPL-3.0-or-later License. See the [LICENSE](LICENSE) file for more information.
