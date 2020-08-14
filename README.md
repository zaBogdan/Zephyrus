# Zephyrus
<p align="center">
  <img src="https://imgur.com/uHDcZyk.jpg" alt="New logo"/>
</p>
This is a Content Management System created for learning purposes. It has suffered a lot of changes and improves during this commits. If you want to see a changelog of this look at the [Versions](#versions). Project is not regularly maintained and can have severe security issues because of the little time I have.

# Installation with Docker
I tried to automate as much as I could and these are the new steps:
* Clone the repository 'git clone https://github.com/zaBogdan/Zephyrus.git'
* Change to the directory 'cd Zephyrus'
* Run the composer to get all dependencies 'composer install'
* Make sure you change credentials from 'docker-compose.yml' file
* Start up docker with 'docker-compose up --build' (use --build only first time!)
* Go to the web at 'http://localhost:8000/admin/install/' and follow the instructions there

> **Note:** The credentials in 'docker-compose.yml' can be anything you want. There are just for setup purposes. But make you need to reuse them in order to make the connection to database!

And that's it. You've installed the application!

# Installation without Docker
Even if I don't recommend it because it can be a huge pain on some operating systems, these are the steps.
* Clone the repository 'git clone https://github.com/zaBogdan/Zephyrus.git'
* Change to the directory 'cd Zephyrus'
* Run the composer to get all dependencies 'composer install'
* Now you have everything needed, so you need to set up the webservice
* You need PHP, Apache2, PHPMyAdmin and MySQL installed on your system. Also an active Mailgun account and a TinyMCE one.
* Go to the web at 'http://localhost:8000/admin/install/' and follow the instructions there

> **Note** I recommend this tutorial for installing the LAMP stack if you are on a linux distro: https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04

# Future plans
Even if it's in an alpha stage this project will be maintained but it will not have regular updates, because I am short on time. Hopefully it will become one day a powerful, scalable CMS.

These are some features I want to add:
- [x] Manage Images & Videos (FileSystem)
- [ ] Posts (TextSystem)
- [ ] Manage content generated by users (ManagementSystem)
- [ ] Pretty urls
- [ ] User interactions & communication (SocialSystem)
- [ ] Working with data (StatisticsSystem)
- [ ] Handling errors and requests (Logger)

# Known bugs
These are the bugs found during pentesting session. If you find more please inform me. 

> **Note** Not all bugs found here are solved. at the end there are specified vulnerable versions.

- [x] A valid token can be used anywhere, no matter of it's scope (<0.2)
- [x] Emails lose their style (<0.3)
- [x] You can't install the application if you are not logged in, and you can't login because there is no database. (Only for 0.3)
- [x] Session cookies are not encrypted. (<0.4)
- [x] Remote code execution in `Upload Files` page. (<0.4)
- [x] Tokens are the same as UUID, not generated securely. (<0.4)


# Versions

This application is in early Alpha stage!
Legend:
```json
+ New feature added
? Planned to be realised
- Feature removed.
! Bug/Security issue fixed
```

Version 0.4 - Final touches!
- (+) Service installation stage completed.
- (+) Project files restructured. (backend is now separated from frontend)
- (+) Docker has been added to the project.
- (+) Tokens now generate securely and use Selector:Validation schema.
- (+) Authentification system (Sessions) is now more secure and checks are made properly.
- (+) Roles for users
- (+) Rebranded from `zaEngine` to `Zephyrus`
- (+) Posts are now completed
- (?) Home, Posts and Profile pages are now working and linked. (phase 2: linking everything)
- (-) Removed first installation system, because it was broken.
- (-) Removed old system of token & session generation. Now everything is more secure.
- (-) FileSystem is removed for this update. Will be taken care of in the next one.
> **Note** At this moment this version is in it's late alpha. Don't install this on your production system!

Version 0.3
- (+) Posts added, early stage.
- (+) Automatic installation, first thing that you must do.
- (+) Fixes for newer mysql and php versions.
- (+) Twig rendering added, early stage.
- (!) You can't install the application if you are not logged in, and you can't login because there is no database.
- (!) Remote code execution in `Upload Files` page.
- (!) Tokens are the same as UUID, not generated securely. 

Version 0.2
- (+) Security bugs fixed, Tokens now have specific usage, they are linked to a specific user and can be used for a specific task, before being revoked.
- (+) File upload system added, with implementation that can be used for future extensions
- (+) Mail system with 'Account confirmation' and 'Password reset' futures added.
- (-) Removed early stage mail ( not working on UNIX based systems )
- (+) Now sensitive information is stored in 'vendor/env.php' file

Version 0.1
- (+) TokenAuth based authentication, UUID and Secure generated Tokens for all kinds of tasks
- (+) Users added with automatic handling of some events
- (+) Database communication and handle input/output
