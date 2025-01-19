# Boards

This is a simple, threaded message board system. Here are the features:

- It's using Bootstrap 5 on the front end, and it allows the user to choose from a number of color themes and/or to select Dark Mode or Light Mode.

- It's built using CakePHP 5 on the server side, and the code is easy to follow.

- There is no administrative back end! At least, none now. I'm using phpMyadmin to manage my remote databases, and the core design of this app is simple enough that I can manage it using phpMyAdmin.

- The superuser is allowed to lock threads, so that no new messages can be added to the thread.

- One, unique feature of this system is that every message can be edited, but each version that ever existed still exists in the revision history of that message, which is linked right there in the message body so anyone can see what changes were made to any message.

- Users can register an account and self-activate it by providing a valid email address. An activation code will be mailed to that address, and it will expire in five minutes from creation.

- If a user attempts without success to login ten times inside of five minutes, the user account is automatically deactivated and the user will have to contact the administrator to reactivate.

- If a user reaches twenty failed login attempts across _any_ duration of time, their account will be deactivated and they will have to ask the administrator for help to reactivate.

- Every time a user logs in successfully, their failed login attempts are all deleted from the database. 

- A subset of Markdown is available to the user for text formatting, including the ability to make text bold, italicized, or both. Links and embedded images are also possible, as well as numbered and ordered lists. Code can be shared inline or in monotype, preformatted blocks. Headings are available, of course.