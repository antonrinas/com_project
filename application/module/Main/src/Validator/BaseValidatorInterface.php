<?php

namespace Main\Validator;

interface BaseValidatorInterface
{
    /**
     * @param array $data
     */
    public function setFormData($data);

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