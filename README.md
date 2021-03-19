# HEFICED-abuse-ip-crawler
Introduction:
A script which would be triggered on an abuse report at HEFICED and which grabs just the reported IP address of the abuse.

## Requirements

For this PHP script you just need a webserver which supports cronjobs or an own Linux server like a Debian or Ubuntu server with latest PHP version installed.

## Installing

### Step 1:
Download the "crawler.php" file or copy the code and create an own file on your server and move it to a wished directory.

### Step 2:
Create a cronjob which triggers the script every 1 or 5 minutes. This depends how fast you want to grab the reported IPs when your mailbox receives the abuse report.

### Step 3:
You should have an email address like abuse@yourdomain.tld on your subnet at HEFICED. Create a second email like abuse-crawler@yourdomain.tld or something else. Set a forwarding from you abuse@yourdomain.tld to your second email that all abuses were also received in the second mailbox. The reason why you need a second mailbox for it would be explained in the further steps.

### Step 4:
Edit the downloaded or self created crawler PHP file. You have to edit this lines:

  Here you have to set your second email address.\
  ```$emailUser = "your@email.com";```
  
  You have to set the email password of the second email address here.\
  ```$emailPassword = "password";```
  
  Set the mail server address.\
  ```$emailServerAdress = "server.address.com";```
  
  If you use the standard mail server settings you do not have to change this line because 143 is the standard IMAP port.\
  ```$emailServerPort = "143";```
 
That's all which you have to edit in the config of the crawler file. The PHP file will connect to your second email mailbox after the trigger and will grab all reported IPs.

### Step 5:
Do it yourself. Now you have grabbed the IPs of the listed reported IPs in your second mailbox and can do what you want with it. For example save it in a database as reported, write an automatically abuse report to your customer or block it in a firewall that no new abuses will be created until you have clarified this.

You can do this here after the variable $reportedIP

      if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $indexFrom, $ipMatch)) {

         // Now you have extracted the reported IPs and can do something with it.
         // For example writing an email, save this in a database or block this IP in your system.
         // I have used this crawler to grab the repoted IPs, saved it in a database and blocked it in my own firewall. Because I use HEFICED as IP provider for my hosting.

         $reportedIP = $ipMatch[0];

      }
      
### Step 6 / Outro
Now your own HEFICED abuse IP crwaler is done! :D So why I need a second mailbox now? The reason for it is that the script is deleting the mails after the crwaler was triggered and grabbed the IPs otherwise it would grab all IPs again and again after the cronjob triggering so that you will have thousands of IPs after a while which are grabbed every minute. So it is better to create a second mailbox which gets the same emails forwarded from the original abuse mailbox. Also it is important to save these reports that you also know something about is when you check your mails!

Here are the last lines which do this:

    // delete message
    imap_delete( $emailConnection, $indexProcess );
    }

    // expunge deleted messages
    imap_expunge( $emailConnection );
    
So that's everything! I hope you enjoy it ;)

Cheers
