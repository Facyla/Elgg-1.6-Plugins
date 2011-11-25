Widget Title
---------------------------
To change the widget title, edit the language file (en.php) and change the string simplepie:widget from Blog to whatever you desire.


Proxy Server
----------------------------
If your site is going through a proxy server to get to the feeds, you may want to increase the timeout on the feeds (though this is unlikely as the default timeout is 10 seconds). You can do this by editing simplepie/views/default/widgets/feed_reader/view.php. There you can just uncomment the line $feed->set_timeout(20);


CHANGELOG :

v0.4 : integration of both versions + configuration settings

v0.3' : updates by Sophiemeheo & Facyla
- implements an editable "feed" object

v0.3 : updates by Facyla
- simplepie version 20091211
- CSS improvements (images)
- some modifications in view.php

v0.2 : Original version by Cash Costello
