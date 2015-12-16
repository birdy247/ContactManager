<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
$this->start('to');
?>
<p>Hi</p>
<p>You have a new enquiry via the online form.  The details are as follows:</p>
<?php
$this->end();
?>
<?php
$this->start('body');
?>
<p>Date: <?php echo $contact->created ?></p>
<p>Name: <?php echo $contact->name ?></p> 
<p>Email: <?php echo $contact->email ?>
<p>Question:</p>
<p><?php echo $contact->message ?></p>
<?php
$this->end();
?>
<?php
$this->start('sig');
?>
<p>Thanks</p>
<?php
$this->end();
?>