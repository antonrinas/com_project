<?php

namespace Main\Validator;

use Framework\Validator\Validator;
use Framework\Validator\ValidatorInterface;

abstract class BaseValidator implements BaseValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var array
     */
    protected $filters = [];

    protected $validators = [];

    /**
     * @var array
     */
    protected $errors;

    public function __construct($data = [])
    {
        $this->validator = new Validator();
        $this->validator->setFormElements($data);
        $this->validator->setElementsFilters($this->filters);
        $this->validator->setElementsValidators($this->validators);
    }

    public function setFormData($data)
    {
        $this->validator->setFormElements($data);
        $this->validator->setElementsFilters($this->filters);
        $this->validator->setElementsValidators($this->validators);
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if ($this->validator->isValid()) {
            return true;
        }
        $this->errors = $this->validator->getElementsErrors();
        foreach ($this->errors as $elementName => $errors) {
            $this->errors[$elementName] = implode(', ', $errors);
        }
        return false;
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        return $this->validator->getFormElements();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}