# 🌐 Multi-User Application Management Portal

A role-based **Application and Registration Management System** that allows users, subadmins, and a super admin to manage 25+ registration services, track application statuses, upload/download certificates, and handle job openings — all from one secure and easy-to-use web portal.

---

## 📚 Table of Contents
- [📘 Overview](#-overview)
- [👥 User Roles & Functionalities](#-user-roles--functionalities)
  - [👤 User Functionalities](#-1-user-functionalities)
  - [🧑‍💼 Subadmin Functionalities](#-2-subadmin-functionalities)
  - [🧑‍💻 Super Admin Functionalities](#-3-super-admin-functionalities)
- [✉️ Email Functionality](#️-email-functionality)
- [🌟 Key Features Summary](#-key-features-summary)
- [🏗️ Technical Notes](#️-technical-notes)
- [🛡️ Security & Privacy](#️-security--privacy)
- [🧑‍💻 Developer Info](#-developer-info)
- [📁 Project Directory Structure](#-project-directory-structure)
- [⚙️ Installation & Setup](#-installation--setup)
- [⚠️ Important Note](#-important-note)

---

## 📘 Overview

This project is a **web-based application portal** with a **multi-role system** consisting of:
- 🧍‍♂️ **User**
- 🧑‍💼 **Subadmin**
- 👑 **Super Admin**

It streamlines online registrations, document handling, application tracking, and certificate downloads, offering over **25+ services**.  
Every user interaction — from password resets to job applications — is supported by a robust **email notification system** (live version only).

> ⚠️ **Important:** The SQL file and SMTP credentials have been intentionally excluded for security reasons.  
> For database structure access, contact the developer at **[peeyushpandey735@gmail.com](mailto:peeyushpandey735@gmail.com)**.

---

## 👥 User Roles & Functionalities

### 👤 1. User Functionalities

| Feature | Description |
|----------|--------------|
| **Registration & Login** | New users can register and access their dashboards securely. |
| **Dashboard Overview** | Displays all applications with detailed info and live status updates. |
| **Certificate Download** | Users can download certificates uploaded by admins/subadmins. |
| **Documents & Certificates Page** | Categorized section for completed registrations and documents. |
| **Profile Management** | Users can freely update their personal details. |
| **Forgot Password** | Password reset via email link (live feature — credentials removed). |
| **Access to All Services** | 25+ registration/service forms accessible once logged in. |
| **Track Application Status (Public)** | Check application progress using User ID without logging in. Supports filtering by service and certificate download when complete. |

💡 *The “Track Application” feature improves user experience — no need for constant login to check updates.*

---

### 🧑‍💼 2. Subadmin Functionalities

| Feature | Description |
|----------|--------------|
| **Dedicated Login** | Subadmins access via a separate secure login portal. |
| **Assigned Forms Access** | Admin assigns specific services/forms (e.g., GST, MSME). |
| **Application Updates** | Subadmins can update application statuses, add remarks, and upload documents/certificates for users. |
| **Profile Management** | Can update personal info and reset passwords. |

---

### 🧑‍💻 3. Super Admin Functionalities

| Feature | Description |
|----------|--------------|
| **Complete Access** | View and manage all users and subadmins. |
| **User to Subadmin Conversion** | Promote users and assign services. |
| **Service & Category Management (CRUD)** | Create, update, and delete services and navigation categories. |
| **Dynamic Form Builder (CRUD)** | Modify form fields, input types, and requirements dynamically. |
| **Enquiry Management** | Handle *Contact* and *Callback* enquiries from different pages. |
| **Blog Management** | Create, update, or delete blogs easily. |
| **Page Management** | Manage static content like Terms, Privacy Policy, etc. |
| **Site-Wide Social Links** | Update social handles (FB, Insta, YouTube, etc.) — reflected across all pages. |
| **Navigation Builder** | Create hierarchical menus and submenus like:  
  `Registrations → Company Registrations → One Person Company Registration` |
| **Job Openings Management** | Create job listings for `careers.php`. Applicants get instant email confirmation. |

---

## ✉️ Email Functionality

All key events trigger email notifications *(available in live version)*:
- 🔑 Password reset links  
- 💼 Job application acknowledgements  
- 📄 Application and certificate updates  

> 🚫 *Disabled in shared source due to credential security.*

---

## 🌟 Key Features Summary

✅ Role-based authentication (User / Subadmin / Super Admin)  
✅ Application tracking & filtering  
✅ Certificate upload/download system  
✅ Dynamic form builder  
✅ Job openings & email notifications  
✅ Content, blog & enquiry management  
✅ Fully responsive interface  

---

## 🏗️ Technical Notes

**Frontend:** HTML, CSS, JavaScript (Bootstrap)  
**Backend:** PHP  
**Database:** MySQL *(excluded for security)*  
**Email:** PHP Mailer / SMTP  

---

## 🛡️ Security & Privacy

- All passwords encrypted and validated securely.  
- Sensitive credentials removed from public code.  
- “Track Application” system ensures transparency without login.  

---

## 🧑‍💻 Developer Info

**👨‍💻 Developer:** Peeyush Pandey  
📧 Email: [peeyushpandey735@gmail.com](mailto:peeyushpandey735@gmail.com)

> For collaboration, feature requests, or access to database schema, please contact the developer directly.

---

## 📁 Project Directory Structure

Below is an overview of the main folders and files included in this project and their purposes.

- **/admindashboard** → Super Admin panel files (CRUD operations, blogs, enquiries, etc.)
- **/subadmin** → Subadmin panel and assigned service modules
- **/dashboard** → User dashboard (application tracking, certificates, documents)
- **/assets** → CSS, JS, and frontend resources
- **/img** → Static images (UI icons, banners, etc.)
- **/serviceimages** → Images for registration/service categories
- **/uploads** → Uploaded certificates and user documents *(keep private)*
- **/userdata** → User-generated or downloadable files *(keep private)*
- **/config** → Database connection and configuration files
- **/includes** → Common includes (header, footer, navbar, authentication)
- **/resource** → Backend utilities and helper scripts
- **/about.php**, **/blog.php**, **/index.php** → Main site pages and entry points
- **Other .php files** → Static and dynamic service-related pages

---

## ⚙️ Installation & Setup

1. Git clone the project:
```bash
git clone https://github.com/PIYUSHPANDEY735/Multi-User-Application-Management-Portal.git

2. Put the folder inside XAMPP htdocs. Folder name must be : piyushproject
3. Start Apache and MySQL from XAMPP.
4. Create a dummy database in phpMyAdmin.
5. Ask the developer for the SQL file. Import it with dummy data.
6. Rename the database to : project_complete
7. Open browser and go to : http://localhost/piyushproject
Make sure folder name and database name exactly match, otherwise project won’t work properly.

## ⚙️ Important Note : SQL file and sensitive configs are not included for security.
