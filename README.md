# InStats 
A fast, very simple statistics script for PHP [@yasinkuyu](https://twitter.com/yasinkuyu)
 
Inspired by StatCounteX 3.1 (ASP)

InStats Wordpress Plugin (https://github.com/yasinkuyu/InStats-WP)

#### Localization Support 
    Translations
    - Turkish
    - English

### Screenshot
 
![screenshot](https://cloud.githubusercontent.com/assets/204635/14124634/38a167fe-f60f-11e5-92c5-872c613a0903.png)

## Install

    1- Upload the instats folder to your root folder. (ex: yourdomain.com/instats)
    2- create database instats
    3- import apps/instats.sql
    4- edit domain and database settings in ./config.php.
    5- add your tracking code to your theme's </body> tags.
    5- check report yourdomain.com/instats/reports.php

##### Tracking Code

    <!-- TRACKING CODE -->
    <script type="text/javascript">
    
    // InStats v1
    // @yasinkuyu, 2016
    
    var d=new Date,s=d.getSeconds(),m=d.getMinutes(),x=s*m,f=""+escape(document.referrer),j=navigator.javaEnabled(),l=navigator.language,ua=navigator.userAgent;"Netscape"==navigator.appName&&(b="NS"),"Microsoft Internet Explorer"==navigator.appName&&(b="MSIE"),navigator.appVersion.indexOf("MSIE 3")>0&&(b="MSIE"),u=""+escape(document.URL),w=screen.width,h=screen.height,v=navigator.appName,fs=window.screen.fontSmoothingEnabled,"Netscape"!=v?c=screen.colorDepth:c=screen.pixelDepth;var info="w="+w+"&h="+h+"&c="+c+"&r="+f+"&u="+u+"&fs="+fs+"&b="+b+"&x="+x+"&l="+l+"&ua="+ua;document.write('<img src="/instats/count.php?'+info+'" width="90" height="30" border="0">');
    </script>

##### InStats (Insya Statistics)

@yasinkuyu, 2016
