<?php
/*
 * Filename: CWPViewCreatePoll.class.php
 * This is the class file which will have all the markup for the 
 * user interface to create a new poll.
 */
if(isset($_POST['submit'])){
    update_option('cwpp_useremail', $_POST['useremail']);
    update_option('cwpp_key', $_POST['key']);
}

class CWPViewCreateImagePoll{

    public function __construct() {
        print '<div id="tab3" class="tab-content" style="z-index:10000;">';
        $useremail = stripslashes(get_option('cwpp_useremail'));
        $key = stripslashes(get_option('cwpp_key'));
        if(empty($useremail) || empty($key)){
            print '<h4 style="color: #000000; font-weight: bold">Hi! you have to make a small donation of £2 to activate this feature in this plugin. After you make the donation you will be mailed with the access key within next 24 hours. Please note that you have specify your email address while you are making the donation! <br>Many Thanks for your support.</h4>';
            print '<h3>Enter your access details below</h3><form method="post" action="">';
            print '<table><tr><td>Enter your registered email:</td>';
            print '<td><input type="text" name="useremail" size="40" /></td></tr>';
            print '<tr><td>Enter your key:</td>';
            print '<td><input type="text" name="key" size="40" /></td></tr></table>';
            print '<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>';
            print '</form>';
        }
        else{
            $a=file_get_contents('http://www.fingerfish.com/support/wordpresspollapi.php?useremail='.$useremail.'&key='.$key.'&plugin=poll');
            if(!empty($a)) echo $a;
            else{
                echo '<h3 style="color:red;">Authentication Failed! Check your access details</h3>';
                print '<h3>Enter your access details below</h3><form method="post" action="">';
                print '<table><tr><td>Enter your registered email:</td>';
                print '<td><input type="text" name="useremail" size="40" value="'.$useremail.'" /></td></tr>';
                print '<tr><td>Enter your key:</td>';
                print '<td><input type="text" name="key" size="40" value="'.$key.'" /></td></tr></table>';
                print '<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>';
                print '</form>';
            }
        }
        print '</div>';
    }
}
?>