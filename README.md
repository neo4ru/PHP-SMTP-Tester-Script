# PHP-SMTP-Tester-Script
Very simple PHP Script to test SMTP email server locally Mercury XAMPP- PHPMAILER
https://www.open-emr.org/wiki/index.php/Mercury_Mail_Configuration_in_Windows


Mercury Mail Configuration in Windows

The Mercury Mail package in xampp for windows is a great way to start sending emails from openemr or any open source CMS program placed in xampp. The configuration is easy, just need to follow the steps:

Benefits of Mercury Mail in openEMR

Easy to setup and integrated with XAMPP package
Appointment reminders will be sent automatically using Batchcom/Automatic_notification via cronjob
The patient reminder mails(alert reminders) will be sent automatically
Secure
Obtaining Mercury Mail

If not using XAMPP, but still want to use mercury mail, you can get it from here http://www.pmail.com/downloads_s3_t.htm

Steps of Configuration

1. After downloading Mercury Mail and installing it or if using Xampp, you can find it in C:/xampp/MercuryMail, run the program

2. First of all we disable the HTTP server of Mercury so that it doesn't conflict with the apache.

3. In the open Mercury panel, Go to "Configuration" -> "Protocol modules"

4. Disable the check "MercuryB HTTP web server" and also disable "Mercury IMAP4rev1 server" because It won't be required.

5. To be able to send external mail we have to disable "MercuryE SMTP end-to-end delivery client" in the same dialog and enable "MercuryC SMTP relaying client". Click "OK" and restart Mercury.

6. Now click on "Windows" in the top toolbar and click "Tile windows" and click save position. This will make the viewing easy and the Mercury Panel clean to work with.

7. Next Go to "Configuration" -> "Mercury core module", tab "General"

8. We want to send from localhost, therefore we check if "localhost" is the value of "internet name for this system" and adjust that if not.

9. All other settings stay the same as they are already configured, but we'll have a look to the checkboxes beneath:

Disable all but "Send copies of all errors to postmaster"
Check under the tab "Local domains" if the entry "localhost (local host or server) localhost (internet name)" is there, if not, add it.
Click "OK" and leave the dialog.
10. Next we focus on the MercuryS SMTP Server for outgoing emails.

11. Go to "Configuration" -> "MercuryS SMTP Server"

12. Choose the tab "General" and add a wonderful name for your SMTP server under "Announce myself as", simply fill in any name.

13. Under "Listen on TCP/IP port" fill in "25", that's the SMTP port

14. Add "127.0.0.1" to "IP interface to use", that's the local IP of your pc. With the IP of the pc within the network (192.168.0.X) it doesn't work.

15. Now we limit the access to the server so that only our local machine can access it:

Under "Connection Control" click on "Add restriction" and add the IP range from "127.0.0.1" till "127.0.0.1"
Now select "Allow connections".
Leave all checkboxes deselected
16.with a click on "OK" we quit the dialog and we're looking forward to the next one :)

17. Now let's configure the MercuryP POP3 Server.

18. Go to "Configuration"-> "MercuryP POP3 Server", select the tab "General"

19. "Listen on TCP port" -> "110" and "IP interface to use" -> "127.0.0.1"

20. Choose the tab "Connection control" and proceed as already written under 15 (see above)

21. That's it already, leave the dialog by clicking "OK"

22. Now we have the important one "MercuryC SMTP Client"

23. Go to "Configuration" -> "MercuryC SMTP Client"

24. To send mail to external addresses we need to have an external SMTP server. If you're renting webspace somewhere and have mail included then you normally have access to a SMTP server.

25. Enter the address of your SMTP under "Smart host name", for example "smtp.gmail.com"

26. Depending on the way you access the server fill the values under "Connection port/type":

for a "normal" SMTP that would probably be port 25 and "Normal (no SSL encryption)"
Most access SMTP via SSL (if using gmail), that would be port 465 and "SSL encryption using direct connection"
If you have other parameters simply try around a little :-)
27. We finally fill in the "Login username" and the "Password" that normally is supplied by your webhost or enter your gmail ID and password and we've nearly finished...

28. let's check the Mercury users that are normally pre-configured.

29. Go to "Configuration"-> "Manage local users"

30. There should be at least the users "Admin" and "postmaster", both with administrative rights. If not you have to add them.

31. Now we finished with Mercury, but we still need to configure PHP for sending mail with our scripts.

Configuring PHP

We search and open the appropriate php.ini, using XAMPP you find it under "xampp/php/php.ini" in newer version and under "xampp/apache/bin/php.ini" in older versions
we search for "[mail function]"...
we add/adjust the following:
1."SMTP = localhost"
2."smtp_port = 25"
3."sendmail_from = postmaster@localhost"
Save the php.ini and restart the Apache.
32. Now everything should work! But we'll test it first:

33. Within Mercury choose "File" -> "Send mail message" and send an email for testing purposes, I've chosen to send it to my googlemail account

33. Within the window "Mercury Core Prozess" we'll see our test mail at first:

"13:38:41 JOB XXXXXX: from postmaster@localhost (local) To: XXX@googlemail.com (non-local) (JOB XXXXXX) -OK"
The mail was received in Mercury and processed, after some seconds the window "Mercury SMTP client (relay version)" should show some actions:
1. "05 Jan 2008 13:39, Servicing job XXXXXX ...OK"
2. if you see this message, everything went fine and the mail was sent!
3. if you don't get the message you have to find out why, possible reasons could be:
1. wrong connection values for the SMTP server
2. SMTP server doesn't allow relaying (from your host)
34. Now we'll test the whole thing from a PHP script and we'll write a wonderful one-liner into a PHP file:

1. "mail('xxx@googlemail.com', 'Mercury test mail', 'If you can read this, everything was fine!');"
2. call the PHP file within your browser, a command window should pop up shortly (or maybe not), it's from the fake sendmail of XAMPP, and focus back on Mercury:
1. the produre is the same as above only that the SMTP server receives the mail from php before everything else happens
2. you can watch this in the window "Mercury SMTP Server" and should see something like this: Mercury SMTP
35. If you get the error message "SMTP server response: 553 We do not relay non-local mail, sorry." while sending from PHP go to Mercury under MercuryS -> Connection Control -> "Uncheck Do not Permit SMTP relaying to non-local mail" an check this option. Should fix the problem.
