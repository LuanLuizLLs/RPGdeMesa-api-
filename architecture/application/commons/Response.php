<?php

namespace Commons;

class Response {
  public $status = '';
  public $message = '';
  public $response = null;

  public function setSucess($message, $response)  {
    $this->status = 'success';
    $this->message = $message;
    $this->response = $response;
  }

  public function setError($message, $response) {
    $this->status = 'error';
    $this->message = $message;
    $this->response = $response;
  }

  public function setWarning($message, $response)  {
    $this->status = 'warning';
    $this->message = $message;
    $this->response = $response;
  }

  public function setInfo($message, $response)  {
    $this->status = 'info';
    $this->message = $message;
    $this->response = $response;
  }

  public function getResponse(): object {
    return (object) [
      'status' => $this->status,
      'message' => $this->message,
      'response' => $this->response,
    ];
  }
}