<?php

namespace pimax;


/**
 * Class  HandleMessageResponse
 *
 * kapil - 12/07/2016
 * @package pimax\Messages
 */
class HandleMessageResponse
{
    /**
     * @var string
     */
    protected $message = null;

    /**
     * @var string
     */
    protected $messageResponse = null;
    
     /**
     * default read option
     */
    const TYPE_READ = "read";
    
       /**
     * Dont read by default option
     * readMessageResponse need to be called separately
     */
    const TYPE_NOTREAD = "notread";

    /**
     * HandleMessageResponse constructor.
     *
     * @param $message
     * @param $messageResponse
     * @param $readMessage -read message by default or not 
     */
    public function __construct($message, $messageResponse,$readMessage=self::TYPE_READ)
    {  
        $this->message = $message;
        $this->messageResponse = $messageResponse;
        if($readMessage===self::TYPE_READ)
       $this->readMessageResponse();

    }

    /**
     * Read Message Response returned by fb server 
     *
     */
    public function readMessageResponse()
    {
       if(isset($this->messageResponse))//safe for null value
       { 
       if(!empty($this->messageResponse['error']))//error occured
           $this-> handleError($this->messageResponse['error']);
       else  //normal response
       {
      /* parameters present in messageResponse array
       * @param recipient_id
       * @param message_id
         */
       }
       }
       else
       error_log("handleMessageResponse- var messageResponse is null or not defined", 0);
}

 /**
     * handles error and act accordingly
     * @reference- https://developers.facebook.com/docs/messenger-platform/send-api-reference#errors
     */
   public function handleError($error)
{  
/* parameters available in error array
 * @param message -message corresponding to error 
 * @param code  - unique code corresponding to error type
 * @param fbtraceid  -trace id of error
 * @param type - category of error
 */
 
switch($error['code'])
{case 2:    error_log("Send message failure. Internal server error", 0);
           //try sending message again  
            break;
 case 4:    error_log("Application request limit reached or Too many send requests to phone number", 0);
           //cancel the message
            break;
 case 100:    error_log("Invalid fbid. or No matching user found", 0);
           //check user id
            break;
 case 190:    error_log("Invalid OAuth access token.", 0);
           //check token
            break;
 case 200:    error_log("Permission Errors", 0);
            
            break;
 case 551:    error_log("User blocked you", 0);
           //may delete user data from db  
            break;
 case 10303:    error_log("Invalid account_linking_token", 0);
            break;
  default:    error_log("new error may have been introduced consult Send api", 0);
                      
}

}

}
?>
