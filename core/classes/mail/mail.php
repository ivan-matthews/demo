<?php

	/*
		\Core\Classes\Mail\Mail::set('admin')
			->subject('Thema')
			->address('dasini6410@qortu.com')
			->html('welcome',array('var'=>'privetulia'))
			->send();
	*/

	namespace Core\Classes\Mail;

	use Core\Classes\Config;
	use Core\Classes\Language;
	use Core\Classes\Mail\Interfaces\Mail as MailInterface;
	use Core\Classes\View;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use Core\Classes\Error;

	class Mail implements MailInterface{
		/** @var string */
		private $config_interface;
		/** @var Config */
		private $config;
		/** @var array */
		private $mail_params;
		/** @var PHPMailer */
		private $mail;
		/** @var Language */
		private $language;
		/** @var array */
		private $errors;
		private $user_name;
		private $user_address;

		/**
		 * @param string $config_interface_key
		 * @return MailInterface
		 */
		public static function set($config_interface_key='admin'){
			return new self($config_interface_key);
		}

		public function __construct($config_interface_key='admin'){
			$this->config_interface = $config_interface_key;
			$this->config = Config::getInstance();
			$this->mail_params = $this->config->mail[$this->config_interface];
			$this->language = Language::getInstance();
			$this->connect();
		}

		private function connect(){
			$this->mail = new PHPMailer();
			$this->mail->SMTPDebug = $this->mail_params['mail_debug'];
			$this->mail->CharSet  = $this->mail_params['mail_default_char'];
			$this->mail->XMailer  = $this->mail_params['mail_xmailer'];
			$this->mail->Hostname = ltrim(strstr($this->mail_params['mail_from'], '@'), '@');

			$this->mail->setLanguage($this->language->getLanguageKey());
			$this->user_address = $this->mail_params['mail_from'];
			$this->user_name = $this->mail_params['mail_from_name'];
		}

		public function subject($message_theme){
			$this->mail->Subject = $message_theme;
			return $this;
		}
		public function from($email_address,$email_user_name){
			$this->user_address = $email_address;
			$this->user_name = $email_user_name;
			return $this;
		}
		public function to($email,$name=false){
			$this->mail->addAddress($email, $name);
			return $this;
		}
		public function reply($email_reply_to,$name_reply_to){
			$this->mail->clearReplyTos();
			$this->mail->addReplyTo($email_reply_to, $name_reply_to);
			return $this;
		}
		public function headers($custom_headers=array()){
			foreach($custom_headers as $name => $value){
				$this->mail->addCustomHeader($name, $value);
			}
			return $this;
		}
		public function attachments($attachments_headers=array()){
			foreach($attachments_headers as $attach){
				$this->mail->addAttachment($attach);
			}
			return $this;
		}
		public function text($message){
			$this->setBodyHTML($this->mail->html2text($message));
			return $this;
		}
		public function html($file,array $data){
			$view = View::getInstance();
			$file_path = $view->path("assets/mail/{$file}.html.php");
			$result = null;
			if(is_readable($file_path)){
				$result = $view->render($file_path,$data);
			}
			$result = $this->parseSubject($result);
			$result = $this->parseAttachments($result);
			$this->setBodyHTML($result);
			return $this;
		}
		public function send(){
			$this->init();
			$this->setFrom($this->user_address,$this->user_name);
			$this->setBodyText($this->mail_params['mail_default_title']);
			$result = $this->mail->send();
			if(!$result){
				trigger_error($this->mail->ErrorInfo,E_USER_WARNING);
			}
			return $result;
		}
		public function clear(){
			$this->mail->ClearAddresses();
			$this->mail->ClearAttachments();
			return $this;
		}

		private function setFrom($email, $name=''){
			$this->mail->SetFrom($email, $name);
			return $this;
		}
		private function setBodyHTML($message, $is_auto_alt = true){
			$this->mail->msgHTML( $message );
			if($is_auto_alt){
				$this->setBodyText( $this->mail->html2text($message) );
			}
			return $this;
		}
		private function setBodyText($message){
			$this->mail->AltBody = $message;
			return $this;
		}
		private function parseSubject($letter_text){
			if(preg_match('/\[subject:(.+)\]/iu', $letter_text, $matches)){
				list($subj_tag, $subject) = $matches;
				$letter_text = trim(str_replace($subj_tag, '', $letter_text));
				$this->mail->Subject = $subject;
			}
			return $letter_text;
		}
		private function parseAttachments($letter_text){
			if(preg_match_all('/\[attachment:(.+?)\]/iu', $letter_text, $matches)){
				list($tags, $files) = $matches;
				foreach($tags as $idx => $att_tag){
					$letter_text = trim(str_replace($att_tag, '', $letter_text));
					$this->mail->addAttachment(ROOT . $files[$idx]);
				}
			}
			return $letter_text;
		}

		private function init(){
			if(method_exists($this,"{$this->mail_params['mail_transport']}Transport")){
				call_user_func(array($this,"{$this->mail_params['mail_transport']}Transport"));
			}
			return $this;
		}
		private function mailTransport(){
			$this->mail->isMail();
			return $this;
		}
		private function SMTPTransport(){
			$this->mail->isSMTP();
			$this->mail->Host          = $this->mail_params['mail_smtp_server'];
			$this->mail->Port          = $this->mail_params['mail_smtp_port'];
			$this->mail->SMTPAuth      = (bool)$this->mail_params['mail_smtp_auth'];
			$this->mail->SMTPKeepAlive = true;
			$this->mail->Username      = $this->mail_params['mail_smtp_user'];
			$this->mail->Password      = $this->mail_params['mail_smtp_pass'];
			if($this->mail_params['mail_smtp_enc']){
				$this->mail->SMTPSecure = $this->mail_params['mail_smtp_enc'];
			}
			return $this;
		}
		private function sendMailTransport(){
			$this->mail->isSendmail();
			return $this;
		}


















	}














