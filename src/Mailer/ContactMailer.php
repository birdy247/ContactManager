<?php

namespace ContactManager\Mailer;

use Cake\Mailer\Mailer;

/**
 * Contact mailer.
 */
class ContactMailer extends Mailer {

    /**
     * Mailer's name.
     *
     * @var string
     */
    static public $name = 'Contact';

    public function notify($contact) {
        $this
                ->profile('contact')
                ->replyTo($contact->email)
                ->viewVars(['contact' => $contact]);
    }

}
