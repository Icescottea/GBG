# GasByGas - Integrated LPG Distribution Management System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Android](https://img.shields.io/badge/Android-3DDC84?style=for-the-badge&logo=android&logoColor=white)

## 📖 Abstract

GasByGas is a nationwide LP gas distribution network in Sri Lanka. This project is an integrated online system designed to modernize and streamline its gas request and delivery operations. The system provides web and mobile interfaces for both domestic and industrial customers to request gas cylinders, enabling GasByGas to optimize stock management and monitor deliveries efficiently.

By generating and validating unique request tokens, sending real-time email notifications, and enforcing identity-based constraints, the system ensures equitable distribution and prevents fraud. It offers dedicated portals for outlet managers and head office staff to oversee the entire distribution lifecycle, from stock management to performance analytics.

## ✨ Key Features

*   **Multi-Platform Customer Portal:** Web and mobile interfaces (via Android WebView) for customers to submit and track gas requests.
*   **Token Management System:** Generates and validates unique tokens for each gas request to ensure order and prevent duplication.
*   **Real-Time Notifications:** Integrated email system (via Mailtrap) for notifications on empty cylinder handover, token reallocation, and stock replenishment.
*   **Equitable Distribution Controls:** Identity-based constraints to restrict users to a single active request and block duplicate accounts.
*   **Outlet Management Console:** For outlet managers to verify tokens, manage local stock levels, and process cylinder handovers.
*   **Head Office Dashboard:** Provides oversight of national distribution schedules, outlet performance tracking, and analytics using Chart.js visualizations.
*   **Robust Security:** Implements Laravel authentication, middleware, CSRF protection, and input validation.

## 🛠️ Technology Stack

### Backend
*   **Framework:** Laravel (PHP)
*   **Authentication:** Laravel Sanctum/Auth
*   **Routing & MVC:** Laravel

### Frontend
*   **Templating:** Laravel Blade
*   **Styling:** HTML, CSS, Bootstrap
*   **Interactivity:** JavaScript

### Database
*   **DBMS:** MySQL

### Mobile
*   **Platform:** Android (Java/Kotlin)
*   **Integration:** Android Studio WebView

### Development & Operations Tools
*   **Email Testing:** Mailtrap
*   **Local Tunneling:** Ngrok (for mobile testing)
*   **Version Control:** Git, GitHub
*   **Dependency Management:** Composer (PHP), NPM (JavaScript)
*   **Data Visualization:** Chart.js

## 🚀 Installation & Setup

Follow these steps to set up the project locally for development and testing.

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/[your-username]/gasbygas.git
    cd gasbygas
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install NPM Dependencies**
    ```bash
    npm install
    ```

4.  **Environment Configuration**
    ```bash
    cp .env.example .env
    ```
    Generate an application key:
    ```bash
    php artisan key:generate
    ```
    Edit the `.env` file with your database credentials, Mailtrap settings, and other environment variables.

5.  **Database Setup**
    ```bash
    php artisan migrate
    php artisan db:seed # (If seeded data is available)
    ```

6.  **Run The Application**
    Start the Laravel development server:
    ```bash
    php artisan serve
    ```
    Compile frontend assets (in a separate terminal):
    ```bash
    npm run dev
    ```
    The web application will be available at `http://localhost:8000`.

### Mobile App Setup
1.  Open the `android/` project folder in Android Studio.
2.  Sync the project with Gradle files.
3.  Ensure the Laravel backend server is running and accessible (use Ngrok to generate a public URL if testing on a physical device).
4.  Update the `WebView` URL in the Android code to point to your server.
5.  Build and run the application on an emulator or device.

## 📋 System Workflow

1.  **Customer Registration/Login:** Users create an account, which is validated to prevent duplicates.
2.  **Gas Request:** A logged-in customer submits a request for a gas cylinder.
3.  **Token Generation:** The system generates a unique token for the request and confirms it via email.
4.  **Outlet Processing:** The customer presents the token at the outlet. The outlet manager verifies the token and processes the cylinder handover.
5.  **Stock Update & Notification:** The system updates the outlet's stock levels and triggers notifications for low stock or request fulfillment.
6.  **Oversight & Analytics:** Head office staff use the dashboard to monitor overall distribution, track outlet performance, and view analytics.

## 🔐 Security Features

*   Laravel's built-in authentication and hashing for passwords.
*   CSRF protection on all forms.
*   Middleware for route protection (e.g., `auth`, `admin`).
*   Input validation and sanitization to prevent XSS and SQL injection.
*   Identity constraints to ensure one active request per user.

## 📧 API & Integrations

*   **Mailtrap API** is integrated for handling all transactional emails (notifications, alerts).
*   The backend exposes a RESTful API (using Laravel) that is consumed by both the web frontend and the mobile WebView application.

## 📊 Data Visualization

Performance and stock metrics are visualized for head office staff using **Chart.js**, providing insights into distribution patterns and outlet efficiency.

## 👥 Default User Roles

1.  **Customer:** Can place gas requests, view their request status, and receive notifications.
2.  **Outlet Manager:** Can verify tokens, manage local stock, and view outlet-specific requests.
3.  **Head Office Admin:** Has full system oversight, can view distribution schedules, analytics, and track all outlet performances.

## 📝 License

This project is proprietary and developed for GasByGas, Sri Lanka.

## 👨‍💻‍ Development Team

*   [Your Name/Team Name]
*   [Contact Information]