<?php

namespace Form;


class BaseHandleRequest
{
    private $errors;

    public function setEerrorsForm(array $errors)
    {
        $this->errors = $errors;
    }

    public function getEerrorsForm()
    {
        return $this->errors;
    }
    public function isValid()
    {
        $result = empty($this->errors) ? true : false;
        return $result;
    }
    public function isSubmitted()
    {
        $result = empty($_POST) ? false : true;
        return $result;
    }
}