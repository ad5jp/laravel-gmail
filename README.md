# Laravel Mailer for Gmail API  
  
This package allows you to use the Gmail API as a mailer in Laravel. You can send emails from Laravel via the Gmail API without modifying your existing code.  
  
Instead of using OAuth, this package uses a service account for sending emails. This eliminates the need for user authentication processes and access token management, while ensuring the method does not fall under LSA (Less Secure Apps).  
  
[日本語はこちら](README_JA.md)  
  
## Installation  
  
```  
composer require ad5jp/laravel-gmail  
```  
  
Specify the version according to your environment:  
  
- v4.x ... Laravel 9 and later  
- v3.x ... Laravel 7 - 8  
- v2.x ... Laravel 6 and earlier  
- v1.x ... Laravel 6 and earlier with google/apiclient-service before v0.200.0  
  
## Usage  
  
### 1. Create a Service Account on Google Cloud Platform  
  
1. Create a project in the Google Cloud Platform console.
2. Enable the Gmail API.
3. Create a service account, generate a key, and download it in JSON format.
4. In the Google Workspace admin console, set up "Domain-wide Delegation". Assign the scope https://www.googleapis.com/auth/gmail.send to the service account created above.
  
### 2. Place the Key  
  
Place the JSON key downloaded in step 2 within your application. Ensure it is excluded from source control using .gitignore or similar.  
  
### 3. Configure .env  
  
Change the value of MAIL_MAILER in your .env file to gmail. (Or change the 'default' value in config/mail.php)  
  
For Laravel 6 and earlier, change the value of MAIL_DRIVER in your .env file to gmail. (Or change the 'driver' value in config/mail.php)  
  
Add the following lines to your .env file:  
  
```  
GMAIL_FROM_ADDRESS={Sender's email address}  
GMAIL_SERVICE_ACCOUNT_KEY={Path to the JSON key placed in step 2}  
```  
  
The sender's email address must be an email address within the Google Workspace organization set up in step 1 (4).  
