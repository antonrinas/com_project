<?php

namespace Main\Validator;

interface BaseValidatorInterface
{
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return array
     */
    public function getFormData();

    /**
     * @return array
     */
    public function getErrors();
}