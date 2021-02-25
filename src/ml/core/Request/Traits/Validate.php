<?php

trait Masteryl_Request_Validate
{
    protected $validation_error;

    public function getValidationErrorMessage($def = 'Validation Error')
    {
        if (isset($this->validation_error) && !empty($this->validation_error['message'])) {
            return $this->validation_error['message'];
        }
        return $def;
    }

    public function validate($args = [], $email = false)
    {
        $valid = true;

        foreach ($args as $key => $val) {
            if (is_numeric($key)) {
                $key = $val;
            }

            if (empty($this->{$key})) {
                return false;
            }

            if ($key === 'email' && $email && !filter_var($this->{$key}, FILTER_VALIDATE_EMAIL)) {
                $this->validation_error = [
                    'field' => 'email',
                    'message' => 'Valid email required',
                ];

                $valid = false;
                break;
            } elseif (empty($this->{$key})) {
                $this->validation_error = [
                    'field' => $key,
                    'message' => 'Missing information',
                ];
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
