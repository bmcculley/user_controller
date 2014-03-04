User Controller Class
=====================

A class to control user access to various pages on a website.

I know there are already plenty of classes available to control user access. 
The problem with most of them is that they do not include the option for 
multiple access levels, meaning if a user is logged in they will be able to
reach every page as well as every part of the page on the entire website. 
Another issue I seem to keep running across is that a great many of them 
require a PHP version level of at least 5.3. While staying up to date with the 
latest available version is great, it leaves a great many of webmasters out 
in the cold. Shared hosting environments for example, many websites are hosted 
on them due to their low costs. However, a trade off has to be made, they tend 
not to update to the latest version(s) of software in a timely manner. Thus 
the issue.

Here's my start of an answer to this problem. A class that supports user 
control at an unlimited amount of access levels. Go ahead, try it out, create 
as many access levels as you please. Plus, it supports PHP versions all the 
way down to 5.0. Pretty much every hosting environment should be supported 
here. MySQL versions down to 4.1 are also supported.

## Requirements

 * PHP version >5.0
 * MySQL version >4.1

## Future

As of March 1, 2014 I am just pushing the initial commit to the public repository, 
with that being said, there is still a lot of work to be done with this class. 
Virtually nothing has been tested, and I still have to complete writing some 
of the functions and moving things around so it all makes at least a little 
bit of sense.

### List of things to complete

 * Complete functions
 * Functions should also return error codes so we know what's going on
 * Update hierarchy so the order of everything makes sense
 * Add in my [session controller](https://github.com/bmcculley/session-controller) class to better handle logged in users
 * Add in a better mailer function that will handle both plain text and HTML
 * Complete documentation and example code
 * ???

### Contributing

I'd be more then happy to receive any help, whether you find a bug or just feel like helping out. I encourage you to open an [issue](https://github.com/bmcculley/user_controller/issues) or submit a [pull request](https://github.com/bmcculley/user_controller/pulls).

Code is released under [Apache License v2 license](http://www.apache.org/licenses/LICENSE-2.0.html).

[![Buy me a coffee](http://i.imgur.com/qB510Gx.png "Buy me a coffee?")](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WH8N24DEJKVCE)

Until next time...