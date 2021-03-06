<?php

  ##########################################################
  ###          HEFICED ABUSE REPORT IP CRAWLER           ###
  ###            Coded by Collin Schneeweiß              ###
  ###      Contact: collin.schneeweiss@unesty.net        ###
  ##########################################################
  ### A crawler which crawls the IP of an abuse report   ###
  ### after receiving the email from HEFICED. This makes ###
  ### it more simple to automate something with it.      ###
  ##########################################################
  ### MANY THANKS TO KAROLIS FOR YOUR HELP THAT YOU HAVE ###
  ###           INSPIRED ME TO DO THIS! ♡                ###
  ##########################################################

  // set user to check
  $emailUser = "your@email.com";
  $emailPassword = "password";
  $emailServerAdress = "server.address.com";
  $emailServerPort = "143";
  $abuseMail = "abuse@heficed.com";

  // open
  $emailConnection = imap_open ("{".$emailServerAdress.":".$emailServerPort."/notls}INBOX", "$emailUser", "$emailPassword");

  // get headers
  $emailHeader = imap_headers( $emailConnection );

  // get message count
  $emailCounter = imap_mailboxmsginfo( $emailConnection );

  // process messages
  for( $indexProcess = 1; $indexProcess <= $emailCounter->Nmsgs; $indexProcess++  )
  {
      // get header info
      $indexHeader = imap_headerinfo( $emailConnection, $indexProcess );

      // get from object array
      $indexSubject = $indexHeader->subject;

      // get from object array
      $indexFrom = $indexHeader->from;

      // process headers
      for( $idx = 0; $idx < count($indexFrom); $idx++ )
      {
          // get object
          $fromData = $indexFrom[ $idx ];

          // get email from
          $fromEmail = $fromData->mailbox . "@" . $fromData->host;

          if ($fromEmail == $abuseMail) {

            if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $indexSubject, $ipMatch)) {

               // Now you have extracted the reported IPs and can something with it.
               // For example writing email, save this in a database or block this IP in your system.
               // I have used this crawler to grab the repoted IPs, saved it in a database and blocked it in my own firewall. Because I use HEFICED as IP provider for my hosting.

               $reportedIP = $ipMatch[0];

            }

          }

      }

    // delete message
    imap_delete( $emailConnection, $indexProcess );
    }

    // expunge deleted messages
    imap_expunge( $emailConnection );

    // close
    imap_close( $emailConnection );

 ?>
