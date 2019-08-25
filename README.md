# zaEngine
A powerful Content Management System engine written in PHP by zaBogdan
This project is a way to learn web security and how to write reusable, easy to mantain code for bigger projects. 

# Installation
This process is pretty straight forward. Clone this repository and than run `composer install`. Also, you should fill up you data to the env.php file ( found in `vendor/env.example.php` ) 

> **Note:** You have to rename the `env.example.php` to `env.php` and fill up the data.

After this, you should go to `localhost/admin/install.php` to setup all the basics to run the app properly

Than you are ready to go!

# Future plans

My project called `zaEngine` is still in its early alpha stage, having just some user handling system, Token Authentification and Database Handling class. I plan to extend this to a powerfull, scallable **Content Managemt System**.

Some features that will be added in the next couple weeks:
- [x] File upload system
- [ ] Posts ( Status: 25% )
- [ ] Link the front-end with the back-end 
- [ ] Notification and Message handling
- [ ] Follow system
- [ ] Private messages ( end-to-end encryption )
- [ ] Statistics system 
- [ ] API Request
- [ ] User roles ( example: Administrator, Moderator, Writer, Reader )
- [x] Reorganize files, a render engine
- [ ] Routing engine and Event handler.

# Known bugs
- [x] ~~Session, Confirmation and Reset password tokens doesn't keep track where you use them ( You can use the session token to reset your password, or even confirm your account )~~ 
- [x] When sending an email, the style is removed from the initial page ( Reset password and Confirmation for now )
- [ ] The login token of the cookie is set as it is found in the database. 
- [ ] If you are not logged in, you can't install the app.

# Versions

This application is in early Alpha stage! 

Version 0.3
+ Posts added, early stage. 
+ Automatic installation, first thing that you must do.
+ Fixes for newer mysql and php versions.
+ Twig rendering added, early stage.

Version 0.2
+ Security bugs fixed, Tokens now have specific usage, they are linked to a specific user and can be used for a specific task, before being revoked.
+ File upload system added, with implementation that can be used for future extensions
+ Mail system with `Account confirmation` and `Password reset` futures added. 
- Removed early stage mail ( not working on UNIX based systems )
+ Now sensitive information is stored in `vendor/env.php` file

Version 0.1
+ TokenAuth based authentification, UUID and Secure generated Tokens for all kinds of tasks
+ Users added with automatic handling of some events
+ Database communication and handle input/output
