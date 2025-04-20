
Built by https://www.blackbox.ai

---

```markdown
# Photo Upload and Display Application

## Project Overview

This is a simple web application for uploading and displaying photos using PHP and SQLite. Users can select images to upload, which are then stored on the server and referenced in a SQLite database. The app supports JPG, PNG, and GIF image formats and provides a user-friendly interface for both uploading and viewing images.

## Installation

To set up this project on your local environment, follow these steps:

1. **Clone the repository (if applicable):**
   ```bash
   git clone <repository-url>
   ```

2. **Navigate to the project directory:**
   ```bash
   cd <project-directory>
   ```

3. **Ensure that you have PHP and SQLite installed on your server.**
   - You can use a local server such as XAMPP, WAMP, or MAMP.
   - Ensure the `uploads` directory can be created and that the server has write permissions.

4. **Run the application:**
   - Place your project files in the web server's document root (e.g., `htdocs` for XAMPP).
   - Access the application via your web browser at `http://localhost/<project-directory>/index.php`.

## Usage

1. **Upload a Photo:**
   - Select an image file to upload (JPG, PNG, or GIF).
   - Click on the "Subir Foto" button to upload the image.

2. **Display Uploaded Photos:**
   - Click on the "Mostrar Fotos" button to view the uploaded images.
   - If there are no photos uploaded, a message will be displayed indicating that no photos are available.

## Features

- User-friendly interface for uploading images.
- Support for multiple image formats: JPG, PNG, and GIF.
- Database storage of uploaded photo filenames.
- Display of uploaded images in a grid layout.
- Error handling for file uploads.

## Dependencies

This project does not have external dependencies listed in a package.json file, as it is a PHP application. However, ensure your server environment supports:
- PHP (version 7.0 or higher recommended)
- SQLite (built-in support)

## Project Structure

```
/<project-directory>
│
├── index.php         # Main application file handling uploads and display
└── uploads/          # Directory where uploaded photos are stored
```

* The `uploads/` directory is created automatically if it doesn't already exist.
* A SQLite database (`photos.db`) is generated to store information about uploaded photos.

## Contributing

Contributions to enhance the project or improve functionality are welcome. Please feel free to submit issues and pull requests.

## License

This project is open-source and available under the [MIT License](LICENSE).
```