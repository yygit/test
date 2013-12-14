<?php

class MyCEmailLogRoute extends CEmailLogRoute{

    public $mailer = 'smtp'; // default mailer transport is smtp

    protected function sendEmail($email, $subject, $message) {
        $headers = $this->getHeaders();
        if ($this->utf8) {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/plain; charset=UTF-8";
            $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        }
        if (($from = $this->getSentFrom()) !== null) {
            $matches = array();
            preg_match_all('/([^<]*)<([^>]*)>/iu', $from, $matches);
            if (isset($matches[1][0], $matches[2][0])) {
                $name = $this->utf8 ? '=?UTF-8?B?' . base64_encode(trim($matches[1][0])) . '?=' : trim($matches[1][0]);
                $from = trim($matches[2][0]);
                $headers[] = "From: {$name} <{$from}>";
            } else
                $headers[] = "From: {$from}";
            $headers[] = "Reply-To: {$from}";
        }
        if ($this->mailer == 'smtp')
            $this->mailsend($email, $from, $subject, $message); // send thru smtp
        else
            mail($email, $subject, $message, implode("\r\n", $headers));
    }


    /**
     * @param $to string
     * @param $from string
     * @param $subject string
     * @param $message string
     * @throws CException
     */
    protected function mailsend($to, $from, $subject, $message) {
        $mail = Yii::app()->Smtpmail;
        $mail->SetFrom($from, $from);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to, "");
        if (!$mail->Send()) {
            throw new CException("Mailer Error: " . $mail->ErrorInfo);
        }
    }

}
