<?php
class IPConfig {
const company = "Thexyz.com";
const email = "support@thexyz.com";
const logo_url = "https://www.thexyz.com/images/logo.gif";
const logo_link = "https://www.thexyz.com";
const submit_text = "Submit to Support";
const confirmation_header = "Thank you for sending us your IP.";
const confirmation_message = "Someone from support will respond shortly.";
const ga_code = "UA-38208521-1";
const use_smtp = "true";
const smtp_host = "secure.emailsrvr.com";
const smtp_auth = "true";
const smtp_user = "support@thexyz.com";
const smtp_pass = "SimonSays2244";
const smtp_encryption = "ssl";
const smtp_port = "465";
static function hasAnalytics() {$gacode = self::ga_code;return !empty($gacode);}}