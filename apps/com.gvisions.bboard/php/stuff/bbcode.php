<style>
.bold {
        font-weight: bold;
}

.italics {
        font-style: italic;
}

.underline {
        text-decoration: underline;
}

.strikethrough {
        text-decoration: line-through;
}

.overline {
        text-decoration: overline;
}

.sized {
        text-size:
}

.quotecodeheader {
        font-family: Verdana, arial, helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
}

.codebody {
        background-color: #FFFFFF;
    font-family: Courier new, courier, mono;
    font-size: 12px;
    color: #006600;
    border: 1px solid #BFBFBF;
}

.quotebody {
        background-color: #FFFFFF;
    font-family: Courier new, courier, mono;
    font-size: 12px;
    color: #660002;
        border: 1px solid #BFBFBF;
}

.listbullet {
        list-style-type: disc;
        list-style-position: inside;
}

.listdecimal {
        list-style-type: decimal;
        list-style-position: inside;
}

.listlowerroman {
        list-style-type: lower-roman;
        list-style-position: inside;
}

.listupperroman {
        list-style-type: upper-roman;
        list-style-position: inside;
}

.listloweralpha {
        list-style-type: lower-alpha;
        list-style-position: inside;
}

.listupperalpha {
        list-style-type: upper-alpha;
        list-style-position: inside;
}
</style>
<?php
function BBCode($Text) 
{ 
    // Replace any html brackets with HTML Entities to prevent executing HTML or script 
    // Don't use strip_tags here because it breaks [url] search by replacing & with amp 
    $Text = str_replace("<", "&lt;", $Text); 
    $Text = str_replace(">", "&gt;", $Text); 


    // Set up the parameters for a URL search string 
    $URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'"; 
    // Set up the parameters for a MAIL search string 
    $MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@"; 

    //Non BB URL Search 
    //$Text = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" target=\"_blank\" target=\"_new\">\\1://\\2\\3</a>", $Text); 
    //$Text = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\" target=\"_new\">\\1</a>", $Text); 
    if (substr($Text, 0, 7) == "http://") { 
        $Text = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", 
            "<a href=\"\\1://\\2\\3\">\\1://\\2\\3</a>", $Text); 
        // Convert new line chars to html <br /> tags 
        $Text = nl2br($Text); 
    } else { 
        // Perform URL Search 
        $Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", 
            '<a href="$1" target="_blank">$1</a>', $Text); 
        $Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", 
            '<a href="$1" target="_blank">$2</a>', $Text); 
        //$Text = preg_replace("(\[url\=([$URLSearchString]*)\]([$URLSearchString]*)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text); 
        // Convert new line chars to html <br /> tags 
        $Text = nl2br($Text); 
    } 
    // Perform MAIL Search 
    $Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", 
        '<a href="mailto:$1">$1</a>', $Text); 
    $Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", 
        '<a href="mailto:$1">$2</a>', $Text); 

    // Check for bold text 
    $Text = preg_replace("(\[b\](.+?)\[\/b])is", '<b>$1</b>', $Text); 

    // Check for Italics text 
    $Text = preg_replace("(\[i\](.+?)\[\/i\])is", '<i>$1<i>', 
        $Text); 

    // Check for Underline text 
    $Text = preg_replace("(\[u\](.+?)\[\/u\])is", 
        '<u>$1</u>', $Text); 

    // Check for strike-through text 
    $Text = preg_replace("(\[s\](.+?)\[\/s\])is", 
        '<s>$1</s>', $Text); 

    // Check for over-line text 
    $Text = preg_replace("(\[o\](.+?)\[\/o\])is", '<o>$1</o>', 
        $Text); 

    // Check for colored text 
    $Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is", "<span style=\"color: $1\">$2</span>", 
        $Text); 

    // Check for sized text 
    $Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is", "<span style=\"font-size: $1px\">$2</span>", 
        $Text); 

    // Check for list text 
    $Text = preg_replace("/\[list\](.+?)\[\/list\]/is", 
        '<ul class="listbullet">$1</ul>', $Text); 
    $Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", 
        '<ul class="listdecimal">$1</ul>', $Text); 
    $Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", 
        '<ul class="listlowerroman">$1</ul>', $Text); 
    $Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", 
        '<ul class="listupperroman">$1</ul>', $Text); 
    $Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", 
        '<ul class="listloweralpha">$1</ul>', $Text); 
    $Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", 
        '<ul class="listupperalpha">$1</ul>', $Text); 
    $Text = str_replace("[*]", "<li>", $Text); 

    // Check for font change text 
    $Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])", "<span style=\"font-family: $1;\">$2</span>", 
        $Text); 

    // Declare the format for [code] layout 
    $CodeLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0"> 
                                <tr> 
                                    <td class="quotecodeheader"> Code:</td> 
                                </tr> 
                                <tr> 
                                    <td class="codebody">$1</td> 
                                </tr> 
                           </table>'; 
    // Check for [code] text 
    $Text = preg_replace("/\[code\](.+?)\[\/code\]/is", "$CodeLayout", $Text); 

    // Declare the format for [quote] layout 
    $QuoteLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0"> 
                                <tr> 
                                    <td class="quotecodeheader"> Quote:</td> 
                                </tr> 
                                <tr> 
                                    <td class="quotebody">$1</td> 
                                </tr> 
                           </table>'; 

    // Check for [quote] text 
    $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is", "$QuoteLayout", $Text); 

    // Images 
    // [img]pathtoimage[/img] 
    $Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text); 

    // [img=widthxheight]image source[/img] 
    $Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", 
        '<img src="$3" height="$2" width="$1">', $Text); 

    return $Text; 
}
?>