<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class SendMail extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    public function send(){
        $mail_body = "落落長的內文";
        $this->load->library('mailer');
        $this->mailer->sendmail(
            'redmaplewing@gmail.com',
            '收件人',
            '這是測試信 '.date('Y-m-d H:i:s'),
            $mail_body
        );
    }
}
/* End of file epaper.php */