<?php

/*
 * Our Custom Mail Class
 */

class Sendmail {

    public $email_layout = 'file';

    function send($to, $subject, $body, $fromName = '', $from = '', $attachment = null) {
        if (MAILSENDBY == 'phpmail'):
            $this->sendPhpmail($to, $subject, $body, $attachment);
        elseif (MAILSENDBY == 'smtp'):
            Yii::import('application.extensions.phpmailer.JPhpMailer');
            if (empty($from))
                $from = NOREPLYMAIL;
            if (empty($fromName))
                $fromName = SITENAME;

            $mailer = new JPhpMailer;
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
            $mailer->SMTPAuth = SMTPAUTH;
            $mailer->SMTPSecure = SMTPSECURE;
            $mailer->Host = SMTPHOST;
            $mailer->Port = SMTPPORT;
            $mailer->Username = SMTPUSERNAME;
            $mailer->Password = SMTPPASS;
            $mailer->From = $from;
            $mailer->FromName = $fromName;
            $mailer->AddAddress($to);
            // $mailer->

            $mailer->Subject = $subject;

            $mailer->MsgHTML($body);

            try {
                $mailer->Send();
            } catch (Exception $exc) {
                return $exc->getTraceAsString();
            }
        endif;
    }

    public function getMessage($body, &$translate, $template = 1, $is_header_footer = true) {
        if ($is_header_footer) {
            $msg_header = file_get_contents(SITEURL . EMAILTEMPLATE . "template_{$template}/header.html");
            $msg_footer = file_get_contents(SITEURL . EMAILTEMPLATE . "template_{$template}/footer.html");
        } else {
            $msg_header = $msg_footer = '';
        }
        if ($this->email_layout == 'file'):
            $msg_body = file_get_contents(SITEURL . EMAILTEMPLATE . $body . '.html');
        else:
            $msg = EmailTemplate::model()->findByPk($body);
            $msg_body = $msg->Email_Temp_Content;
        endif;

        $message_dub = $msg_header . $msg_body . $msg_footer;

        $message = $this->translate($message_dub, $translate);
        return $message;
    }

    public function getSubject($body, &$translate) {
        $msg = EmailTemplate::model()->findByPk($body);
        $msg_body = $msg->Email_Temp_Subject;
        $message = $this->translate($msg_body, $translate);
        return $message;
    }

    public function translate($msg_dub, $translate = array()) {
        $def_trans = array(
            "{SITEURL}" => SITEURL,
            "{SITENAME}" => SITENAME,
            "{EMAILHEADERIMAGE}" => Yii::app()->createAbsoluteUrl(EMAILHEADERIMAGE),
            "{CONTACTMAIL}" => CONTACTMAIL,
            "{GEN_DATE}" => date('Y-m-d'),
            "{LOGO}" => '<img src="{' . EMAILHEADERIMAGE . '}" style="height: 14px;"/>',
        );

        $translation = array_merge($def_trans, $translate);
        $message = strtr($msg_dub, $translation);

        return $message;
    }

    function sendPhpmail($to, $subject, $body, $attachment = null) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . SITENAME . ' <' . NOREPLYMAIL . '>' . "\r\n";

        mail($to, $subject, $body, $headers);
    }

}

?>