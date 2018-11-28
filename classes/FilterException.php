<?php
  class FilterException  extends Exception
  {
    protected $message;
    function __construct(String $message)
    {
      $this->setMessage($message);
    }

    function setMessage(String $message)
    {
      $sanitize = filter_var($message,FILTER_SANITIZE_STRING);
      return $this->message = $sanitize;
    }

    function showError(){
      return 'Erreur : '.$this->message;
    }
  }
