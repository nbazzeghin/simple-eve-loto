// *****************************************************************************
// *  Simple EVE Lotto 1.2                                                     *
// *                                                                           *
// *  Copyright (c) 2010 Nigel Bazzeghin                                       *
// *                                                                           *
// *  This program is free software; you can redistribute it and/or            *
// *  modify it under the terms of the GNU General Public License              *
// *  as published by the Free Software Foundation; either version 3           *
// *  of the License, or (at your option) any later version.                   *
// *                                                                           *
// *  This program is distributed in the hope that it will be useful,          *
// *  but WITHOUT ANY WARRANTY; without even the implied warranty of           *
// *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            *
// *  GNU General Public License for more details.                             *
// *                                                                           *                                               *
// *****************************************************************************

The Simple EVE Lotto web app is setup to allow you to create a lottery that other pilots can purchase
tickets from. After you have created a lotto and set it state to open, just pass along the lotto code
to all your pod pilot friends. Then they just send isk to you or the corporation you provided the API data for
with the reason of the lotto code you gave and when the cron script it called, they get tickets based
on what you set the ticket price to be. They can even check on their own ticket status by browsing to 
the front-end page of index.php. It will allow them to search by name or lotto code.

The lotto will auto-close when all the tickets have been sold or when the end date is reached. At that
time a winner will be chosen by a simple SQL select statement 
(SELECT * FROM 'tickets' WHERE 'lottoid' = {id provided} ORDER BY RAND() LIMIT 1), the very same approach
Chirbba uses for his lotto's. Now you always have the option to close the lotto early, and choose a 
winner sooner than the end date or all the tickets have sold.

There is also the option to have a third party pick the winner, such as Chirbba's DICE tool. If you would to use
this option vice having the application pick for you, simply check the check box when you create the lotto. This
will allow anyone who searches for the lotto code you provide to see who all has what ticket number. 

The cron script has also been setup to look at the lotto start date and not add any tickets to the system
for a lotto that hasnt started yet. This allows you to setup lotto's for future dates should the need arise
for that. The system is also capable of tracking and managing multiple ongoing lotto's at once.

INSTALLATION INSTRUCTIONS:

1) Copy entire contents of zip file to folder on your host. IE "public_html/lotto/"

2) Edit config files to match your database and API settings. Make sure the path in configuration.php 
   is the full path to your lotto install.
	a) ale/eveonline.ini
	b) ale/evecentral.ini  
	c) configuration.php
	
3) Open your browser and point it to the setup directory where you extracted the lotto system. 
	IE "http://yoursite.com/lotto/setup"
	
4) Use default options on setup and continue

5) Setup cron job to execute cron.php on some type of interval. The lotto system makes use of API caching
   so as not to upset the CCP API server, so it doenst matter how often you call cron.php, you are only
   going to be getting new data every hour.
   
6) Browse to http://yoursite.com/lotto/lotto-admin.php and create your new lotto	 

7) Search for your new lotto on the front end. http://yoursite.com/lotto/index.php