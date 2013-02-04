ztpShout
========

Shoutbox for small internet based radios

**Important Information:**

The SQL script and default connection details in the repo use 'changeMe' for a MySQL password.  For the love of all that's holy, *please* change these details, so people don't break into your system and run amok with your shoutbox!

**Quick Setup:**

*This assumes some limited prior LAMP setup experience.  PLEASE do not request assistance expecting a freebie!*

1. Edit **at least** the 'changeMe' in the included MySQL script for security.
2. Run that MySQL script as the MySQL "root" user.
3. Edit the 'Connections/settings.php' file to match your MySQL configuration.
4. Upload the index.php file and Connections folder (and its contents) to someplace handy on your web server.
5. Either link to or iframe the index.php file wherever you want the shoutbox to appear.

**Advanced Tricks:**

The person who asked me to create this wanted to be able to reset the chat log and pre-add one message on a set schedule.  The means to do that are forthcoming shortly.

**Known Issues:**

* I'm using an XML response to return the chat data.  There may be better ways to do that which I'm not aware of.
* Because of the limitations (in my experience) with the XML format for this kind of thing and the way I'm doing it, I'm furthermore using a JQuery trick to reconstitute encoded HTML elements returned by the operations that fetch chat data.
* The XML chat data returned includes the aforementioned HTML elements which the server-side op is creating from table rows in the MySQL.  There are definitely further better ways (which I'm well aware of) of doing what I'm doing there (but this is free software, so, you have little right to complain just yet).