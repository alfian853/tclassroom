<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public const HOST_EMAIL = 'noreply.tclassroom@gmail.com';

    private $_view,$_data;

    private $_subject;

    public function setSubject($subject){
        $this->_subject = $subject;
    }

    public function setView($view){
        $this->_view = $view;
    }

    public function setData($data){
        $this->_data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(self::HOST_EMAIL)->subject($this->_subject)
            ->view($this->_view)
            ->with($this->_data);

    }

}
